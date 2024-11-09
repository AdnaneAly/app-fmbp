<template>
    <div
        class="modal fade"
        id="EditImpotBoulanger"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Editer un impot le mois :  {{ editImpotBoulanger.month }}
                    </h4>
                    <button
                        type="button"
                        class="close"
                        @click="closeModal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="editForm"
                    >
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Etat</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editImpotBoulanger.type_recette"
                                        @change="etatImpot($event)"
                                    >
                                        <option value="" selected="selected">
                                            Selectionner...
                                        </option>
                                        <option>PAYE</option>
                                        <option>NONPAYE</option>
                                        <option>SEMIPAYE</option>
                                        <option>FERMER</option>
                                        <option>EXONERER</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="InputAddress">Facture</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputAddress"
                                        placeholder="Enter adresse"
                                        :disabled="
                                            editImpotBoulanger.type_recette === 'FERMER' ||
                                            editImpotBoulanger.type_recette === 'NONPAYE' ||
                                            editImpotBoulanger.type_recette === 'EXONERER'
                                        "
                                        v-model="editImpotBoulanger.numeroFacture"
                                    />
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputAddress">Montant</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputAddress"
                                        placeholder="Enter adresse"
                                        :disabled="editImpotBoulanger.type_recette !== 'SEMIPAYE'"
                                        v-model="editImpotBoulanger.montant"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="InputDate">Date </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editImpotBoulanger.date"
                                    />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        placeholder="Enter ..."
                                        v-model="editImpotBoulanger.description"
                                    ></textarea>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="closeModal"
                    >
                        Fermer
                    </button>
                    <button
                        form="editForm"
                        type="submit"
                        class="btn btn-success"
                    >
                        Soumettre
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script setup>
import axios from "axios";
import { reactive, watch } from "vue";
import { useSwalSuccess, useSwalError } from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);

const props = defineProps({

    recette_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    }
});


const editImpotBoulanger = reactive({
    boulanger_id: "",
    type_recette: "",
    created_by: 1,
    montant: "",
    numeroFacture: "",
    date: "",
    month: "",
    annee: "2024",
    description: "",
    messageError: {},
});

const openModal = () => {
    getImpotBoulangerById();
    $("#EditImpotBoulanger").modal("show");
};

const closeModal = () => {
    $("#EditImpotBoulanger").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("recette.update", { recette: props.recette_id });
    router.put(
        url,
        {
            boulanger_id: editImpotBoulanger.boulanger_id,
            type_recette: editImpotBoulanger.type_recette,
            montant: editImpotBoulanger.montant,
            numeroFacture: editImpotBoulanger.numeroFacture,
            date: editImpotBoulanger.date,
            month: editImpotBoulanger.month,
            description: editImpotBoulanger.description,
            created_by: editImpotBoulanger.created_by,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le boulangerie edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editImpotBoulanger.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getImpotBoulangerById = () => {
    axios
        .get(route("recette.edit", { recette: props.recette_id }))
        .then((response) => {
            editImpotBoulanger.id = response.data.recette.id;
            editImpotBoulanger.boulanger_id = response.data.recette.boulanger_id;
            editImpotBoulanger.type_recette = response.data.recette.type_recette;
            editImpotBoulanger.montant = response.data.recette.montant;
            editImpotBoulanger.numeroFacture = response.data.recette.numeroFacture;
            editImpotBoulanger.date = response.data.recette.date;
            editImpotBoulanger.month = response.data.recette.month;
            editImpotBoulanger.description = response.data.recette.description;
        })
        .catch((error) => {
            console.log(error);
        });
};

const etatImpot = (event) => {
    if( event.target.value == "PAYE" ) {
        editImpotBoulanger.montant = 55000
    }else{
        editImpotBoulanger.montant = 0
    }
};

watch(
    () => props.show,
    (newVal, oldVal) => {
        if (newVal) {
            openModal();
        } else {
            closeModal();
        }
    }
);
</script>
