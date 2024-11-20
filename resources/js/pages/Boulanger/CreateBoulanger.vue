<template>
  <button
    type="button"
    class="btn btn-block btn-primary"
    data-toggle="modal"
    data-target="#createBoulanger"
  >
    <i class="fa fa-plus"></i> إضافة
  </button>

  <div class="modal fade" id="createBoulanger" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="closeModel" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">إضافة مخبزة جديدة</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="createFormBoulanger">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputName">إسم المخبزة:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputName"
                    placeholder="ادخل اسم المخبزة"
                    v-model="form.name"
                    :class="{
                      'is-invalid': form.errors.name,
                    }"
                  />
                  <span v-if="form.errors.name" class="error invalid-feedback">{{
                    form.errors.name
                  }}</span>
                </div>
                <div class="form-group">
                  <label>المالك :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.proprietaire_id"
                    :class="{
                      'is-invalid': form.errors.proprietaire_id,
                    }"
                  >
                    <option selected value="">إختر...</option>
                    <option
                      v-for="item in props.proprietaires"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span
                    v-if="form.errors.proprietaire_id"
                    class="error invalid-feedback"
                    >{{ form.errors.proprietaire_id }}</span
                  >
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputAddress">مكان المخبزة :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputAddress"
                    placeholder="ادخل مكان المخبزة"
                    v-model="form.address"
                    :class="{
                      'is-invalid': form.errors.address,
                    }"
                  />
                  <span v-if="form.errors.address" class="error invalid-feedback">{{
                    form.errors.address
                  }}</span>
                </div>
                <div class="form-group">
                  <label>الحالة :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.etat"
                    :class="{
                      'is-invalid': form.errors.etat,
                    }"
                  >
                    <option value="" selected="selected">إختر...</option>
                    <option value="Active">تعمل حاليا</option>
                    <option value="NoActive">لم تعد تعمل</option>
                  </select>
                  <span v-if="form.errors.etat" class="error invalid-feedback">{{
                    form.errors.etat
                  }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <!-- textarea -->
                <div class="form-group">
                  <label>ملاحظات : </label>
                  <textarea
                    class="form-control"
                    rows="2"
                    placeholder="اكتب الملاحظات هنا ..."
                    v-model="form.description"
                  ></textarea>
                  <input type="hidden" name="created_by" v-model="form.created_by" />
                </div>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" form="createFormBoulanger" class="btn btn-success">
            حفظ المخبزة
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

const form = useForm({
  name: "",
  address: "",
  proprietaire_id: "",
  created_by: 1,
  etat: "",
  description: "",
});

const props = defineProps({
  proprietaires: Object,
});

let createModel = "";

onMounted(() => {
  createModel = $("#createBoulanger");
});

const closeModel = () => {
  createModel.modal("hide");
  form.reset();
};

const soumettre = () => {
  form.post(route("boulanger.store"), {
    onSuccess: (page) => {
      // afficher un message de succes
      closeModel();
      useSwalSuccess("لقد تمت إضافة المخبزة بنجاح !");
      form.reset();
    },
    onError: (errors) => {
      useSwalError("Une erreur s'est produite");
      console.log(errors);
    },
  });
};
</script>
