<template>
  <button
    type="button"
    class="btn btn-block btn-primary"
    data-toggle="modal"
    data-target="#createMoyenne"
  >
    <i class="fa fa-plus"></i> إضافة
  </button>

  <div class="modal fade" id="createMoyenne" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="closeModel" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">إضافة مصروف عتاد</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="createFormMoyenne">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputType">نوع المصروف :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputType"
                    v-model="form.type"
                    :class="{
                      'is-invalid': form.errors.type,
                    }"
                  />
                  <span v-if="form.errors.type" class="error invalid-feedback">{{
                    form.errors.type
                  }}</span>
                </div>
                <div class="form-group">
                  <label for="InputFacture">رقم الوصل :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputFacture"
                    v-model="form.numeroFacture"
                    :class="{
                      'is-invalid': form.errors.numeroFacture,
                    }"
                  />
                  <span v-if="form.errors.numeroFacture" class="error invalid-feedback">{{
                    form.errors.numeroFacture
                  }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputNiveau">الطراز :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputNiveau"
                    v-model="form.niveau"
                    :class="{
                      'is-invalid': form.errors.niveau,
                    }"
                  />
                  <span v-if="form.errors.niveau" class="error invalid-feedback">{{
                    form.errors.niveau
                  }}</span>
                </div>
                <div class="form-group">
                  <label for="InputMontant">المبلغ :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputMontant"
                    v-model="form.montant"
                    :class="{
                      'is-invalid': form.errors.montant,
                    }"
                  />
                  <span v-if="form.errors.montant" class="error invalid-feedback">{{
                    form.errors.montant
                  }}</span>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputReference">المرجع أو اللوحة :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputReference"
                    v-model="form.reference"
                    :class="{
                      'is-invalid': form.errors.reference,
                    }"
                  />
                  <span v-if="form.errors.reference" class="error invalid-feedback">{{
                    form.errors.reference
                  }}</span>
                </div>
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

              <div class="col-md-12">
                <!-- textarea -->
                <div class="form-group">
                  <label>ملاحظات :</label>
                  <textarea
                    class="form-control"
                    rows="2"
                    placeholder="اكتب الملاحظات هنا..."
                    v-model="form.description"
                  ></textarea>
                  <input type="hidden" name="created_by" v-model="form.created_by" />
                  <input type="hidden" name="annee" v-model="form.annee" />
                </div>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" form="createFormMoyenne" class="btn btn-success">
            حفظ العملية
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
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const anneeActualle = date.getFullYear();

const form = useForm({
  type: "",
  niveau: "",
  reference: "",
  numeroFacture: "",
  montant: "",
  date: formattedDate,
  created_by: 1,
  annee: anneeActualle,
  description: "",
});

const props = defineProps({
  employeurs: Object,
});

let createModel = "";

onMounted(() => {
  createModel = $("#createMoyenne");
});

const closeModel = () => {
  createModel.modal("hide");
  form.reset();
};

const soumettre = () => {
  form.post(route("moyenne.store"), {
    onSuccess: (page) => {
      // afficher un message de succes
      closeModel();
      useSwalSuccess("لقد تم إضافة المصروف بنجاح !");
      form.reset();
    },
    onError: (errors) => {
      useSwalError("Une erreur s'est produite");
      console.log(errors);
    },
  });
};
</script>
