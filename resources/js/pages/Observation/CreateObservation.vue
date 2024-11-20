<template>
  <button
    type="button"
    class="btn btn-block btn-primary"
    data-toggle="modal"
    data-target="#createObservation"
  >
    <i class="fa fa-plus"></i> إضافة
  </button>

  <div class="modal fade" id="createObservation" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="closeModel" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">إضافة ملاحظة جديدة</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="createFormObservation">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>المخبزة :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.boulanger_id"
                    :class="{
                      'is-invalid': form.errors.boulanger_id,
                    }"
                  >
                    <option selected value="">إختر المخبزة</option>
                    <option
                      v-for="item in props.boulangers"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.boulanger_id" class="error invalid-feedback">{{
                    form.errors.boulanger_id
                  }}</span>
                </div>

                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>العامل :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.employeur_id"
                    :class="{
                      'is-invalid': form.errors.employeur_id,
                    }"
                  >
                    <option selected value="">إختر العامل</option>
                    <option
                      v-for="item in props.employeurs"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.employeur_id" class="error invalid-feedback">{{
                    form.errors.employeur_id
                  }}</span>
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputDate">التاريخ :</label>
                  <input
                    type="date"
                    class="form-control"
                    id="InputDate"
                    v-model="form.date"
                    :class="{
                      'is-invalid': form.errors.date,
                    }"
                  />
                  <span v-if="form.errors.date" class="error invalid-feedback">{{
                    form.errors.date
                  }}</span>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>ملاحظات :</label>
                  <textarea
                    class="form-control"
                    rows="2"
                    placeholder="اكتب ملاحظات هنا ..."
                    v-model="form.message"
                  ></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" form="createFormObservation" class="btn btn-success">
            حفظ الملاحظة
          </button>
          <button type="button" class="btn btn-danger" @click="closeModel">إلغاء</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../composables/alert";

const date = new Date();
const anneeActualle = date.getFullYear();
const formattedDate = date.toISOString().slice(0, 10);

const form = useForm({
  date: formattedDate,
  boulanger_id: "",
  employeur_id: "",
  created_by: 1,
  message: "",
  annee: anneeActualle,
});

const props = defineProps({
  employeurs: Object,
  boulangers: Object,
});

let createModel = "";

onMounted(() => {
  createModel = $("#createObservation");
});

const closeModel = () => {
  createModel.modal("hide");
  form.reset();
};

const soumettre = () => {
  form.post(route("observation.store"), {
    onSuccess: (page) => {
      // afficher un message de succes
      closeModel();
      useSwalSuccess("لقد تم إضافة الملاحظة بنجاح !");
      form.reset();
    },
    onError: (errors) => {
      useSwalError("Une erreur s'est produite");
      console.log(errors);
    },
  });
};
</script>
