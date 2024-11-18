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
                      قائمة الملاحظات على مخبزة :
                      {{ props.observations.boulanger.name }}
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
                  <th style="width: 5%; text-align: center">#</th>
                  <th style="width: 15%">العامل</th>
                  <th style="width: 10%">التاريخ</th>
                  <th style="width: 60%">الملاحظة</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{ 1 }}.</td>
                  <td>{{ observations.employeur.name }}</td>
                  <td>{{ observations.date }}</td>
                  <td>{{ observations.message }}</td>
                </tr>
                <tr
                  v-for="(observation, index) in props.observations.comments"
                  :key="index"
                >
                  <td>{{ index + 1 }}.</td>
                  <td>{{ employeur[observation.employeur_id] }}</td>
                  <td>{{ observation.date }}</td>
                  <td>{{ observation.message }}</td>
                </tr>
              </tbody>
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
  observations: Object,
  employeur: Object,
});

onMounted(() => {
  $(document).ready(function () {
    window.print();
  });
});
</script>
