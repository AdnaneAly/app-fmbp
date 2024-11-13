<template>
    <section dir="rtl" style="text-align: right;" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan" ><i class="fas fa-bars"></i> قائمة مصاريف الرواتب</h4>
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
                                    <div class="col-md-1">
                                        <Link
                                            :href="route('salaire.create')"
                                            class="btn btn-success"
                                            ><i class="fa fa-plus"></i
                                            > إضافة</Link
                                        >
                                    </div>

                                    <div class="col-md-2">
                                        <select
                                            @change="search"
                                            v-model="employeur_id"
                                            class="form-control ml-3"
                                        >
                                            <option value="" selected>
                                                العمال...
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
                                    <div class="col-md-2">
                                            <select
                                                @change="search"
                                                v-model="month"
                                                class="form-control ml-3"
                                            >
                                            <option value="" selected>
                                                    شهر الرواتب...
                                                </option>
                                                <option value="1">يناير</option>
                                            <option value="2">قبراير</option>
                                            <option value="3">مارس</option>
                                            <option value="4">ابريل</option>
                                            <option value="5">مايو</option>
                                            <option value="6">يونيو</option>
                                            <option value="7">يوليو</option>
                                            <option value="8">اغسطس</option>
                                            <option value="9">سبتمبر</option>
                                            <option value="10">اكتوبر</option>
                                            <option value="11">نوفمبر</option>
                                            <option value="12">
                                                دجمبر
                                            </option>
                                            </select>
                                    </div>
                                    <div class="col-md-2">
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
                                    <div class="col-md-2 ml-3">
                                        <Link
                                            :href="route('salaire.print', {per_page, employeur_id, month })"
                                            class="btn btn-info"
                                            ><i class="fa fa-print"></i
                                            > سحب</Link
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>العمال</th>
                                            <th>الهاتف</th>
                                            <th>التاريخ</th>
                                            <th> أيام العمل</th>
                                            <th>المبلغ المقابل</th>
                                            <th>المبلغ المقتطع</th>
                                            <th>المبلغ بعد الاقتطاع</th>
                                            <th style="width: 100px">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(salaire, index) in props.salaires.data" :key="index">
                                            <td>{{ index + 1 }}.</td>
                                            <td>{{ salaire.employeur.name }}</td>
                                            <td dir="ltr">{{ salaire.employeur.tel }}</td>
                                            <td>{{ salaire.date }}</td>
                                            <td>{{ salaire.nombreJoursTravail }}</td>
                                            <th dir="ltr">{{ salaire.montantJoursTravail.toLocaleString() }} UM</th>
                                            <th dir="ltr">{{ salaire.montantAS.toLocaleString() }} UM</th>
                                            <th dir="ltr">{{ salaire.montantNet.toLocaleString() }} UM</th>
                                            <td class="d-flex gap-2 text-left">

                                                <Link

                                                    style="margin-left: 10px"
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
                                            <th colspan="5">المجموع الكامل :</th>
                                            <th dir="ltr">{{ returnTotalMJT().toLocaleString() }} UM</th>
                                            <th dir="ltr">{{ returnTotalMAS().toLocaleString() }} UM</th>
                                            <th dir="ltr">{{ returnTotalMNet().toLocaleString() }} UM</th>
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
import { Link, router } from "@inertiajs/vue3";


const employeur_id = ref("");
const per_page = ref(5);
const month = ref("");
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
        month: month.value,
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
