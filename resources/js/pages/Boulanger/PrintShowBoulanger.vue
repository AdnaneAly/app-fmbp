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
                            <img src="~admin-lte/dist/img/cover-01.png" alt="Photo 1" class="img-fluid">
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div style="margin-top: 2em;" dir="rtl" class="row">

                    <div class="col-sm-12">
                        <table class="table no-border">
                            <tr>
                                <td style="text-align: left;"><strong>الموقع : </strong></td>
                                <td style="text-align: right;">{{boulanger.address}}</td>
                                <td style="text-align: left; font-size: x-large;" ><strong> المخبزة : </strong></td>
                                <td style="text-align: right; font-size: x-large;">{{boulanger.name}}</td>
                                <td style="text-align: left;"><strong>المالك : </strong></td>
                                <td style="text-align: right;">{{boulanger.proprietaire.name}}</td>
                            </tr>
                            <tr>
                                <td style="text-align: left;"><strong>المجموعة : </strong></td>
                                <td style="text-align: right;"></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: left;"><strong>الهاتف : </strong></td>
                                <td style="text-align: right;">{{boulanger.proprietaire.tel}}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- /.col -->
                </div>
                <!-- info row -->

                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12">
                        <table border="1" dir="rtl" style="text-align: right; margin-top: 10px; width: 100%" class="table-sm table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 5%">الرقم</th>
                                    <th style="width: 25%">تاريخ الجباية</th>
                                    <th style="width: 25%">تاريخ التسديد</th>
                                    <th style="width: 15%">رقم الوصل</th>
                                    <th style="width: 10%">الحالة</th>
                                    <th style="width: 20%">المبلغ المدفوع</th>
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
                                                        recetteImpot(month)
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

                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr dir="ltr">
                                            <th colspan="2">Total:</th>
                                            <td colspan="3"></td>
                                            <th>
                                                {{
                                                    returnTotal().toLocaleString()
                                                }}
                                                UM
                                            </th>
                                        </tr>
                                    </tfoot>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <br />
                <div dir="rtl" style="text-align: right; margin-top: 20px;" class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <strong>مجموع ما لم يدفع من الجباية</strong>

                        <div style="margin-top: 20px;" >
                            <table border="1" dir="rtl" style="text-align: right; width: 100%" class="table-sm table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>الحالة</th>
                                        <th>عدد الاشهر</th>
                                        <th>المبلغ المتبقي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="width:50%"> إعفاء </th>
                                        <td>{{ props.etatscountes.EXONERER ?? 0 }}</td>
                                        <td dir="ltr"></td>
                                    </tr>
                                    <tr>
                                        <th>مغلق</th>
                                        <td>{{ props.etatscountes.FERMER ?? 0 }}</td>
                                        <td dir="ltr"></td>
                                    </tr>
                                    <tr>
                                        <th>لم يدفع</th>
                                        <td>{{ boulanger.arriere }}</td>
                                        <th dir="ltr">{{ (boulanger.arriere * 55000).toLocaleString() }} UM</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!-- /.col -->
                    <div class="col-6">
                        <strong>مجموع ما دفع من الجباية</strong>

                        <div style="margin-top: 20px;">

                            <table border="1" dir="rtl" style="text-align: right; width: 100%" class="table-sm table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>الحالة</th>
                                        <th>عدد الاشهر</th>
                                        <th>المبلغ المدفوع</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th style="width:50%"> دفع </th>
                                        <td>{{ props.etatscountes.PAYE ?? 0 }}</td>
                                        <th dir="ltr">{{ props.etatsmontants.PAYE }} UM</th>
                                    </tr>
                                    <tr>
                                        <th>تسوية</th>
                                        <td>{{ props.etatscountes.SEMIPAYE ?? 0 }}</td>
                                        <th dir="ltr">{{ props.etatsmontants.SEMIPAYE }} UM</th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">المجموع الكامل :</th>
                                        <th dir="ltr">{{ (props.etatsmontants.PAYE || 0) + (props.etatsmontants.SEMIPAYE || 0) }} UM</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>


                <div style="margin-top: 1em;" class="col-sm-12">
                        <table class="table no-border">
                            <tr>
                                <td style="text-align: left;" colspan="2">المحاسب</td>
                                <td style="text-align: right;" colspan="2"><strong> الرئيس  </strong></td>
                            </tr>
                            <tr>
                                <td style="text-align: left;" colspan="2"></td>
                                <td style="text-align: right;" colspan="2"><strong>{{ datePrint }}</strong></td>
                            </tr>
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
import { ref } from "vue";
import AuthLayout from "../../Layouts/PrintLayout.vue";

export default {
    layout: AuthLayout,
};
</script>

<script setup>

const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

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
    etatscountes: Object,
    etatsmontants: Object,
});

const recetteImpot = (monthId) => {
    let impots = Object;
    for (let recette of props.recettes) {
        if (recette.month == monthId) {
            impots = recette;
        }
    }
    return impots;
};

console.log(props.etats);

const returnTotal = function () {
    var total = 0;
    props.recettes.forEach((element) => {
        total += element.montant;
    });
    return total;
};



</script>
