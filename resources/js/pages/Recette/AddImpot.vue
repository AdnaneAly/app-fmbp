<template>
  <button
    type="button"
    class="btn btn-block btn-primary"
    data-toggle="modal"
    data-target="#addImpotBolanger"
  >
    <i class="fa fa-plus"></i> إضافة
  </button>

  <div
    dir="rtl"
    class="modal fade"
    id="addImpotBolanger"
    style="display: none; text-align: right"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="closeModal" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">إضافة جباية شهر : {{ months[props.mois] }}</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="addFormImpotBoulanger">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>المخابز :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.boulanger_id"
                    :class="{
                      'is-invalid': form.errors.boulanger_id,
                    }"
                  >
                    <option value="" selected="selected">إختر...</option>
                    <option
                      v-for="boulanger in props.boulangers"
                      :value="boulanger.id"
                      :key="boulanger.id"
                    >
                      {{ boulanger.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.boulanger_id" class="error invalid-feedback">{{
                    form.errors.boulanger_id
                  }}</span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputImpot">شهر الجباية :</label>
                  <select v-model="form.month" class="form-control">
                    <option value="" selected>إختر...</option>
                    <option value="JANVIER">يناير</option>
                    <option value="FEVRIER">قبراير</option>
                    <option value="MARS">مارس</option>
                    <option value="AVRIL">ابريل</option>
                    <option value="MAI">مايو</option>
                    <option value="JUIN">يونيو</option>
                    <option value="JUILLET">يوليو</option>
                    <option value="AOUT">اغصطس</option>
                    <option value="SEPTEMBRE">سبتمبر</option>
                    <option value="OCTOBRE">اكتوبر</option>
                    <option value="NOVEMBRE">نوفمبر</option>
                    <option value="DECEMENBRE">دجمبر</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>حالة الجباية :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.type_recette"
                    @change="etatImpot($event)"
                    :class="{
                      'is-invalid': form.errors.type_recette,
                    }"
                  >
                    <option value="" selected="selected">إختر...</option>
                    <option value="PAYE">دفعت</option>
                    <option value="NONPAYE">لم تدفع</option>
                    <option value="SEMIPAYE">تسوية</option>
                    <option value="FERMER">مغلقة</option>
                    <option value="EXONERER">إعفاء</option>
                  </select>
                  <span v-if="form.errors.type_recette" class="error invalid-feedback">{{
                    form.errors.type_recette
                  }}</span>
                </div>
                <div class="form-group">
                  <label for="InputFacture">رقم الوصل :</label>
                  <input
                    type="number"
                    class="form-control"
                    id="InputFacture"
                    v-model="form.numeroFacture"
                    :disabled="
                      form.type_recette === 'FERMER' ||
                      form.type_recette === 'NONPAYE' ||
                      form.type_recette === 'EXONERER'
                    "
                    :class="{
                      'is-invalid': form.errors.numeroFacture,
                    }"
                  />
                  <span v-if="form.errors.numeroFacture" class="error invalid-feedback">{{
                    form.errors.numeroFacture
                  }}</span>
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
                    :disabled="form.type_recette !== 'SEMIPAYE'"
                    v-model="form.montant"
                    :class="{
                      'is-invalid': form.errors.montant,
                    }"
                  />
                  <span v-if="form.errors.montant" class="error invalid-feedback">{{
                    form.errors.montant
                  }}</span>
                </div>
                <div class="form-group">
                  <label for="InputDate">تاريخ التسديد : </label>
                  <input
                    type="date"
                    class="form-control"
                    id="InputDate"
                    v-model="form.date"
                    :class="{
                      'is-invalid': form.errors.date,
                    }"
                    :disabled="
                      form.type_recette === 'FERMER' ||
                      form.type_recette === 'NONPAYE' ||
                      form.type_recette === 'EXONERER'
                    "
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
                    placeholder="اكتب الملاحظات هنا ..."
                    v-model="form.description"
                  ></textarea>
                  <input type="hidden" v-model="monthImpot" />
                </div>
              </div>
              <!-- /.col -->
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" form="addFormImpotBoulanger" class="btn btn-success">
            حفظ الجباية
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
import { watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../composables/alert";

const emit = defineEmits(["modalClosed"]);
const date = new Date();
const anneeActualle = date.getFullYear();
const formattedDate = date.toISOString().slice(0, 10);
let monthImpot = "";

const months = {
  JANVIER: "يناير",
  FEVRIER: "فبراير",
  MARS: "مارس",
  AVRIL: "ابريل",
  MAI: "مايو",
  JUIN: "يونيو",
  JUILLET: "يوليو",
  AOUT: "اغسطس",
  SEPTEMBRE: "سبتمبر",
  OCTOBRE: "اكتوبر",
  NOVEMBRE: "نوفمبر",
  DECEMENBRE: "دجمبر",
};

const props = defineProps({
  boulangers: {
    type: Object,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
});
const form = useForm({
  boulanger_id: "",
  type_recette: "",
  created_by: 1,
  montant: "",
  numeroFacture: "",
  date: formattedDate,
  month: "",
  annee: anneeActualle,
  description: "",
});

const openModal = () => {
  $("#addImpotBolanger").modal("show");
  form.month = props.mois;
};

const closeModal = () => {
  form.reset();
  $("#addImpotBolanger").modal("hide");
  emit("modalClosed");
};

const soumettre = () => {
  form.post(route("recette.store"), {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("لقد تمت إضافة الجباية بنجاح !");
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
      useSwalError(errors[0] ?? "Une erreur s'est produit");
    },
  });
};

const etatImpot = (event) => {
  if (event.target.value == "PAYE") {
    form.montant = 5500;
  } else {
    form.montant = 0;
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
