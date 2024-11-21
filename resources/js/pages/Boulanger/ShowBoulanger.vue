<template>
  <div dir="rtl" style="text-align: right" class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">إسم المخبزة : {{ props.boulanger.name }}</h1>
        </div>
        <div class="col-sm-6 text-left">
          <Link
            :href="
              route('boulanger.printDetail', {
                id: props.boulanger.id,
              })
            "
            class="btn btn-info"
            ><i class="fa fa-print"></i> سحب</Link
          >
        </div>
      </div>
    </div>
  </div>

  <div dir="rtl" style="text-align: right" class="content">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <table class="table table-sm table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 3%">الرقم</th>
                      <th style="width: 10%">شهر الجباية</th>
                      <th style="width: 25%"> الملاحظات</th>
                      <th style="width: 10%">تاريخ التسديد</th>
                      <th style="width: 10%">رقم الوصل</th>
                      <th style="width: 10%">الحالة</th>
                      <th style="width: 15%">المبلغ المدفوع</th>
                      <th style="width: 17%">العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(monthAR, month, index) in months" :key="index">
                      <td>{{ index + 1 }}.</td>
                      <th>{{ monthAR }}</th>
                      <th>{{ recetteImpot(month).description }}</th>
                      <td>
                        {{
                          recetteImpot(month).length != 1
                            ? recetteImpot(month).type_recette === "NONPAYE" ||
                              recetteImpot(month).type_recette === "FERMER" ||
                              recetteImpot(month).type_recette === "EXONERER"
                              ? ""
                              : recetteImpot(month).date
                            : ""
                        }}
                      </td>
                      <td>
                        {{
                          recetteImpot(month).length != 1
                            ? recetteImpot(month).numeroFacture
                            : ""
                        }}
                      </td>
                      <td>
                        <span
                          class="badge text-md"
                          :class="
                            recetteImpot(month).type_recette === 'PAYE'
                              ? 'bg-success'
                              : recetteImpot(month).type_recette === 'SEMIPAYE'
                              ? 'bg-warning'
                              : recetteImpot(month).type_recette === 'FERMER'
                              ? 'bg-secondary'
                              : recetteImpot(month).type_recette === 'EXONERER'
                              ? 'bg-info'
                              : 'bg-danger'
                          "
                          >{{
                            recetteImpot(month) !== []
                              ? etatImpot[recetteImpot(month).type_recette]
                              : ""
                          }}</span
                        >
                      </td>
                      <th dir="ltr">
                        {{
                          recetteImpot(month).length != 1
                            ? recetteImpot(month).montant.toLocaleString() + " UM"
                            : ""
                        }}
                      </th>
                      <td class="d-flex gap-2 text-left">
                        <button
                          style="margin-left: 10px"
                          class="btn btn-primary btn-sm"
                          @click="addImpotBoulanger(month)"
                          :disabled="recetteImpot(month).length != 1"
                        >
                          <i class="fas fa-plus"> </i>
                          إضافة
                        </button>
                        <button
                          @click="openEditImpotBoulanger(recetteImpot(month).id)"
                          style="margin-left: 10px"
                          class="btn btn-info btn-sm"
                          :disabled="recetteImpot(month).length == 1"
                        >
                          <i class="fas fa-pencil-alt"> </i>
                          تعديل
                        </button>
                        <button
                          @click="deleteConfimation(recetteImpot(month).id)"
                          class="btn btn-danger btn-sm"
                          :disabled="recetteImpot(month).length == 1"
                        >
                          <i class="fa fa-trash"></i>
                          مسح
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5">المجموع الكامل :</th>
                      <th dir="ltr">
                        {{ returnTotal().toLocaleString() }}
                        UM
                      </th>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <CreateImpot
    :mois="addingImpotMois"
    :boulanger_id="props.boulanger.id"
    :show="showModal2"
    @modal-closed="modalClosed"
  />

  <EditImpot
    :recette_id="editingBoulangerId"
    :show="showModal"
    @modal-closed="modalClosed2"
  />
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useSwalConfirm, useSwalError, useSwalSuccess } from "../../composables/alert";
import { router } from "@inertiajs/vue3";
import EditImpot from "./EditImpot.vue";
import CreateImpot from "./CreateImpot.vue";

const etatImpot = {
  PAYE: "دفعت",
  NONPAYE: "لم تدفع",
  SEMIPAYE: "تسوية",
  FERMER: "مغلقة",
  EXONERER: "إعفاء",
};
document.title = "Liste des impots 2024";

const editingBoulangerId = ref(0);
const addingImpotMois = ref("");
const showModal = ref(false);
const showModal2 = ref(false);

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
  boulanger: Object,
  recettes: Object,
});

let createModel = "";

onMounted(() => {
  createModel = $("#addImpotBolanger");
});

const modalClosed = () => {
  addingImpotMois.value = "";
  editingBoulangerId.value = 0;
  showModal2.value = false;
};

const modalClosed2 = () => {
  editingBoulangerId.value = 0;
  showModal.value = false;
};

const addImpotBoulanger = (id) => {
  addingImpotMois.value = id;
  showModal2.value = true;
};

const openEditImpotBoulanger = (id) => {
  editingBoulangerId.value = id;
  showModal.value = true;
};

const deleteImpotBoulanger = (id) => {
  const url = route("recette.destroy", { recette: id });
  router.delete(url, {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("تم مسح الجباية بنجاح");
    },
    onError: (errors) => {
      // afficher un message d'error
      useSwalError(errors[0]);
    },
  });
};

const deleteConfimation = (id) => {
  const message = "هل انت متأكد من مسح هذه الجباية؟";
  useSwalConfirm(message, () => {
    deleteImpotBoulanger(id);
  });
};

const recetteImpot = (monthId) => {
  let impots = Object;
  for (let recette of props.recettes) {
    if (recette.month == monthId) {
      impots = recette;
    }
  }
  return impots;
};
const returnTotal = function () {
  var total = 0;
  props.recettes.forEach((element) => {
    total += element.montant;
  });
  return total;
};
</script>
