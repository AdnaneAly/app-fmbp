<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des Autre Recettes</h1>
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
                                    <div class="col-md-3">
                                            <Link
                                                :href="route('autrerecette.create')"
                                                class="btn btn-success"
                                                ><i class="fa fa-plus"></i
                                                >Ajouter</Link
                                            >
                                        </div>
                                    <div class="col-md-3">
                                            <select
                                                @change="search"
                                                v-model="typerecette_id"
                                                class="form-control ml-3"
                                            >
                                                <option value="" selected>
                                                    Type recettes...
                                                </option>
                                                <option
                                                    v-for="item in props.typerecettes"
                                                    :value="item.id"
                                                    :key="item.id"
                                                >
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>
                                    <div class="col-md-3">
                                        <input
                                            @keyup="search"
                                            v-model="searchFacture"
                                            type="text"
                                            class="form-control ml-3"
                                            placeholder="Search Facture"
                                        />
                                    </div>

                                    <div class="col-md-3">
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
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Type de autrerecette</th>
                                            <th>Decriptions</th>
                                            <th>Facture</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th style="width: 100px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(autrerecette, index) in props
                                                .autrerecettes.data"
                                            :key="autrerecette.id"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>
                                                {{ autrerecette.typerecette.name }}
                                            </td>
                                            <td>{{ autrerecette.description }}</td>
                                            <td>{{ autrerecette.numeroFacture }}</td>
                                            <td>{{ autrerecette.date }}</td>
                                            <th>
                                                {{
                                                    autrerecette.montant.toLocaleString()
                                                }}
                                                UM
                                            </th>
                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditAutreRecette(
                                                            autrerecette.id
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
                                                            autrerecette.id
                                                        )
                                                    "
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total:</th>
                                            <td colspan="3"></td>
                                            <th>
                                                {{
                                                    returnTotal().toLocaleString()
                                                }}
                                                UM
                                            </th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination
                                    :links="props.autrerecettes.links"
                                    :prev="props.autrerecettes.prev_page_url"
                                    :next="props.autrerecettes.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditAutreRecette
        :autrerecette_id="editingAutreRecetteId"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import EditAutreRecette from "./EditAutreRecette.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingAutreRecetteId = ref(0);
const showModal = ref(false);
const searchFacture = ref("");
const typerecette_id = ref("");
const month = ref("");
const per_page = ref(5);
const etatImpot = ref("");

const props = defineProps({
    autrerecettes: Object,
    typerecettes: Object,
});

const modalClosed = () => {
    editingAutreRecetteId.value = 0;
    showModal.value = false;
};

const openEditAutreRecette = (id) => {
    editingAutreRecetteId.value = id;
    showModal.value = true;
};

const deleteAutreRecette = (id) => {
    const url = route("autrerecette.destroy", { autrerecette: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le autrerecetteie supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cette autrerecetteie";
    useSwalConfirm(message, () => {
        deleteAutreRecette(id);
    });
};

const returnTotal = function () {
    var total = 0;
    props.autrerecettes.data.forEach((element) => {
        total += element.montant;
    });
    return total;
};

const search = _.throttle(() => {
    const url = route("autrerecette.index", {
        numeroFacture: searchFacture.value,
        per_page: per_page.value,
        typerecette_id: typerecette_id.value,
        month: month.value,
        etatImpot: etatImpot.value,
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
