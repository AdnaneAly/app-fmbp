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
                                            قائمة المداخيل الاخرى  {{ monthAutreRecette > 0 ? 'الشهر' : '' }} :
                                            {{ monthAutreRecette }}
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
                                    <th>الحالة</th>
                                    <th>ملاحظة</th>
                                    <th>رقم الوصل</th>
                                    <th>تاريخ العمليات</th>
                                    <th>المبلغ المدفوع</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(autrerecette, index) in props
                                        .autrerecettes.data"
                                    :key="autrerecette.id"
                                >
                                    <td>{{ index + 1 }}.</td>
                                    <td>
                                        {{ autrerecette.typerecette.name }}
                                    </td>
                                    <td>{{ autrerecette.description }}</td>
                                    <td>{{ autrerecette.numeroFacture }}</td>
                                    <td>{{ autrerecette.date }}</td>
                                    <th dir="ltr">
                                        {{
                                            autrerecette.montant.toLocaleString()
                                        }}
                                        UM
                                    </th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total:</th>
                                    <th dir="ltr">
                                        {{ returnTotal().toLocaleString() }}
                                        UM
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
import AuthLayout from "../../../Layouts/PrintLayout.vue";


export default {
    layout: AuthLayout,
};
</script>

<script setup>
const urlParams = new URLSearchParams(location.search);
const monthAutreRecette = ref(urlParams.get("month"));
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const props = defineProps({
    autrerecettes: Object,
});

const returnTotal = function () {
    var total = 0;
    props.autrerecettes.data.forEach((element) => {
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
