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
                  <td style="text-align: center; font-size: x-large" colspan="2">
                    <strong> قائمة العمال </strong>
                  </td>
                  <td style="text-align: right; font-size: x-large" colspan="2"></td>
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
              style="text-align: right; margin-top: 10px; width: 100%"
              class="table-sm table-striped"
            >
              <thead>
                <tr>
                  <th style="width: 50px">#</th>
                  <th>الإسم الكامل</th>
                  <th>الرتبة</th>
                  <th>رقم الهاتف</th>
                  <th>تاريخ الاكتتاب</th>
                  <th>المرتب</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(employeur, index) in props.employeurs.data" :key="index">
                  <td>{{ index + 1 }}.</td>
                  <td>{{ employeur.name }}</td>
                  <td>{{ employeur.grade.name }}</td>
                  <td>{{ employeur.tel }}</td>
                  <td>{{ employeur.date }}</td>
                  <td dir="ltr">
                    {{ employeur.montantSalaire.toLocaleString() }}
                    UM
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="5">المجموع الكامل</th>
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
                <td style="text-align: left" colspan="2">المحاسب</td>
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
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const props = defineProps({
  employeurs: Object,
});

const returnTotal = function () {
  var total = 0;
  props.employeurs.data.forEach((element) => {
    total += element.montantSalaire;
  });
  return total;
};

onMounted(() => {
  $(document).ready(function () {
    window.print();
  });
});
</script>
