<template>
  <button
    type="button"
    class="btn btn-block btn-primary"
    data-toggle="modal"
    data-target="#createEmployeur"
  >
    <i class="fa fa-plus"></i> إضافة
  </button>

  <div class="modal fade" id="createEmployeur" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="closeModel" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">إضافة عامل جديد</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="createFormEmployeur">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputName">إسم العامل :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputName"
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
                  <label for="InputTel">رقم الهاتف :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputTel"
                    v-model="form.tel"
                    :class="{
                      'is-invalid': form.errors.tel,
                    }"
                  />
                  <span v-if="form.errors.tel" class="error invalid-feedback">{{
                    form.errors.tel
                  }}</span>
                </div>
                <div class="form-group">
                  <label>الحالة : </label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.etat"
                    :class="{
                      'is-invalid': form.errors.etat,
                    }"
                  >
                    <option value="" selected="selected">إختر...</option>
                    <option value="active">يعمل حاليا</option>
                    <option value="noActive">لم يعد يعمل</option>
                  </select>
                  <span v-if="form.errors.etat" class="error invalid-feedback">{{
                    form.errors.etat
                  }}</span>
                </div>

                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>الرتبة :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.grade_id"
                    :class="{
                      'is-invalid': form.errors.grade_id,
                    }"
                  >
                    <option selected value="">إختر رتبة العامل</option>
                    <option v-for="item in props.grades" :value="item.id" :key="item.id">
                      {{ item.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.grade_id" class="error invalid-feedback">{{
                    form.errors.grade_id
                  }}</span>
                </div>
                <div class="form-group">
                  <label for="InputNNI">رقم بطاقة التعريف :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputNNI"
                    v-model="form.nni"
                  />
                </div>
                <div class="form-group">
                  <label>ملاحظات :</label>
                  <textarea
                    class="form-control"
                    rows="1"
                    placeholder="اكتب ملاحظات هنا ..."
                    v-model="form.description"
                  ></textarea>
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputDate">تاريخ الاكتتاب :</label>
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
                <div class="form-group">
                  <label for="InputMontantSalaire">المرتب :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputMontantSalaire"
                    placeholder="ادخل المبلغ هنا..."
                    v-model="form.montantSalaire"
                    :class="{
                      'is-invalid': form.errors.montantSalaire,
                    }"
                  />
                  <span
                    v-if="form.errors.montantSalaire"
                    class="error invalid-feedback"
                    >{{ form.errors.montantSalaire }}</span
                  >
                </div>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" form="createFormEmployeur" class="btn btn-success">
            حفظ العامل
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
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../composables/alert";

const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);

const form = useForm({
  name: "",
  grade_id: "",
  etat: "",
  description: "",
  nni: "",
  date: formattedDate,
  montantSalaire: "",
  tel: "",
});

const props = defineProps({
  grades: Object,
  boulangers: Object,
});

let createModel = "";

onMounted(() => {
  createModel = $("#createEmployeur");
});

const closeModel = () => {
  createModel.modal("hide");
  form.reset();
};

const soumettre = () => {
  form.post(route("employeur.store"), {
    onSuccess: (page) => {
      // afficher un message de succes
      closeModel();
      useSwalSuccess("Le employeur ajouté avec succés");
      form.reset();
    },
    onError: (errors) => {
      useSwalError("Une erreur s'est produite");
      console.log(errors);
    },
  });
};
</script>
