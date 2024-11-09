<template>
    <div
        class="modal fade"
        id="EditImpot"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Editer un impot le mois :  {{ editImpot.month }}
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
                                        v-model="editImpot.type_recette"
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
                                            editImpot.type_recette === 'FERMER' ||
                                            editImpot.type_recette === 'NONPAYE' ||
                                            editImpot.type_recette === 'EXONERER'
                                        "
                                        v-model="editImpot.numeroFacture"
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
                                        :disabled="editImpot.type_recette !== 'SEMIPAYE'"
                                        v-model="editImpot.montant"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="InputDate">Date </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editImpot.date"
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
                                        v-model="editImpot.description"
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


const editImpot = reactive({
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
    getImpotById();
    $("#EditImpot").modal("show");
};

const closeModal = () => {
    $("#EditImpot").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("recette.update", { recette: props.recette_id });
    router.put(
        url,
        {
            boulanger_id: editImpot.boulanger_id,
            type_recette: editImpot.type_recette,
            montant: editImpot.montant,
            numeroFacture: editImpot.numeroFacture,
            date: editImpot.date,
            month: editImpot.month,
            description: editImpot.description,
            created_by: editImpot.created_by,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le recette edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editImpot.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getImpotById = () => {
    axios
        .get(route("recette.edit", { recette: props.recette_id }))
        .then((response) => {
            editImpot.id = response.data.recette.id;
            editImpot.boulanger_id = response.data.recette.boulanger_id;
            editImpot.type_recette = response.data.recette.type_recette;
            editImpot.montant = response.data.recette.montant;
            editImpot.numeroFacture = response.data.recette.numeroFacture;
            editImpot.date = response.data.recette.date;
            editImpot.month = response.data.recette.month;
            editImpot.description = response.data.recette.description;
        })
        .catch((error) => {
            console.log(error);
        });
};

const etatImpot = (event) => {
    if( event.target.value == "PAYE" ) {
        editImpot.montant = 55000
    }else{
        editImpot.montant = 0
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
