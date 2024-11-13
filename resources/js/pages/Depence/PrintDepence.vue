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
                                <td style="text-align: center; font-size: x-large;" colspan="2"><strong> قائمة المصاريف
                                         الشهر  : 10 </strong></td>
                                <td style="text-align: right; font-size: x-large;" colspan="2"></td>
                            </tr>
                        </table>
                    </div>

                    <!-- /.col -->
                </div>
                <!-- info row -->

                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 ">
                        <table border="1" dir="rtl" style="text-align: right; margin-top: 10px; width: 100%" class="table-sm table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 50px">#</th>
                                    <th>نوع المصروف</th>
                                    <th>المستفيد</th>
                                    <th>التاريخ</th>
                                    <th>المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(depence, index) in props.depences.data" :key="index">
                                            <td>{{ index + 1 }}.</td>
                                            <td>{{ depence.type_depence.name ?? '' }}</td>
                                            <td>{{ depence.employeur ? depence.employeur.name : '' }}</td>
                                            <td>{{ depence.date }}</td>
                                            <td dir="ltr">{{ depence.montant.toLocaleString() }} UM</td>
                                        </tr>


                            </tbody>
                            <tfoot>
                                        <tr>
                                            <th colspan="4">المجموع الكامل </th>
                                            <th dir="ltr">{{ returnTotalMJT().toLocaleString() }} UM</th>
                                        </tr>
                                    </tfoot>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr />


                <div style="margin-top: 1em;" class="col-sm-12">
                    <table class="table no-border">
                        <tr>
                            <td style="text-align: left;" colspan="2">المحاسب</td>
                            <td style="text-align: right;" colspan="2"><strong> الرئيس </strong></td>
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

const props = defineProps({
    depences: Object,
});

const returnTotalMJT = function () {
    var total = 0;
    props.depences.data.forEach((element) => {
        total += element.montant;
    });
    return total;
};


</script>
