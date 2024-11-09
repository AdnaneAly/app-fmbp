<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createAutreRecette"
    >
        <i class="fa fa-plus"></i> Ajouter
    </button>

    <div
        class="modal fade"
        id="createAutreRecette"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une autre recette</h4>
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
                        id="createFormAutreRecette"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type de recette</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="form.type_recette_id"
                                        :class="{
                                            'is-invalid':
                                                form.errors.type_recette_id,
                                        }"
                                    >
                                        <option
                                            v-for="item in props.typerecettes"
                                            :value="item.id"
                                            :key="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <span
                                        v-if="form.errors.type_recette_id"
                                        class="error invalid-feedback"
                                        >{{ form.errors.type_recette_id }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputMontant">Montant</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontant"
                                        placeholder="Enter montant"
                                        v-model="form.montant"
                                        :class="{
                                            'is-invalid': form.errors.montant,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.montant"
                                        class="error invalid-feedback"
                                        >{{ form.errors.montant }}</span
                                    >
                                </div>


                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputDate">Date</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="form.date"
                                        :class="{
                                            'is-invalid': form.errors.date,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.date"
                                        class="error invalid-feedback"
                                        >{{ form.errors.date }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputFacture">Facture</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputFacture"
                                        placeholder="Enter facture"
                                        v-model="form.numeroFacture"


                                    />
                                    <span
                                        v-if="form.errors.date"
                                        class="error invalid-feedback"
                                        >{{ form.errors.date }}</span
                                    >
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
                                        v-model="form.description"
                                    ></textarea>
                                    <input
                                        type="hidden"
                                        name="created_by"
                                        v-model="form.created_by"
                                    />
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
                        form="createFormAutreRecette"
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
import { onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";

const form = useForm({
    date: "",
    numeroFacture: "",
    type_recette_id: 0,
    created_by: 1,
    montant: "",
    description: "",
    annee: "2024",
});


const props = defineProps({
    typerecettes: Object,
});

let createModel = "";

onMounted(() => {
    createModel = $("#createAutreRecette");
});

const closeModel = () => {
    createModel.modal("hide");
    form.reset()
};

const soumettre = () => {
    form.post(route("autrerecette.store"), {
        onSuccess: (page) => {
            // afficher un message de succes
            closeModel();
            useSwalSuccess("Le autrerecetteie ajouté avec succés");
            form.reset();
        },
        onError: (errors) => {
            console.log(errors);
            useSwalError("Une erreur s'est produite");
            console.log(errors);
        },
    });
};
</script>
