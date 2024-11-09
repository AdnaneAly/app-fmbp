<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Liste des salaires</h1>
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
                                        <div class="col-md-4">
                                            <Link
                                                :href="route('salaire.create')"
                                                class="btn btn-success"
                                                ><i class="fa fa-plus"></i
                                                >Ajouter</Link
                                            >
                                        </div>


                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
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
                                            <th>Nombre Jours Travail</th>
                                            <th>Montant Jours Travail</th>
                                            <th>Montant Avance</th>
                                            <th>Montant Net Paye</th>
                                            <th style="width: 140px">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(salaire, index) in props.salaires.data">
                                            <td>{{ index + 1 }}.</td>
                                            <td>{{ salaire.employeur.name }}</td>
                                            <td>{{ salaire.employeur.tel }}</td>
                                            <td>{{ salaire.date }}</td>
                                            <td>{{ salaire.nombreJoursTravail }}</td>
                                            <td>{{ salaire.montantJoursTravail.toLocaleString() }} UM</td>
                                            <td>{{ salaire.montantAS.toLocaleString() }} UM</td>
                                            <td>{{ salaire.montantNet.toLocaleString() }} UM</td>
                                            <td class="d-flex gap-2 text-left">
                                                <a
                                                    style="margin-right: 10px"
                                                    class="btn btn-primary btn-sm"
                                                    href="#"
                                                >
                                                    <i class="fas fa-folder">
                                                    </i>
                                                </a>
                                                <Link

                                                    style="margin-right: 10px"
                                                    class="btn btn-info btn-sm"
                                                    :href="route('salaire.edit', {salaire: salaire.id})"
                                                >
                                                    <i
                                                        class="fas fa-pencil-alt"
                                                    >
                                                    </i>
                                                </Link>
                                                <button
                                                    @click="
                                                        deleteConfimation(
                                                            salaire.id
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
                                            <th>{{ returnTotalMJT().toLocaleString() }} UM</th>
                                            <th>{{ returnTotalMAS().toLocaleString() }} UM</th>
                                            <th>{{ returnTotalMNet().toLocaleString() }} UM</th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination
                                    :links="props.salaires.links"
                                    :prev="props.salaires.prev_page_url"
                                    :next="props.salaires.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
import EditSalaire from "./EditSalaire.vue";


const employeur_id = ref("");
const per_page = ref(5);
const editingSalaireId = ref(0);
const showModal = ref(false);

const props = defineProps({
    salaires: Object,
    employeurs: Object,
});

const modalClosed = () => {
    editingSalaireId.value = 0;
    showModal.value = false;
};

const openEditSalaire = (id) => {
    editingSalaireId.value = id;
    showModal.value = true;
};


const deleteSalaire = (id) => {
    const url = route("salaire.destroy", { salaire: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le salaire supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est type_salairee");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cet salaire";
    useSwalConfirm(message, () => {
        deleteSalaire(id);
    });
};


const returnTotalMJT = function () {
    var total = 0;
    props.salaires.data.forEach((element) => {
        total += element.montantJoursTravail;
    });
    return total;
};

const returnTotalMNet = function () {
    var total = 0;
    props.salaires.data.forEach((element) => {
        total += element.montantNet;
    });
    return total;
};

const returnTotalMAS = function () {
    var total = 0;
    props.salaires.data.forEach((element) => {
        total += element.montantAS;
    });
    return total;
};

const search = _.throttle(() => {
    const url = route("salaire.index", {
        employeur_id: employeur_id.value,
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
