<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des employeurs</h1>
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
                                <div class="card-title d-flex">
                                    <CreateEmployeur
                                        :grades="props.grades"
                                        :boulangers="props.boulangers"
                                    />
                                    <input
                                        @keyup="search"
                                        v-model="searchEmployeur"
                                        type="text"
                                        class="form-control ml-3"
                                        placeholder="Search Name"
                                    />
                                    <select
                                        @change="search"
                                        v-model="grade_id"
                                        class="form-control ml-3"
                                    >
                                    <option value="" selected>Grade...</option>
                                    <option v-for="item in props.grades" :value="item.id" :key="item.id" >{{ item.name }}</option>

                                    </select>
                                    <select
                                        @change="search"
                                        v-model="per_page"
                                        class="form-control ml-3"
                                    >
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Grade</th>
                                            <th>Etat</th>
                                            <th>Salaire</th>
                                            <th style="width: 140px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="employeur in props.employeurs
                                                .data" :key="employeur.id"
                                        >
                                            <td>1.</td>
                                            <td>{{ employeur.name }}</td>
                                            <td>{{ employeur.grade.name }}</td>
                                            <td>
                                                <span class="badge" :class="employeur.etat === 'active' ? 'bg-success' : 'bg-danger'">{{
                                                    employeur.etat
                                                }}</span>
                                            </td>
                                            <td>
                                                {{ employeur.montantSalaire }}
                                            </td>
                                            <td class="d-flex gap-2 text-left">
                                                <a
                                                    style="margin-right: 10px"
                                                    class="btn btn-primary btn-sm"
                                                    href="#"
                                                >
                                                    <i class="fas fa-folder">
                                                    </i>
                                                </a>
                                                <button
                                                    @click="
                                                        openEditEmployeur(
                                                            employeur.id
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
                                                            employeur.id
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
                                    :links="props.employeurs.links"
                                    :prev="props.employeurs.prev_page_url"
                                    :next="props.employeurs.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditEmployeur
        :employeur_id="editingEmployeurId"
        :grades="props.grades"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import CreateEmployeur from "./CreateEmployeur.vue";
import EditEmployeur from "./EditEmployeur.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingEmployeurId = ref(0);
const showModal = ref(false);
const searchEmployeur = ref("");
const grade_id = ref("");
const per_page = ref(5);

const props = defineProps({
    employeurs: Object,
    grades: Object,
});

const modalClosed = () => {
    editingEmployeurId.value = 0;
    showModal.value = false;
};

const openEditEmployeur = (id) => {
    editingEmployeurId.value = id;
    showModal.value = true;
};

const deleteEmployeur = (id) => {
    const url = route("employeur.destroy", { employeur: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le employeur supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cet employeur";
    useSwalConfirm(message, () => {
        deleteEmployeur(id);
    });
};

const search = _.throttle(() => {
    const url = route("employeur.index", {
        search: searchEmployeur.value,
        per_page: per_page.value,
        grade_id: grade_id.value,
    });
    router.get(
        url,
        {},
        {
            replace: true,
            preserveState: true,
        }
    );
}, 500);
</script>
