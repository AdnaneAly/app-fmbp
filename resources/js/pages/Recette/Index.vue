<template>
    <section dir="rtl" style="text-align: right;" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan" ><i class="fas fa-bars"></i> قائمة المداخيل</h4>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div dir="rtl" style="text-align: right;" class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-2 ">
                                        <select
                                            @change="search"
                                            v-model="boulanger_id"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                المخابز...
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
                                    <div class="col-md-2 ">
                                        <select
                                            @change="search"
                                            v-model="month"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                شهر الجباية...
                                            </option>
                                            <option value="JANVIER">
                                                يناير
                                            </option>
                                            <option value="FEVRIER">
                                                قبراير
                                            </option>
                                            <option value="MARS">مارس</option>
                                            <option value="AVRIL">ابريل</option>
                                            <option value="MAI">مايو</option>
                                            <option value="JUIN">يونيو</option>
                                            <option value="JUILLET">
                                                يوليو
                                            </option>
                                            <option value="AOUT">اغصطس</option>
                                            <option value="SEPTEMBRE">
                                                سبتمبر
                                            </option>
                                            <option value="OCTOBRE">
                                                اكتوبر
                                            </option>
                                            <option value="NOVEMBRE">
                                                نوفمبر
                                            </option>
                                            <option value="DECEMENBRE">
                                                دجمبر
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <select
                                            @change="search"
                                            v-model="monthPaye"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                شهر التسديد...
                                            </option>
                                            <option value="1">يناير</option>
                                            <option value="2">قبراير</option>
                                            <option value="3">مارس</option>
                                            <option value="4">ابريل</option>
                                            <option value="5">مايو</option>
                                            <option value="6">يونيو</option>
                                            <option value="7">يوليو</option>
                                            <option value="8">اغصطس</option>
                                            <option value="9">سبتمبر</option>
                                            <option value="10">اكتوبر</option>
                                            <option value="11">نوفمبر</option>
                                            <option value="12">
                                                دجمبر
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <input
                                            @keyup="search"
                                            v-model="searchFacture"
                                            type="text"
                                            class="form-control"
                                            placeholder="ادحل رقم الوصل هنا..."
                                        />
                                    </div>
                                    <div class="col-md-2 ">
                                        <select
                                            @change="search"
                                            v-model="etatImpot"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                حالة الجباية...
                                            </option>
                                            <option value="PAYE">دفعت</option>
                                            <option value="SEMIPAYE">
                                                تسوية
                                            </option>
                                            <option value="FERMER">
                                                مغلقة
                                            </option>
                                            <option value="EXONERER">
                                                إعفاء
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-1 ">
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
                                    <div class="col-md-1 ">
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
                                            سحب</Link
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>المخابز</th>
                                            <th>شهر الجباية</th>
                                            <th>تاريخ التسديد</th>
                                            <th>رقم الوصل</th>
                                            <th>الحالة </th>
                                            <th>المبلغ</th>
                                            <th style="width: 120px">عمليات</th>
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
                                            <td>{{ monthImpot[recette.month] }}</td>
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
                                                        etatImpotAR[recette.type_recette]
                                                    }}</span
                                                >
                                            </td>
                                            <th dir="ltr">
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
                                                    style="margin-left: 10px"
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
                                            <th colspan="6">المجموع :</th>
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

const etatImpotAR = {
    'PAYE': 'دفعت',
    'SEMIPAYE': 'تسوية',
    'FERMER': 'مغلقة',
    'EXONERER': 'إعفاء',
}
const monthImpot = {
    'JANVIER': 'يناير',
    'FEVRIER': 'قبراير',
    'MARS': 'مارس',
    'AVRIL': 'ابريل',
    'MAI': 'مايو',
    'JUIN': 'يونيو',
    'JUILLET': 'يوليو',
    'AOUT': 'اغصطس',
    'SEPTEMBRE': 'سبتمبر',
    'OCTOBRE': 'اكتوبر',
    'NOVEMBRE': 'نوفمبر',
    'DECEMENBRE': 'دجمبر'
}
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
