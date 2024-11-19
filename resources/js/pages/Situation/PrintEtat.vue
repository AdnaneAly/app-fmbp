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
                        <strong> الوضعية العامة</strong>
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align: left; font-size: x-large">
                        من :
                        {{ props.data.dates["debutSearch"] }}
                      </td>
                      <td style="text-align: right; font-size: x-large">
                        <i class="fa fa-arrow-left"></i>
                        إلى :
                        {{ props.data.dates["finSearch"] }}
                      </td>
                    </tr>
                    <tr>
                      <td style="text-align: center; font-size: x-large">
                        عدد المخابز :
                        <strong>
                          {{ props.data.counteBoulanger }}
                        </strong>
                      </td>
                      <td style="text-align: center; font-size: x-large">
                        عدد عمال الإدارة :
                        <strong>
                          {{ props.data.counteEmployeur }}
                        </strong>
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
                        <th>وضعية المخابز</th>
                        <th>عدد الاشهر</th>
                        <th>المبلغ المدفوع</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(montant, etat) in props.data.dupMontantRecette"
                        :key="etat"
                        style="padding: 0"
                      >
                        <th dir="ltr" style="width: 70%">
                          {{ etatImpot[etat] }}
                        </th>
                        <th dir="ltr" style="width: 10%">
                          {{ props.data.dupRecette[etat] }}
                        </th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ montant.toLocaleString() }}
                        </td>
                      </tr>

                      <tr
                        v-for="(name, j) in props.data.typeRecettes"
                        :key="j"
                        style="padding: 0"
                        :hidden="!props.data.dupAutreRecette[j]"
                      >
                        <th style="width: 70%">
                          {{ name }}
                        </th>
                        <td dir="ltr" style="width: 10%">
                          {{ props.data.dupAutreRecette[j] ?? 0 }}
                        </td>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ props.data.dupMontantAutreRecette[j] ?? 0 }}
                        </td>
                      </tr>
                      <tr>
                        <th colspan="2">المجموع الكامل :</th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{
                            (
                              returnTotalRecette() + returnTotalAutreRecette()
                            ).toLocaleString()
                          }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <div dir="rtl" style="text-align: right" class="row">
              <div class="col-12">
                <strong>مجموع المصاريف :</strong>

                <div style="margin-top: 20px">
                  <table
                    border="1"
                    style="text-align: right; margin-top: 10px; width: 100%"
                    class="table-sm"
                  >
                    <thead class="thead-light">
                      <tr>
                        <th>نوع المصروف</th>
                        <th>العدد</th>
                        <th>المبلغ المصروف</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(name, i) in props.data.typeDepences"
                        :key="i"
                        :hidden="!props.data.dupDepence[i]"
                      >
                        <th style="width: 70%">
                          {{ name }}
                        </th>
                        <th dir="ltr" style="width: 10%">
                          {{ props.data.dupDepence[i] }}
                        </th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ props.data.dupMontantDepence[i] }}
                        </td>
                      </tr>

                      <tr>
                        <th style="width: 70%">مجموع مصاريف الرواتب</th>
                        <th dir="ltr" style="width: 10%">
                          {{ props.data.dupDepenceSalaire }}
                        </th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ props.data.dupMontantDepenceSalaire.toLocaleString() }}
                        </td>
                      </tr>

                      <tr>
                        <th style="width: 70%">مجموع مصاريف المقدمات</th>
                        <th dir="ltr" style="width: 10%">
                          {{ props.data.dupAvanceSalaire }}
                        </th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ props.data.dupMontantAvanceSalaire.toLocaleString() }}
                        </td>
                      </tr>
                      <tr>
                        <th colspan="2">المجموع الكامل :</th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ returnTotalDepence().toLocaleString() }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <div dir="rtl" style="text-align: right" class="row">
              <div class="col-12">
                <strong> الوضعية الحالية :</strong>

                <div style="margin-top: 20px">
                  <table
                    border="1"
                    style="text-align: right; margin-top: 10px; width: 100%"
                    class="table-sm"
                  >
                    <thead class="thead-light">
                      <tr>
                        <th>الرقم</th>
                        <th>الحالة</th>
                        <th>المجموع</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th style="width: 5%">1</th>
                        <th style="width: 75%">مجموع المداخيل</th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{
                            (
                              returnTotalRecette() + returnTotalAutreRecette()
                            ).toLocaleString()
                          }}
                        </td>
                      </tr>
                      <tr>
                        <th style="width: 5%">2</th>
                        <th style="width: 75%">مجموع المصاريف</th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{ returnTotalDepence().toLocaleString() }}
                        </td>
                      </tr>
                      <tr>
                        <th colspan="2">المجموع المتبقي :</th>
                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{
                            (
                              returnTotalRecette() +
                              returnTotalAutreRecette() -
                              returnTotalDepence()
                            ).toLocaleString()
                          }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <div dir="rtl" style="text-align: right" class="row">
              <div class="col-12">
                <strong> معلومات إضافية :</strong>

                <div style="margin-top: 20px">
                  <table
                    border="1"
                    style="text-align: right; margin-top: 10px; width: 100%"
                    class="table-sm"
                  >
                    <thead class="thead-light">
                      <tr>
                        <th>الرقم</th>
                        <th>وضعية المخابز</th>
                        <th>عدد الاشهر</th>
                        <th>المبلغ المتبقي (لم يدفع)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="padding: 0">
                        <th style="width: 5%">#</th>
                        <th style="width: 65%">المخابز التي عليها ديون</th>
                        <th style="width: 10%">
                          {{ props.data.dupRecette["NONPAYE"] ?? 0 }}
                        </th>

                        <td dir="ltr" style="width: 20%" class="text-bold">
                          {{
                            props.data.dupRecette["NONPAYE"] > 0
                              ? (props.data.dupRecette["NONPAYE"] * 5500).toLocaleString()
                              : 0
                          }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.col -->
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
import AuthLayout from "../../Layouts/PrintLayout.vue";

export default {
  layout: AuthLayout,
};
</script>
<script setup>
const etatImpot = {
  PAYE: "دفعت",
  NONPAYE: "لم تدفع",
  SEMIPAYE: "تسوية",
  FERMER: "مغلقة",
  EXONERER: "إعفاء",
};

const props = defineProps({
  data: Object,
});

const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const datePrint = ref(formattedDate);

const returnTotalRecette = function () {
  var total = 0;
  Object.entries(props.data.dupMontantRecette).forEach((montant) => {
    total += montant[1];
  });
  return total;
};

const returnTotalAutreRecette = function () {
  var total = 0;
  Object.entries(props.data.dupMontantAutreRecette).forEach((montant) => {
    total += montant[1];
  });
  return total;
};

const returnTotalDepence = function () {
  var total = 0;
  Object.entries(props.data.dupMontantDepence).forEach((montant) => {
    total += montant[1];
  });
  return total + props.data.dupMontantDepenceSalaire + props.data.dupMontantAvanceSalaire;
};

onMounted(() => {
  $(document).ready(function () {
    window.print();
  });
});
</script>
