<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste de Recettes</h1>
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
                                    <div class="col-md-2 ml-1">
                                        <select
                                            @change="search"
                                            v-model="boulanger_id"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                Boulangeries...
                                            </option>
                                            <option
                                                v-for="item in props.boulangers"
                                                :value="item.id"
                                                :key="item.id"
                                            >
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 ml-2">
                                        <select
                                            @change="search"
                                            v-model="month"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                Mois d'impot...
                                            </option>
                                            <option value="JANVIER">
                                                JANVIER
                                            </option>
                                            <option value="FEVRIER">
                                                FEVRIER
                                            </option>
                                            <option value="MARS">MARS</option>
                                            <option value="AVRIL">AVRIL</option>
                                            <option value="MAI">MAI</option>
                                            <option value="JUIN">JUIN</option>
                                            <option value="JUILLET">
                                                JUILLET
                                            </option>
                                            <option value="AOUT">AOUT</option>
                                            <option value="SEPTEMBRE">
                                                SEPTEMBRE
                                            </option>
                                            <option value="OCTOBRE">
                                                OCTOBRE
                                            </option>
                                            <option value="NOVEMBRE">
                                                NOVEMBRE
                                            </option>
                                            <option value="DECEMENBRE">
                                                DECEMENBRE
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 ml-2">
                                        <select
                                            @change="search"
                                            v-model="monthPaye"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                Mois de payement...
                                            </option>
                                            <option value="1">JANVIER</option>
                                            <option value="2">FEVRIER</option>
                                            <option value="3">MARS</option>
                                            <option value="4">AVRIL</option>
                                            <option value="5">MAI</option>
                                            <option value="6">JUIN</option>
                                            <option value="7">JUILLET</option>
                                            <option value="8">AOUT</option>
                                            <option value="9">SEPTEMBRE</option>
                                            <option value="10">OCTOBRE</option>
                                            <option value="11">NOVEMBRE</option>
                                            <option value="12">
                                                DECEMENBRE
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <input
                                            @keyup="search"
                                            v-model="searchFacture"
                                            type="text"
                                            class="form-control"
                                            placeholder="Search Facture"
                                        />
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <select
                                            @change="search"
                                            v-model="etatImpot"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                Etat d'impot...
                                            </option>
                                            <option value="PAYE">PAYE</option>
                                            <option value="SEMIPAYE">
                                                SEMIPAYE
                                            </option>
                                            <option value="FERMER">
                                                FERMER
                                            </option>
                                            <option value="EXONERER">
                                                EXONERER
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 ml-2">
                                        <select
                                            @change="search"
                                            v-model="per_page"
                                            class="form-control"
                                        >
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <Link
                                            :href="
                                                route('recette.print', {
                                                    per_page,
                                                    searchFacture,
                                                    boulanger_id,
                                                    etatImpot,
                                                    month,
                                                    monthPaye,
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
                                            <th>Boulangeries</th>
                                            <th>Mois d'impot</th>
                                            <th>Date de payement</th>
                                            <th>Facture</th>
                                            <th>Etat</th>
                                            <th>Montant</th>
                                            <th style="width: 100px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(recette, index) in props
                                                .recettes.data"
                                            :key="recette.id"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>
                                                {{ recette.boulanger.name }}
                                            </td>
                                            <td>{{ recette.month }}</td>
                                            <td>{{ recette.date }}</td>
                                            <td>{{ recette.numeroFacture }}</td>
                                            <td>
                                                <span
                                                    class="badge"
                                                    :class="
                                                        recette.type_recette ===
                                                        'PAYE'
                                                            ? 'bg-success'
                                                            : recette.type_recette ===
                                                              'SEMIPAYE'
                                                            ? 'bg-warning'
                                                            : recette.type_recette ===
                                                              'FERMER'
                                                            ? 'bg-secondary'
                                                            : recette.type_recette ===
                                                              'EXONERER'
                                                            ? 'bg-info'
                                                            : 'bg-danger'
                                                    "
                                                    >{{
                                                        recette.type_recette
                                                    }}</span
                                                >
                                            </td>
                                            <th>
                                                {{
                                                    recette.montant.toLocaleString()
                                                }}
                                                UM
                                            </th>
                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditRecette(
                                                            recette.id
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
                                                            recette.id
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
                                            <td colspan="4"></td>
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
                                    :links="props.recettes.links"
                                    :prev="props.recettes.prev_page_url"
                                    :next="props.recettes.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditRecette
        :recette_id="editingRecetteId"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import EditRecette from "./EditRecette.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingRecetteId = ref(0);
const showModal = ref(false);
const searchFacture = ref("");
const boulanger_id = ref("");
const month = ref("");
const monthPaye = ref("");
const per_page = ref(10);
const etatImpot = ref("");

const props = defineProps({
    recettes: Object,
    boulangers: Object,
});

const modalClosed = () => {
    editingRecetteId.value = 0;
    showModal.value = false;
};

const openEditRecette = (id) => {
    editingRecetteId.value = id;
    showModal.value = true;
};

const deleteRecette = (id) => {
    const url = route("recette.destroy", { recette: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le recetteie supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cette recetteie";
    useSwalConfirm(message, () => {
        deleteRecette(id);
    });
};

const returnTotal = function () {
    var total = 0;
    props.recettes.data.forEach((element) => {
        total += element.montant;
    });
    return total;
};

const search = _.throttle(() => {
    const url = route("recette.index", {
        numeroFacture: searchFacture.value,
        per_page: per_page.value,
        boulanger_id: boulanger_id.value,
        month: month.value,
        monthPaye: monthPaye.value,
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
