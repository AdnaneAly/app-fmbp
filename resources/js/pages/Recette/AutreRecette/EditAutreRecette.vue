<template>
  <div
    dir="rtl"
    class="modal fade"
    id="EditAutreRecette"
    style="display: none; text-align: right"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="closeModal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">تعديل دخل آخر</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="editForm">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>نوع الدخل :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="editAutreRecette.type_recette_id"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty(
                        'type_recette_id'
                      ),
                    }"
                  >
                    <option
                      v-for="item in props.typerecettes"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('type_recette_id')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.type_recette_id }}</span
                  >
                </div>
                <div class="form-group">
                  <label for="InputMontant">المبلغ :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputMontant"
                    v-model="editAutreRecette.montant"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty(
                        'montant'
                      ),
                    }"
                  />
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('montant')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.montant }}</span
                  >
                </div>
                <div v-show="editAutreRecette.type_recette_id == 1" class="form-group">
                  <label> المخبزة المستهدفة :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="editAutreRecette.boulanger_id"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty(
                        'boulanger_id'
                      ),
                    }"
                  >
                    <option
                      v-for="item in props.boulangers"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('boulanger_id')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.boulanger_id }}</span
                  >
                </div>
                <div v-show="editAutreRecette.type_recette_id == 4" class="form-group">
                  <label for="InputDetail">وصف المصروف :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputDetail"
                    placeholder="ادخل الوصف هنا..."
                    v-model="editAutreRecette.recette_detail"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty(
                        'recette_detail'
                      ),
                    }"
                  />
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('recette_detail')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.date }}</span
                  >
                </div>


                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputDate">التاريخ :</label>
                  <input
                    type="date"
                    class="form-control"
                    id="InputDate"
                    v-model="editAutreRecette.date"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty('date'),
                    }"
                  />
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('date')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.date }}</span
                  >
                </div>
                <div class="form-group">
                  <label for="InputFacture">رقم الوصل :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputFacture"
                    v-model="editAutreRecette.numeroFacture"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty(
                        'numeroFacture'
                      ),
                    }"
                  />
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('numeroFacture')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.numeroFacture }}</span
                  >
                </div>
                <div v-show="editAutreRecette.type_recette_id == 4" class="form-group">
                  <label for="InputType">الطراز أو المرجع :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputType"
                    placeholder="ادخل المرجع هنا..."
                    v-model="editAutreRecette.reference"
                    :class="{
                      'is-invalid': editAutreRecette.messageError.hasOwnProperty(
                        'reference'
                      ),
                    }"
                  />
                  <span
                    v-if="editAutreRecette.messageError.hasOwnProperty('reference')"
                    class="error invalid-feedback"
                    >{{ editAutreRecette.messageError.reference }}</span
                  >
                </div>

              </div>
              <div class="col-md-12">
                <!-- textarea -->
                <div class="form-group">
                  <label>ملاحظات :</label>
                  <textarea
                    class="form-control"
                    rows="2"
                    v-model="editAutreRecette.description"
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
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
import { router } from "@inertiajs/vue3";
const date = new Date();
const anneeActualle = date.getFullYear();
const emit = defineEmits(["modalClosed"]);

const props = defineProps({
  autrerecette_id: {
    type: Number,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
  typerecettes: Object,
  boulangers: Object,
});

const editAutreRecette = reactive({
  id: "",
  boulanger_id: "",
  numeroFacture: "",
  recette_detail: "",
  reference: "",
  type_recette_id: "",
  montant: "",
  date: null,
  description: "",
  created_by: 1,
  annee: anneeActualle,
  messageError: {},
});

const openModal = () => {
  getAutreRecetteById();
  $("#EditAutreRecette").modal("show");
};

const closeModal = () => {
  $("#EditAutreRecette").modal("hide");
  emit("modalClosed");
};

const soumettre = () => {
  const url = route("autrerecette.update", { autrerecette: props.autrerecette_id });
  router.put(
    url,
    {
      montant: editAutreRecette.montant,
      boulanger_id: editAutreRecette.boulanger_id,
      numeroFacture: editAutreRecette.numeroFacture,
      recette_detail: editAutreRecette.recette_detail,
      reference: editAutreRecette.reference,
      type_recette_id: editAutreRecette.type_recette_id,
      date: editAutreRecette.date,
      description: editAutreRecette.description,
      created_by: editAutreRecette.created_by,
      annee: editAutreRecette.annee,
    },
    {
      onSuccess: (page) => {
        closeModal();
        // afficher un message de succes
        useSwalSuccess("لقد تم تعديل الدخل");
      },
      onError: (errors) => {
        // afficher un message d'error
        if (errors.length != 0) {
          editAutreRecette.messageError = errors;
        }
        useSwalError("Une erreur s'est produite");
      },
    }
  );
};

const getAutreRecetteById = () => {
  axios
    .get(route("autrerecette.edit", { autrerecette: props.autrerecette_id }))
    .then((response) => {
      editAutreRecette.id = response.data.autreRecette.id;
      editAutreRecette.montant = response.data.autreRecette.montant;
      editAutreRecette.boulanger_id = response.data.autreRecette.boulanger_id;
      editAutreRecette.numeroFacture = response.data.autreRecette.numeroFacture;
      editAutreRecette.recette_detail = response.data.autreRecette.recette_detail;
      editAutreRecette.reference = response.data.autreRecette.reference;
      editAutreRecette.date = response.data.autreRecette.date;
      editAutreRecette.type_recette_id = response.data.autreRecette.type_recette_id;
      editAutreRecette.description = response.data.autreRecette.description;
      editAutreRecette.annee = response.data.autreRecette.annee;
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
