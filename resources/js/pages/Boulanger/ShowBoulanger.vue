<template>
    <div dir="rtl" style="text-align: right;"  class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        إسم المخبزة : {{ props.boulanger.name }}
                    </h1>
                </div>
                <div class="col-sm-6 text-left">
                    <Link
                        :href="
                            route('boulanger.printDetail', {
                                id:props.boulanger.id
                            })
                        "
                        class="btn btn-info"
                        ><i class="fa fa-print"></i> سحب</Link
                    >
                </div>
            </div>
        </div>
    </div>

    <div dir="rtl" style="text-align: right;" class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-sm table-bordered">
                                    <thead>

                                        <tr>
                                                <th style="width: 5%">الرقم</th>
                                                <th style="width: 25%">تاريخ الجباية</th>
                                                <th style="width: 25%">تاريخ التسديد</th>
                                                <th style="width: 15%">رقم الوصل</th>
                                                <th style="width: 10%">الحالة</th>
                                                <th style="width: 20%">المبلغ المدفوع</th>
                                                <th style="width: 140px">
                                                العمليات
                                            </th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(month, index) in months"
                                            :key="index"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>{{ month }}</td>
                                            <td>
                                                {{
                                                    recetteImpot(month)
                                                        .length != 1
                                                        ? recetteImpot(month)
                                                              .date
                                                        : ""
                                                }}
                                            </td>
                                            <td>
                                                {{
                                                    recetteImpot(month)
                                                        .length != 1
                                                        ? recetteImpot(month)
                                                              .numeroFacture
                                                        : ""
                                                }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge"
                                                    :class="
                                                        recetteImpot(month)
                                                            .type_recette ===
                                                        'PAYE'
                                                            ? 'bg-success'
                                                            : recetteImpot(
                                                                  month
                                                              ).type_recette ===
                                                              'SEMIPAYE'
                                                            ? 'bg-warning'
                                                            : recetteImpot(
                                                                  month
                                                              ).type_recette ===
                                                              'FERMER'
                                                            ? 'bg-secondary'
                                                            : recetteImpot(
                                                                  month
                                                              ).type_recette ===
                                                              'EXONERER'
                                                            ? 'bg-info'
                                                            : 'bg-danger'
                                                    "
                                                    >{{
                                                        recetteImpot(month) !==
                                                        []
                                                            ? recetteImpot(
                                                                  month
                                                              ).type_recette
                                                            : ""
                                                    }}</span
                                                >
                                            </td>
                                            <th dir="ltr">
                                                {{
                                                    recetteImpot(month)
                                                        .length != 1
                                                        ? recetteImpot(
                                                              month
                                                          ).montant.toLocaleString() +
                                                          " UM"
                                                        : ""
                                                }}
                                            </th>
                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    style="margin-left: 10px"
                                                    class="btn btn-primary btn-sm"
                                                    @click="
                                                        addImpotBoulanger(month)
                                                    "
                                                    :disabled="
                                                        recetteImpot(month)
                                                            .length != 1
                                                    "
                                                >
                                                    <i class="fas fa-plus"> </i>
                                                </button>
                                                <button
                                                    @click="
                                                        openEditImpotBoulanger(
                                                            recetteImpot(month)
                                                                .id
                                                        )
                                                    "
                                                    style="margin-left: 10px"
                                                    class="btn btn-info btn-sm"
                                                    :disabled="
                                                        recetteImpot(month)
                                                            .length == 1
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
                                                            recetteImpot(month)
                                                                .id
                                                        )
                                                    "
                                                    class="btn btn-danger btn-sm"
                                                    :disabled="
                                                        recetteImpot(month)
                                                            .length == 1
                                                    "
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
                                            <th dir="ltr">
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
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <addImpot
        :mois="addingImpotMois"
        :boulanger_id="props.boulanger.id"
        :show="showModal2"
        @modal-closed="modalClosed"
    />

    <EditImpot
        :recette_id="editingBoulangerId"
        :show="showModal"
        @modal-closed="modalClosed2"
    />
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";
import addImpot from "./addImpot.vue";
import EditImpot from "./EditImpot.vue";

document.title = "Liste des impots 2024";

const editingBoulangerId = ref(0);
const addingImpotMois = ref("");
const showModal = ref(false);
const showModal2 = ref(false);
const months = [
    "JANVIER",
    "FEVRIER",
    "MARS",
    "AVRIL",
    "MAI",
    "JUIN",
    "JUILLET",
    "AOUT",
    "SEPTEMBRE",
    "OCTOBRE",
    "NOVEMBRE",
    "DECEMENBRE",
];

const props = defineProps({
    boulanger: Object,
    recettes: Object,
});

let createModel = "";

onMounted(() => {
    createModel = $("#addImpotBolanger");
});

const modalClosed = () => {
    addingImpotMois.value = "";
    editingBoulangerId.value = 0;
    showModal2.value = false;
};

const modalClosed2 = () => {
    editingBoulangerId.value = 0;
    showModal.value = false;
};

const addImpotBoulanger = (id) => {
    addingImpotMois.value = id;
    showModal2.value = true;
};

const openEditImpotBoulanger = (id) => {
    editingBoulangerId.value = id;
    showModal.value = true;
};

const deleteImpotBoulanger = (id) => {
    const url = route("recette.destroy", { recette: id });
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
        deleteImpotBoulanger(id);
    });
};

const recetteImpot = (monthId) => {
    let impots = Object;
    for (let recette of props.recettes) {
        if (recette.month == monthId) {
            impots = recette;
        }
    }
    return impots;
};

const returnTotal = function () {
    var total = 0;
    props.recettes.forEach((element) => {
        total += element.montant;
    });
    return total;
};
</script>
