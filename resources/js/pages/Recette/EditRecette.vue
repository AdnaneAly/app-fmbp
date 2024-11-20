<template>
  <div
    dir="rtl"
    class="modal fade"
    id="EditImpot"
    style="display: none; text-align: right"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="closeModal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">تعديل جباية شهر : {{ editImpot.month }}</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="editForm">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>حالة الجباية :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="editImpot.type_recette"
                    @change="etatImpot($event)"
                  >
                    <option value="" selected="selected">إختر...</option>
                    <option value="PAYE">دفعت</option>
                    <option value="SEMIPAYE">تسوية</option>
                    <option value="FERMER">مغلقة</option>
                    <option value="EXONERER">إعفاء</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="InputAddress">رقم الوصل :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputAddress"
                    :disabled="
                      editImpot.type_recette === 'FERMER' ||
                      editImpot.type_recette === 'NONPAYE' ||
                      editImpot.type_recette === 'EXONERER'
                    "
                    v-model="editImpot.numeroFacture"
                  />
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputAddress">مبلغ الجباية :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputAddress"
                    :disabled="editImpot.type_recette !== 'SEMIPAYE'"
                    v-model="editImpot.montant"
                  />
                </div>
                <div class="form-group">
                  <label for="InputDate">تاريخ التسديد : </label>
                  <input
                    type="date"
                    class="form-control"
                    id="InputDate"
                    v-model="editImpot.date"
                  />
                </div>
              </div>
              <div class="col-md-12">
                <!-- textarea -->
                <div class="form-group">
                  <label>ملاحظات :</label>
                  <textarea
                    class="form-control"
                    rows="2"
                    v-model="editImpot.description"
                  ></textarea>
                </div>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-start">
          <button form="editForm" type="submit" class="btn btn-success">
            حفظ التعديل
          </button>
          <button type="button" class="btn btn-danger" @click="closeModal">إلغاء</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</template>

<script setup>
import axios from "axios";
import { reactive, watch } from "vue";
import { useSwalSuccess, useSwalError } from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);
const date = new Date();
const anneeActualle = date.getFullYear();
const props = defineProps({
  recette_id: {
    type: Number,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
});

const editImpot = reactive({
  boulanger_id: "",
  type_recette: "",
  created_by: 1,
  montant: "",
  numeroFacture: "",
  date: "",
  month: "",
  annee: anneeActualle,
  description: "",
  messageError: {},
});

const openModal = () => {
  getImpotById();
  $("#EditImpot").modal("show");
};

const closeModal = () => {
  $("#EditImpot").modal("hide");
  emit("modalClosed");
};

const soumettre = () => {
  const url = route("recette.update", { recette: props.recette_id });
  router.put(
    url,
    {
      boulanger_id: editImpot.boulanger_id,
      type_recette: editImpot.type_recette,
      montant: editImpot.montant,
      numeroFacture: editImpot.numeroFacture,
      date: editImpot.date,
      month: editImpot.month,
      description: editImpot.description,
      created_by: editImpot.created_by,
    },
    {
      onSuccess: (page) => {
        closeModal();
        // afficher un message de succes
        useSwalSuccess("لقد تم تعديل الجباية");
      },
      onError: (errors) => {
        // afficher un message d'error
        if (errors.length != 0) {
          editImpot.messageError = errors;
        }
        useSwalError("Une erreur s'est produite");
      },
    }
  );
};

const getImpotById = () => {
  axios
    .get(route("recette.edit", { recette: props.recette_id }))
    .then((response) => {
      editImpot.id = response.data.recette.id;
      editImpot.boulanger_id = response.data.recette.boulanger_id;
      editImpot.type_recette = response.data.recette.type_recette;
      editImpot.montant = response.data.recette.montant;
      editImpot.numeroFacture = response.data.recette.numeroFacture;
      editImpot.date = response.data.recette.date;
      editImpot.month = response.data.recette.month;
      editImpot.description = response.data.recette.description;
      editImpot.annee = response.data.recette.annee;
    })
    .catch((error) => {
      console.log(error);
    });
};

const etatImpot = (event) => {
  if (event.target.value == "PAYE") {
    editImpot.montant = 55000;
  } else {
    editImpot.montant = 0;
  }
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
