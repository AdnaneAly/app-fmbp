<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste de Boulangeries</h1>
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
                                <div class="row">
                                    <div class="col-md-1">
                                        <CreateBoulanger
                                            :proprietaires="props.proprietaires"
                                        />
                                    </div>
                                    <div class="col-md-2">
                                        <input
                                            @keyup="search"
                                            v-model="searchBoulanger"
                                            type="text"
                                            class="form-control ml-3"
                                            placeholder="Search Name"
                                        />
                                    </div>
                                    <div class="col-md-3">
                                        <select
                                            @change="search"
                                            v-model="proprietaire_id"
                                            class="form-control ml-3"
                                        >
                                            <option value="" selected>
                                                Proprietaire...
                                            </option>
                                            <option
                                                v-for="proprietaire in props.proprietaires"
                                                :value="proprietaire.id"
                                                :key="proprietaire.id"
                                            >
                                                {{ proprietaire.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-1">
                                        <select
                                            @change="search"
                                            v-model="per_page"
                                            class="form-control ml-3"
                                        >
                                            <option selected value="">
                                                Page...
                                            </option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <Link
                                            :href="
                                                route('boulanger.print', {
                                                    per_page,
                                                    searchBoulanger,
                                                    proprietaire_id,
                                                })
                                            "
                                            class="btn btn-info"
                                            ><i class="fa fa-print"></i>
                                            Imprimer</Link
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Proprietaire</th>
                                            <th>Etat</th>
                                            <th style="width: 140px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(boulanger, index) in props
                                                .boulangers.data"
                                            :key="boulanger.id"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>{{ boulanger.name }}</td>
                                            <td>{{ boulanger.address }}</td>
                                            <td>
                                                {{
                                                    boulanger.proprietaire.name
                                                }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge"
                                                    :class="
                                                        boulanger.etat ===
                                                        'active'
                                                            ? 'bg-success'
                                                            : 'bg-danger'
                                                    "
                                                    >{{ boulanger.etat }}</span
                                                >
                                            </td>
                                            <td class="d-flex gap-2 text-left">
                                                <Link
                                                    style="margin-right: 10px"
                                                    class="btn btn-primary btn-sm"
                                                    :href="
                                                        route(
                                                            'boulanger.show',
                                                            {
                                                                boulanger:
                                                                    boulanger.id,
                                                            }
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-folder">
                                                    </i>
                                                </Link>
                                                <button
                                                    @click="
                                                        openEditBoulanger(
                                                            boulanger.id
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
                                                            boulanger.id
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
                                    :links="props.boulangers.links"
                                    :prev="props.boulangers.prev_page_url"
                                    :next="props.boulangers.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditBoulanger
        :boulanger_id="editingBoulangerId"
        :proprietaires="props.proprietaires"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import CreateBoulanger from "./CreateBoulanger.vue";
import EditBoulanger from "./EditBoulanger.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";

document.title = "Liste des boulangeries";

const editingBoulangerId = ref(0);
const showModal = ref(false);
const searchBoulanger = ref("");
const proprietaire_id = ref("");
const per_page = ref("");

const props = defineProps({
    boulangers: Object,
    proprietaires: Object,
});

const modalClosed = () => {
    editingBoulangerId.value = 0;
    showModal.value = false;
};

const openEditBoulanger = (id) => {
    editingBoulangerId.value = id;
    showModal.value = true;
};

const deleteBoulanger = (id) => {
    const url = route("boulanger.destroy", { boulanger: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le boulangerie supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cette boulangerie";
    useSwalConfirm(message, () => {
        deleteBoulanger(id);
    });
};

const search = _.throttle(() => {
    const url = route("boulanger.index", {
        search: searchBoulanger.value,
        proprietaire_id: proprietaire_id.value,
        per_page: per_page.value,
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
