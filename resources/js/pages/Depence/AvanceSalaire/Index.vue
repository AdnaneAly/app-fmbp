<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des avance salaires</h1>
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
                                    <div class="row">
                                        <div class="col-md-3">
                                            <CreateAvanceSalaire
                                                :employeurs="props.employeurs"
                                            />
                                        </div>

                                        <div class="col-md-3">
                                            <select
                                                @change="search"
                                                v-model="employeur_id"
                                                class="form-control ml-3"
                                            >
                                                <option value="" selected>
                                                    Employeur...
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
                                        <div class="col-md-3">
                                            <select
                                                @change="search"
                                                v-model="etatDepence"
                                                class="form-control ml-3"
                                            >
                                                <option value="">Etat...</option>
                                                <option value="paye">Paye</option>
                                                <option value="noPaye">NonPaye</option>
                                            </select>
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
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Employeur</th>
                                            <th>Telephone</th>
                                            <th>Date</th>
                                            <th>Montant Avance</th>
                                            <th>Etat</th>
                                            <th style="width: 140px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(
                                                avancesalaire, index
                                            ) in props.avancesalaires.data"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>
                                                {{
                                                    avancesalaire.employeur.name
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    avancesalaire.employeur.tel
                                                }}
                                            </td>
                                            <td>{{ avancesalaire.date }}</td>
                                            <td>
                                                {{
                                                    avancesalaire.montantAvanceSalaire.toLocaleString()
                                                }} UM
                                            </td>
                                            <td>
                                                <span class="badge " :class="avancesalaire.etat === 'paye' ? 'bg-success' : 'bg-danger'" >{{
                                                    avancesalaire.etat
                                                }}</span>
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
                                                    style="margin-right: 10px"
                                                    class="btn btn-info btn-sm"
                                                    @click="
                                                        openEditAvanceSalaire(
                                                            avancesalaire.id
                                                        )
                                                    "
                                                >
                                                    <i
                                                        class="fas fa-pencil-alt"
                                                    >
                                                    </i>
                                                </button>
                                                <button
                                                    @click="
                                                        deleteConfimation(
                                                            avancesalaire.id
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
                                            <td colspan="2"></td>
                                            <th>{{ returnTotal().toLocaleString() }} UM</th>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination
                                    :links="props.avancesalaires.links"
                                    :prev="props.avancesalaires.prev_page_url"
                                    :next="props.avancesalaires.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditAvanceSalaire
        :avancesalaire_id="editingAvanceSalaireId"
        :employeurs="props.employeurs"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";
import EditAvanceSalaire from "./EditAvanceSalaire.vue";
import CreateAvanceSalaire from "./CreateAvanceSalaire.vue";

const employeur_id = ref("");
const per_page = ref(5);
const editingAvanceSalaireId = ref(0);
const showModal = ref(false);
const etatDepence = ref("");

const props = defineProps({
    avancesalaires: Object,
    employeurs: Object,
});

const modalClosed = () => {
    editingAvanceSalaireId.value = 0;
    showModal.value = false;
};

const openEditAvanceSalaire = (id) => {
    editingAvanceSalaireId.value = id;
    showModal.value = true;
};



const deleteAvanceSalaire = (id) => {
    const url = route("avancesalaire.destroy", { avancesalaire: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("L'avance salaire supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError(errors[0]);
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cet avancesalaire";
    useSwalConfirm(message, () => {
        deleteAvanceSalaire(id);
    });
};


const returnTotal = function () {
    var total = 0;
    props.avancesalaires.data.forEach((element) => {
        total += element.montantAvanceSalaire;
    });
    return total;
};

const search = _.throttle(() => {
    const url = route("avancesalaire.index", {
        employeur_id: employeur_id.value,
        per_page: per_page.value,
        etatDepence: etatDepence.value,
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
