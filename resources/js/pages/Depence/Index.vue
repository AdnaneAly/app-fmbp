<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des depences</h1>
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
                                            v-model="type_depence_id"
                                            class="form-control "
                                        >
                                            <option value="" selected>
                                                Type depence...
                                            </option>
                                            <option
                                                v-for="item in props.typedepences"
                                                :value="item.id"
                                                :key="item.id"
                                            >
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <select
                                            @change="search"
                                            v-model="employeur_id"
                                            class="form-control "
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
                                    <div class="col-md-2 ml-2">
                                        <select
                                            @change="search"
                                            v-model="month"
                                            class="form-control "
                                        >
                                            <option value="" selected>
                                                Mois de depence...
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
                                    <div class="col-md-1 ml-2">
                                        <select
                                            @change="search"
                                            v-model="per_page"
                                            class="form-control "
                                        >
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 ml-2">
                                        <Link
                                            :href="route('depence.create')"
                                            class="btn btn-success"
                                            ><i class="fa fa-plus"></i
                                            > Ajouter</Link
                                        >
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <Link
                                            :href="
                                                route('depence.print', {
                                                    per_page,
                                                    employeur_id,
                                                    type_depence_id,
                                                    month,
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
                                            <th>Type depences</th>
                                            <th>Employeur</th>
                                            <th>Date</th>
                                            <th>Montant</th>
                                            <th style="width: 100px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(depence, index) in props
                                                .depences.data"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>
                                                {{ depence.type_depence.name }}
                                            </td>
                                            <td>
                                                {{
                                                    depence.employeur === null
                                                        ? ""
                                                        : depence.employeur.name
                                                }}
                                            </td>
                                            <td>{{ depence.date }}</td>
                                            <td>
                                                {{
                                                    depence.montant.toLocaleString()
                                                }}
                                                MU
                                            </td>
                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    style="margin-right: 10px"
                                                    class="btn btn-info btn-sm"
                                                    @click="
                                                        openEditDepence(
                                                            depence.id
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
                                                            depence.id
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
                                    :links="props.depences.links"
                                    :prev="props.depences.prev_page_url"
                                    :next="props.depences.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditDepence
        :depence_id="editingDepenceId"
        :typedepences="props.typedepences"
        :employeurs="props.employeurs"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";
import EditDepence from "./EditDepence.vue";

const employeur_id = ref("");
const type_depence_id = ref("");
const per_page = ref(5);
const month = ref("");
const editingDepenceId = ref(0);
const showModal = ref(false);

const props = defineProps({
    depences: Object,
    typedepences: Object,
    employeurs: Object,
});

const modalClosed = () => {
    editingDepenceId.value = 0;
    showModal.value = false;
};

const openEditDepence = (id) => {
    editingDepenceId.value = id;
    showModal.value = true;
};

const deleteDepence = (id) => {
    const url = route("depence.destroy", { depence: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le depence supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est type_depencee");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cet depence";
    useSwalConfirm(message, () => {
        deleteDepence(id);
    });
};

const returnTotal = function () {
    var total = 0;
    props.depences.data.forEach((element) => {
        total += element.montant;
    });
    return total;
};

console.log(props.depences.data);

const search = _.throttle(() => {
    const url = route("depence.index", {
        employeur_id: employeur_id.value,
        per_page: per_page.value,
        month: month.value,
        type_depence_id: type_depence_id.value,
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
