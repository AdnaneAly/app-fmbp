<template>
  <section dir="rtl" style="text-align: right" class="content-header">
    <div class="card card-cyan card-outline mx-2">
      <div class="card-header">
        <h4 class="text-cyan"><i class="fas fa-bars"></i> قائمة مصاريف المقدمات</h4>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>

  <div dir="rtl" style="text-align: right" class="content">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-1">
                    <CreateAvanceSalaire :employeurs="props.employeurs" />
                  </div>

                  <div class="col-md-2">
                    <select @change="search" v-model="employeur_id" class="form-control">
                      <option value="" selected>المستفيد...</option>
                      <option
                        v-for="item in props.employeurs"
                        :value="item.id"
                        :key="item.id"
                      >
                        {{ item.name }}
                      </option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <select
                      @change="search"
                      v-model="etatDepence"
                      class="form-control ml-3"
                    >
                      <option value="">الحالة...</option>
                      <option value="paye">تم الدفع</option>
                      <option value="noPaye">لم تدفع بعد</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <select @change="search" v-model="month" class="form-control ml-3">
                      <option value="" selected>شهر المقدمات...</option>
                      <option value="1">يناير</option>
                      <option value="2">قبراير</option>
                      <option value="3">مارس</option>
                      <option value="4">ابريل</option>
                      <option value="5">مايو</option>
                      <option value="6">يونيو</option>
                      <option value="7">يوليو</option>
                      <option value="8">اغسطس</option>
                      <option value="9">سبتمبر</option>
                      <option value="10">اكتوبر</option>
                      <option value="11">نوفمبر</option>
                      <option value="12">دجمبر</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <select @change="search" v-model="per_page" class="form-control ml-3">
                      <option value="">عدد الأسطر...</option>
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                      <option value="500">500</option>
                    </select>
                  </div>
                  <div class="col-md-2 ml-3">
                    <Link
                      :href="
                        route('avancesalaire.print', {
                          per_page,
                          employeur_id,
                          etatDepence,
                          month,
                        })
                      "
                      class="btn btn-info"
                      ><i class="fa fa-print"></i> سحب</Link
                    >
                  </div>
                </div>
              </div>

              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 50px">#</th>
                      <th>العمال</th>
                      <th>الرتبة</th>
                      <th>الهاتف</th>
                      <th>التاريخ</th>
                      <th>المبلغ المقدم</th>
                      <th>الحالة</th>
                      <th style="width: 100px">العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(avancesalaire, index) in props.avancesalaires.data"
                      :key="index"
                    >
                      <td>{{ index + 1 }}.</td>
                      <td>
                        {{ avancesalaire.employeur.name }}
                      </td>
                      <td>
                        {{ grades[avancesalaire.employeur.grade_id] }}
                      </td>
                      <td>
                        {{ avancesalaire.employeur.tel }}
                      </td>

                      <td>{{ avancesalaire.date }}</td>
                      <th dir="ltr">
                        {{ avancesalaire.montantAvanceSalaire.toLocaleString() }} UM
                      </th>
                      <td>
                        <span
                          class="badge text-md"
                          :class="
                            avancesalaire.etat === 'paye' ? 'bg-success' : 'bg-danger'
                          "
                          >{{ etat[avancesalaire.etat] }}</span
                        >
                      </td>
                      <td class="d-flex gap-2 text-left">
                        <button
                          style="margin-left: 10px"
                          class="btn btn-info btn-sm"
                          @click="openEditAvanceSalaire(avancesalaire.id)"
                        >
                          <i class="fas fa-pencil-alt"> </i>
                        </button>
                        <button
                          @click="deleteConfimation(avancesalaire.id)"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr dir="ltr">
                      <th colspan="5">المجموع الكامل:</th>
                      <th>{{ returnTotal().toLocaleString() }} UM</th>
                      <td></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="card-footer clearfix">
                <Pagination
                  :links="props.avancesalaires.links"
                  :prev="props.avancesalaires.prev_page_url"
                  :next="props.avancesalaires.next_page_url"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <EditAvanceSalaire
    :avancesalaire_id="editingAvanceSalaireId"
    :employeurs="props.employeurs"
    :show="showModal"
    @modal-closed="modalClosed"
  />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import { useSwalConfirm, useSwalError, useSwalSuccess } from "../../../composables/alert";
import { router } from "@inertiajs/vue3";
import EditAvanceSalaire from "./EditAvanceSalaire.vue";
import CreateAvanceSalaire from "./CreateAvanceSalaire.vue";

const etat = {
  paye: "تم التسديد",
  noPaye: "لم يسدد بعد",
};

const employeur_id = ref("");
const per_page = ref("");
const editingAvanceSalaireId = ref(0);
const showModal = ref(false);
const etatDepence = ref("");
const month = ref("");

const props = defineProps({
  avancesalaires: Object,
  employeurs: Object,
  grades: Object,
});
const modalClosed = () => {
  editingAvanceSalaireId.value = 0;
  showModal.value = false;
};

const openEditAvanceSalaire = (id) => {
  editingAvanceSalaireId.value = id;
  showModal.value = true;
};

const deleteAvanceSalaire = (id) => {
  const url = route("avancesalaire.destroy", { avancesalaire: id });
  router.delete(url, {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("L'avance salaire supprime avec succés");
    },
    onError: (errors) => {
      // afficher un message d'error
      useSwalError(errors[0]);
    },
  });
};

const deleteConfimation = (id) => {
  const message = "Etes vous sur de supprimer cet avancesalaire";
  useSwalConfirm(message, () => {
    deleteAvanceSalaire(id);
  });
};

const returnTotal = function () {
  var total = 0;
  props.avancesalaires.data.forEach((element) => {
    total += element.montantAvanceSalaire;
  });
  return total;
};

const search = _.throttle(() => {
  const url = route("avancesalaire.index", {
    employeur_id: employeur_id.value,
    per_page: per_page.value,
    etatDepence: etatDepence.value,
    month: month.value,
  });
  router.get(
    url,
    {},
    {
      replace: true,
      preserveState: true,
    }
  );
}, 500);
</script>
