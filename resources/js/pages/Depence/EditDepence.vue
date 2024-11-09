<template>
    <div
        class="modal fade"
        id="EditDepence"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Editer une depence {{ editDepence.nameDepence }}
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
                    <form action="" @submit.prevent="soumettre" id="editForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputDate">Date</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editDepence.dateDepence"
                                        :class="{
                                            'is-invalid':
                                                editDepence.messageError.hasOwnProperty(
                                                    'date'
                                                ),
                                        }"
                                    />
                                    <span
                                        v-if="
                                            editDepence.messageError.hasOwnProperty(
                                                'date'
                                            )
                                        "
                                        class="error invalid-feedback"
                                        >{{
                                            editDepence.messageError.date
                                        }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Employeur</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editDepence.employeurIdDepence"
                                    >
                                        <option value="" selected="selected">
                                            Selectionner...
                                        </option>
                                        <option
                                            v-for="item in props.employeurs"
                                            :value="item.id"
                                            :key="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de depence</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="
                                            editDepence.typedepenceIdDepence
                                        "
                                    >
                                        <option value="" selected="selected">
                                            Selectionner...
                                        </option>
                                        <option
                                            v-for="item in props.typedepences"
                                            :value="item.id"
                                            :key="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="InputMontant">Montant</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontant"
                                        placeholder="Enter montant"
                                        v-model="editDepence.montantDepence"
                                        :class="{
                                            'is-invalid':
                                                editDepence.messageError.hasOwnProperty(
                                                    'montant'
                                                ),
                                        }"
                                    />
                                    <span
                                        v-if="
                                            editDepence.messageError.hasOwnProperty(
                                                'montant'
                                            )
                                        "
                                        class="error invalid-feedback"
                                        >{{
                                            editDepence.messageError.montant
                                        }}</span
                                    >
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        placeholder="Enter ..."
                                        v-model="editDepence.descriptionDepence"
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
    depence_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    employeurs: Object,
    typedepences: Object,
});

const editDepence = reactive({
    id: "",
    typedepenceIdDepence: "",
    employeurIdDepence: "",
    montantDepence: "",
    dateDepence: "",
    descriptionDepence: "",
    annee: "2024",
    created_by: 1,
    messageError: {},
});

const openModal = () => {
    getDepenceById();
    $("#EditDepence").modal("show");
};

const closeModal = () => {
    $("#EditDepence").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("depence.update", { depence: props.depence_id });
    router.put(
        url,
        {
            type_depence_id: editDepence.typedepenceIdDepence,
            employeur_id: editDepence.employeurIdDepence,
            montant: editDepence.montantDepence,
            date: editDepence.dateDepence,
            created_by: editDepence.created_by,
            description: editDepence.descriptionDepence,
            annee: editDepence.annee,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le depence edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editDepence.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getDepenceById = () => {
    axios
        .get(route("depence.edit", { depence: props.depence_id }))
        .then((response) => {
            editDepence.id = response.data.depence.id;
            editDepence.typedepenceIdDepence =
                response.data.depence.type_depence_id;
            editDepence.employeurIdDepence = response.data.depence.employeur_id;
            editDepence.montantDepence = response.data.depence.montant;
            editDepence.dateDepence = response.data.depence.date;
            editDepence.descriptionDepence = response.data.depence.description;
        })
        .catch((error) => {
            console.log(error);
        });
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
