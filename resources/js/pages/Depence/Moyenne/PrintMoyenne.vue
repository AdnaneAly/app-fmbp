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
                    <strong>
                      قائمة مصاريف العتاد
                      {{ monthMoyenne > 0 ? "الشهر" : "" }} :
                      {{ monthMoyenne }}
                    </strong>
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
                  <th>نوع المصروف</th>
                  <th>الطراز</th>
                  <th>المرجع أو اللوحة</th>
                  <th>التاريخ</th>
                  <th>المبلغ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(moyenne, index) in props.moyennes.data" :key="index">
                  <td>{{ index + 1 }}.</td>
                  <td>{{ moyenne.type }}</td>
                  <td>{{ moyenne.niveau }}</td>
                  <td>{{ moyenne.reference }}</td>
                  <td>{{ moyenne.date }}</td>
                  <td>
                    {{ moyenne.montant.toLocaleString() }}
                  </td>
                </tr>
              </tbody>

            </table>
          </div>
          <!-- /.col -->
        </div>
        <br /><br />
        <!-- /.row -->

        <div class="col-6" dir="rtl" style="text-align: right">
          <strong>معلومات إضافية :</strong>

          <div style="margin-top: 20px">
            <table border="1" style="text-align: right; width: 100%" class="table-sm">
              <tbody>
                <tr>
                  <th style="width: 50%">العدد</th>
                  <th dir="ltr">{{ returnTotal() }}</th>
                </tr>
                <tr>
                  <th>المجموع الكامل :</th>
                  <th dir="ltr">
                    {{ returnTotalMoyenne().toLocaleString() }} <small>MRU</small>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
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
import AuthLayout from "../../../Layouts/PrintLayout.vue";

export default {
  layout: AuthLayout,
};
</script>

<script setup>
const urlParams = new URLSearchParams(location.search);
const monthMoyenne = ref(urlParams.get("month"));
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const props = defineProps({
  moyennes: Object,
});

const returnTotalMoyenne = function () {
  var total = 0;
  props.moyennes.data.forEach((element) => {
    total += element.montant;
  });
  return total;
};

const returnTotal = function () {
  var n = 0;
  props.moyennes.data.forEach((element) => {
    n += 1;
  });
  return n;
};

onMounted(() => {
  $(document).ready(function () {
    window.print();
  });
});
</script>
