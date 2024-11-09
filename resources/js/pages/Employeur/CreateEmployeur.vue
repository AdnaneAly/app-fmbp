<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createEmployeur"
    >
        <i class="fa fa-plus"></i> Ajouter
    </button>

    <div
        class="modal fade"
        id="createEmployeur"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un employeur</h4>
                    <button
                        type="button"
                        @click="closeModel"
                        class="close"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="createFormEmployeur"
                    >
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="InputName">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="Enter name"
                                        v-model="nameEmployeur"
                                        :class="{
                                            'is-invalid': nameError != '',
                                        }"
                                    />
                                    <span
                                        v-if="nameError != ''"
                                        class="error invalid-feedback"
                                        >{{ nameError }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputTel">Telephone</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputTel"
                                        placeholder="Enter tel"
                                        v-model="telEmployeur"
                                        :class="{
                                            'is-invalid': telError != '',
                                        }"
                                    />
                                    <span
                                        v-if="telError != ''"
                                        class="error invalid-feedback"
                                        >{{ telError }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Etat</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="etatEmployeur"
                                    >
                                        <option selected="selected">
                                            Selectionner...
                                        </option>
                                        <option>active</option>
                                        <option>noActive</option>
                                    </select>
                                </div>


                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Grade</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="gradeIdEmployeur"
                                    >
                                        <option v-for="item in props.grades" :value="item.id" :key="item.id" >{{ item.name }}</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="InputNNI">NNI</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputNNI"
                                        placeholder="Enter nni"
                                        v-model="nniEmployeur"
                                        :class="{
                                            'is-invalid': nniError != '',
                                        }"
                                    />
                                    <span
                                        v-if="nniError != ''"
                                        class="error invalid-feedback"
                                        >{{ nniError }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea
                                        class="form-control"
                                        rows="1"
                                        placeholder="Enter ..."
                                        v-model="descriptionEmployeur"
                                    ></textarea>
                                </div>


                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="InputDate">Date de recrutement</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="dateEmployeur"
                                        :class="{
                                            'is-invalid': dateError != '',
                                        }"
                                    />
                                    <span
                                        v-if="dateError != ''"
                                        class="error invalid-feedback"
                                        >{{ dateError }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputMontantSalaire">montant Salaire</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontantSalaire"
                                        placeholder="Enter montant salaire"
                                        v-model="montantsalaireEmployeur"
                                        :class="{
                                            'is-invalid': montantsalaireError != '',
                                        }"
                                    />
                                    <span
                                        v-if="montantsalaireError != ''"
                                        class="error invalid-feedback"
                                        >{{ montantsalaireError }}</span
                                    >
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
                        @click="closeModel"
                    >
                        Fermer
                    </button>
                    <button
                        type="submit"
                        form="createFormEmployeur"
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
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../composables/alert";


const nameError = ref("");
const dateError = ref("");
const telError = ref("");
const montantsalaireError = ref("");
const nniError = ref("");

const nameEmployeur = ref("");
const gradeIdEmployeur = ref("");
const etatEmployeur = ref("");
const descriptionEmployeur = ref("");
const nniEmployeur = ref("");
const dateEmployeur = ref("");
const montantsalaireEmployeur = ref("");
const telEmployeur = ref("");

const props = defineProps({
    grades: Object,
    boulangers: Object,
});

let createModel = "";

onMounted(() => {
    createModel = $("#createEmployeur");
});

const closeModel = () => {
    createModel.modal("hide");
    nameEmployeur.value = "";
    gradeIdEmployeur.value = "";
    etatEmployeur.value = "";
    descriptionEmployeur.value = "";
    montantsalaireEmployeur.value = "";
    nniEmployeur.value = "";
    dateEmployeur.value = "";
    telEmployeur.value = "";
};

const soumettre = () => {
    const name = nameEmployeur.value;
    const tel = telEmployeur.value;
    const nni = nniEmployeur.value;
    const date = dateEmployeur.value;
    const montantSalaire = montantsalaireEmployeur.value;
    const grade_id = gradeIdEmployeur.value;
    const etat = etatEmployeur.value;
    const description = descriptionEmployeur.value;
    const url = route("employeur.store");
    router.post(
        url,
        { name, grade_id, montantSalaire, tel, nni, date, etat, description },
        {
            onSuccess: (page) => {
                closeModel();
                // afficher un message de succes
                useSwalSuccess("L\'mployeur ajouté avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.name != null) {
                    nameError.value = errors.name;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};
</script>
