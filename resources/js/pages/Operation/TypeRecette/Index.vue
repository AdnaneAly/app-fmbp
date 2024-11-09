<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste de Type Recettes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Liste</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <CreateTypeRecette />
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nom</th>
                                            <th style="width: 100px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(typerecette, index) in props
                                                .typerecettes.data"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>{{ typerecette.name }}</td>

                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditTypeRecette(
                                                            typerecette.id
                                                        )
                                                    "
                                                    style="margin-right: 10px"
                                                    class="btn btn-info btn-sm"
                                                    href="#"
                                                >
                                                    <i
                                                        class="fas fa-pencil-alt"
                                                    >
                                                    </i>
                                                </button>
                                                <button
                                                    @click="
                                                        deleteConfimation(
                                                            typerecette.id
                                                        )
                                                    "
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination
                                    :links="props.typerecettes.links"
                                    :prev="props.typerecettes.prev_page_url"
                                    :next="props.typerecettes.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditTypeRecette
        :typerecette_id="editingTypeRecetteId"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import CreateTypeRecette from "./CreateTypeRecette.vue";
import EditTypeRecette from "./EditTypeRecette.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingTypeRecetteId = ref(0);
const showModal = ref(false);

const props = defineProps({
    typerecettes: Object,
});

const modalClosed = () => {
    editingTypeRecetteId.value = 0;
    showModal.value = false;
};

const openEditTypeRecette = (id) => {
    editingTypeRecetteId.value = id;
    showModal.value = true;
};

const deleteTypeRecette = (id) => {
    const url = route("operationtyperecette.destroy", { typerecette: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le type recette supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer ce type recette";
    useSwalConfirm(message, () => {
        deleteTypeRecette(id);
    });
};
</script>
