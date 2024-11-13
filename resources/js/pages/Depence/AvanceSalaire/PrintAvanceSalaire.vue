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
                            <tr>
                                <td
                                    style="
                                        text-align: center;
                                        font-size: x-large;
                                    "
                                    colspan="2"
                                >
                                <strong>
                                            قائمة مصاريف  مقدمات الرواتب {{ monthAvanceSalaire > 0 ? 'الشهر' : '' }} :
                                            {{ monthAvanceSalaire }}
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
                                    <th style="width: 5%">#</th>
                                    <th style="width: 25%">العمال</th>
                                    <th style="width: 15%">الهاتف</th>
                                    <th style="width: 15%">الرتبة</th>
                                    <th style="width: 15%">التاريخ</th>
                                    <th style="width: 15%">المبلغ المقدم</th>
                                    <th style="width: 10%">الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(avancesalaire, index) in props
                                        .avancesalaires.data"
                                    :key="index"
                                >
                                    <td>{{ index + 1 }}.</td>
                                    <td>{{ avancesalaire.employeur.name }}</td>
                                    <td>{{ avancesalaire.employeur.tel }}</td>
                                    <td>{{ avancesalaire.employeur.tel }}</td>
                                    <td>{{ avancesalaire.date }}</td>
                                    <td>
                                        {{ avancesalaire.montantAvanceSalaire.toLocaleString() }}
                                    </td>
                                    <td class="project-state">
                                        <span
                                            class="badge"
                                            :class="
                                                avancesalaire.etat === 'paye'
                                                    ? 'bg-success'
                                                    : 'bg-danger'
                                            "
                                            >{{
                                                avancesalaire.etat === "paye"
                                                    ? "دفع"
                                                    : " لم يدفع"
                                            }}</span
                                        >
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">المجموع الكامل</th>
                                    <th dir="ltr">
                                        {{ returnTotalMJT().toLocaleString() }}

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
import AuthLayout from "../../../Layouts/PrintLayout.vue";

export default {
    layout: AuthLayout,
};
</script>

<script setup>

const urlParams = new URLSearchParams(location.search);
const monthAvanceSalaire = ref(urlParams.get("month"));
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const props = defineProps({
    avancesalaires: Object,
});

const returnTotalMJT = function () {
    var total = 0;
    props.avancesalaires.data.forEach((element) => {
        total += element.montantAvanceSalaire;
    });
    return total;
};

onMounted(() => {
    window.addEventListener("load", window.print());
})

</script>
