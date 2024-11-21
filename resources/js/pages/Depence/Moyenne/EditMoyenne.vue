<template>
  <div
    dir="rtl"
    class="modal fade"
    id="EditMoyenne"
    style="display: none; text-align: right"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="closeModal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">تعديل مصروف عتاد</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="editForm">
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
          <button type="button" class="btn btn-danger" @click="closeModal">إلغاء</button>
          <button form="editForm" type="submit" class="btn btn-success">
            حفظ التعديل
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>

<script setup>
import { watch } from "vue";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);
const date = new Date();
const anneeActualle = date.getFullYear();
const props = defineProps({
  moyenne_id: {
    type: Number,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
  employeurs: Object,
});

const form = useForm({
  type: "",
  niveau: "",
  reference: "",
  numeroFacture: "",
  montant: "",
  date: null,
  created_by: 1,
  annee: anneeActualle,
  description: "",
});

const openModal = () => {
  getMoyenneById();
  $("#EditMoyenne").modal("show");
};

const closeModal = () => {
  $("#EditMoyenne").modal("hide");
  emit("modalClosed");
};

const soumettre = () => {
  form.put(route("moyenne.update", { moyenne: props.moyenne_id }), {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("لقد تم تعديل المصروف بنجاح !");
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
      useSwalError(errors[0]);
    },
  });
};

const getMoyenneById = () => {
  axios
    .get(route("moyenne.edit", { moyenne: props.moyenne_id }))
    .then((response) => {
      form.type = response.data.moyenne.type;
      form.niveau = response.data.moyenne.niveau;
      form.montant = response.data.moyenne.montant;
      form.numeroFacture = response.data.moyenne.numeroFacture;
      form.date = response.data.moyenne.date;
      form.annee = response.data.moyenne.annee;
      form.description = response.data.moyenne.description;
      form.reference = response.data.moyenne.reference;
      form.created_by = response.data.moyenne.created_by;
    })
    .catch((error) => {
      console.log(error);
    });
};

watch(
  () => props.show,
  (newVal, oldVal) => {
    if (newVal) {
      openModal();
    } else {
      closeModal();
    }
  }
);
</script>
