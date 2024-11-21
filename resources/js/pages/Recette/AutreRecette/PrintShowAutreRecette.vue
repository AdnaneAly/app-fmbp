<template>
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <!-- Info boxes -->
      <!-- Small boxes (Stat box) -->

      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
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
            <div style="margin-top: 1em" dir="rtl" class="row">
              <div class="col-sm-2"></div>
              <div class="col-sm-8">
                <table class="table table-sm no-border">
                  <tbody>
                    <tr>
                      <td style="text-align: center; font-size: x-large" colspan="2">
                        <strong> وضعية دخل آخر يوم : {{ autrerecette.date }}</strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.col -->
              <div class="col-sm-2"></div>
            </div>
            <!-- /.row -->

            <div dir="rtl" style="text-align: right" class="row">
              <div class="col-12">
                <strong>مجموع المداخيل :</strong>

                <div style="margin-top: 20px">
                  <table
                    border="1"
                    style="text-align: right; margin-top: 10px; width: 100%"
                    class="table-sm"
                  >
                    <thead class="thead-light">
                      <tr>
                        <th style="width: 25%">نوع الدخل</th>
                        <th v-show="autrerecette.boulanger" style="width: 25%"> المخبزة المستهدفة</th>
                        <th v-show="autrerecette.recette_detail" style="width: 25%">وصف الدخل</th>
                        <th v-show="autrerecette.reference" style="width: 20%">المرجع أو الطراز</th>
                        <th style="width: 10%">رقم الوصل</th>
                        <th style="width: 10%">التاريخ</th>
                        <th style="width: 15%">مبلغ الدخل</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>{{ autrerecette.typerecette.name }}</th>
                        <th v-show="autrerecette.boulanger">{{ autrerecette.boulanger ? autrerecette.boulanger.name : '' }}</th>
                        <th v-show="autrerecette.recette_detail">{{ autrerecette.recette_detail }}</th>
                        <th v-show="autrerecette.reference">{{ autrerecette.reference }}</th>
                        <th>{{ autrerecette.numeroFacture }}</th>
                        <th>{{ autrerecette.date }}</th>
                        <th dir="ltr">
                          {{ autrerecette.montant.toLocaleString() }} <small>MRU</small>
                        </th>
                      </tr>

                      <tr>
                        <th>تفاصيل :</th>
                        <th colspan="6">{{ autrerecette.description }}</th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <br /><br />

            <div class="col-6" dir="rtl" style="text-align: right">
              <strong>معلومات إضافية :</strong>

              <div style="margin-top: 20px">
                <table border="1" style="text-align: right; width: 100%" class="table-sm">
                  <tbody>
                    <tr>
                      <th style="width: 50%">العدد</th>
                      <th dir="ltr">1</th>
                    </tr>
                    <tr>
                      <th>المجموع الكامل :</th>
                      <th dir="ltr">
                        {{ autrerecette.montant.toLocaleString() }} <small>MRU</small>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Table row -->
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
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</template>

<script>
import { onMounted, ref } from "vue";
import AuthLayout from "../../../Layouts/PrintLayout.vue";

export default {
  layout: AuthLayout,
};
</script>
<script setup>
const props = defineProps({
  autrerecette: Object,
});

const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

onMounted(() => {
  $(document).ready(function () {
    window.print();
  });
});
</script>
