<template>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <div class="position-relative">
                            <img
                                src="~admin-lte/dist/img/cover-01.png"
                                alt="Photo 1"
                                class="img-fluid"
                            />
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div style="margin-top: 2em" dir="rtl" class="row">
                    <div class="col-sm-12">
                        <table class="table no-border">
                            <tbody>
                                <tr>
                                <td
                                    style="
                                        text-align: center;
                                        font-size: x-large;
                                    "
                                    colspan="2"
                                >
                                <strong>
                                            قائمة المداخيل  {{ monthSalaire > 0 ? 'الشهر' : '' }} :
                                            {{ monthSalaire }}
                                        </strong>
                                </td>
                                <td
                                    style="
                                        text-align: right;
                                        font-size: x-large;
                                    "
                                    colspan="2"
                                ></td>
                            </tr>
                            </tbody>

                        </table>
                    </div>

                    <!-- /.col -->
                </div>
                <!-- info row -->

                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12">
                        <table
                            border="1"
                            dir="rtl"
                            style="
                                text-align: right;
                                margin-top: 10px;
                                width: 100%;
                            "
                            class="table-sm table-striped"
                        >
                            <thead>
                                <tr>
                                    <th>الرقم</th>
                                    <th>المخابز</th>
                                    <th>تاريخ الجباية</th>
                                    <th>تاريخ التسديد</th>
                                    <th>رقم الوصل</th>
                                    <th>الحالة</th>
                                    <th>المبلغ المدفوع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(recette, index) in props.recettes
                                        .data"
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
                                                recette.type_recette === 'PAYE'
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
                                            >{{ etatImpot[recette.type_recette] }}</span
                                        >
                                    </td>
                                    <th dir="ltr">
                                        {{
                                            recette.montant.toLocaleString()
                                        }}
                                        UM
                                    </th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6">المجموع الكامل :</th>
                                    <th dir="ltr">
                                        {{ returnTotal().toLocaleString() }} UM
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr />

                <div style="margin-top: 1em" class="col-sm-12">
                    <table class="table no-border">
                        <tbody>
                            <tr>
                            <td style="text-align: left" colspan="2">
                                المحاسب
                            </td>
                            <td style="text-align: right" colspan="2">
                                <strong> الرئيس </strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: left" colspan="2"></td>
                            <td style="text-align: right" colspan="2">
                                <strong>{{ datePrint }}</strong>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- /.invoice -->

            <!-- /.content -->
        </section>
        <!-- /.content -->
    </div>
</template>
<script>
import { onMounted, ref } from "vue";
import AuthLayout from "../../Layouts/PrintLayout.vue";

export default {
    layout: AuthLayout,
};
</script>

<script setup>

const etatImpot = {
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

const urlParams = new URLSearchParams(location.search);
const monthSalaire = ref(urlParams.get("monthPaye"));
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const props = defineProps({
    recettes: Object,
});

const returnTotal = function () {
    var total = 0;
    props.recettes.data.forEach((element) => {
        total += element.montant;
    });
    return total;
};

onMounted(() => {
    print();
});

const print = _.throttle(() => {
    window.addEventListener("load", window.print());
}, 5000);

</script>
