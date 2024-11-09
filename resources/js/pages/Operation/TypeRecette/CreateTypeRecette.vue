<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createTypeRecette"
    >
        <i class="fa fa-plus"></i> Ajouter
    </button>

    <div
        class="modal fade"
        id="createTypeRecette"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter un type recette</h4>
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
                    <form action="" @submit.prevent="soumettre" id="createFormTypeRecette">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="InputName">Nom</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="Enter name"
                                        v-model="nameTypeRecette"
                                        :class="{'is-invalid': nameError != ''}"
                                    />
                                    <span v-if="nameError != ''" class="error invalid-feedback">{{ nameError }}</span>
                                </div>


                                <!-- /.form-group -->
                            </div>

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
                    <button type="submit" form="createFormTypeRecette" class="btn btn-success">
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
import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useSwalSuccess, useSwalError } from '../../../composables/alert';

const nameError = ref("");

const nameTypeRecette = ref("");

let createModel = "";

onMounted(() => {
    createModel = $("#createTypeRecette");
})

const closeModel = () => {
    createModel.modal("hide");
    nameTypeRecette.value = "";
};

const soumettre = () => {
    const name = nameTypeRecette.value
    const url = route("operationtyperecette.store")
    router.post(
                url,
                {name},
                {
                    onSuccess: (page) => {
                        closeModel();
                        // afficher un message de succes
                        useSwalSuccess("Le Type Recette ajouté avec succés")
                    },
                    onError: (errors) => {
                        // afficher un message d'error
                        if ( errors.name != null ) {
                            nameError.value = errors.name;
                        }
                        useSwalError("Une erreur s'est produite")
                    }
                }
            )
}
</script>
