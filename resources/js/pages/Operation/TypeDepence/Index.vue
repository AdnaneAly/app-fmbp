<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste de Type Depences</h1>
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
                                    <CreateTypeDepence />
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
                                            v-for="typedepence in props
                                                .typedepences.data"
                                        >
                                            <td>1.</td>
                                            <td>{{ typedepence.name }}</td>


                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditTypeDepence(
                                                            typedepence.id
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
                                                            typedepence.id
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
                                    :links="props.typedepences.links"
                                    :prev="props.typedepences.prev_page_url"
                                    :next="props.typedepences.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditTypeDepence
        :typedepence_id="editingTypeDepenceId"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import CreateTypeDepence from "./CreateTypeDepence.vue";
import EditTypeDepence from "./EditTypeDepence.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingTypeDepenceId = ref(0);
const showModal = ref(false);

const props = defineProps({
    typedepences: Object,
});

const modalClosed = () => {
    editingTypeDepenceId.value = 0;
    showModal.value = false;
};

const openEditTypeDepence = (id) => {
    editingTypeDepenceId.value = id;
    showModal.value = true;
};

const deleteTypeDepence = (id) => {
    const url = route("operationtypedepence.destroy", { typedepence: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le type depence supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer ce type depence";
    useSwalConfirm(message, () => {
        deleteTypeDepence(id);
    });
};
</script>
