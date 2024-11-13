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
                                            قائمة مصاريف الرواتب {{ monthSalaire > 0 ? 'الشهر' : '' }} :
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
                                    <th style="width: 50px">#</th>
                                    <th>العمال</th>
                                    <th>الهاتف</th>
                                    <th>التاريخ</th>
                                    <th>أيام العمل</th>
                                    <th>المبلغ المقابل</th>
                                    <th>المبلغ المقتطع</th>
                                    <th>المبلغ بعد الاقتطاع</th>
                                    <th>التوقيع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(salaire, index) in props.salaires
                                        .data"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}.</td>
                                    <td>{{ salaire.employeur.name }}</td>
                                    <td dir="ltr">
                                        {{ salaire.employeur.tel }}
                                    </td>
                                    <td>{{ salaire.date }}</td>
                                    <td>{{ salaire.nombreJoursTravail }}</td>
                                    <td dir="ltr">
                                        {{
                                            salaire.montantJoursTravail.toLocaleString()
                                        }}
                                        UM
                                    </td>
                                    <td dir="ltr">
                                        {{
                                            salaire.montantAS.toLocaleString()
                                        }}
                                        UM
                                    </td>
                                    <td dir="ltr">
                                        {{
                                            salaire.montantNet.toLocaleString()
                                        }}
                                        UM
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">المجموع الكامل</th>
                                    <th dir="ltr">
                                        {{
                                            returnTotalMJT().toLocaleString()
                                        }}
                                        UM
                                    </th>
                                    <th dir="ltr">
                                        {{
                                            returnTotalMAS().toLocaleString()
                                        }}
                                        UM
                                    </th>
                                    <th dir="ltr">
                                        {{
                                            returnTotalMNet().toLocaleString()
                                        }}
                                        UM
                                    </th>
                                    <td></td>
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
import { ref } from "vue";
import AuthLayout from "../../../Layouts/PrintLayout.vue";

export default {
    layout: AuthLayout,
};
</script>

<script setup>
const urlParams = new URLSearchParams(location.search);
const monthSalaire = ref(urlParams.get("month"));
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const props = defineProps({
    salaires: Object,
});

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
</script>
