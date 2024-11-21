<template>
  <section dir="rtl" style="text-align: right" class="content-header">
    <div class="card card-cyan card-outline mx-2">
      <div class="card-header">
        <h4 class="text-cyan"><i class="fas fa-bars"></i> قائمة مصاريف العتاد</h4>
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
                    <CreateMoyenne />
                  </div>

                  <div class="col-md-2">
                    <select @change="search" v-model="month" class="form-control ml-3">
                      <option value="" selected>الشهر...</option>
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
                        route('moyenne.print', {
                          per_page,
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
                      <th>نوع المصروف</th>
                      <th>الطراز</th>
                      <th>المرجع أو اللوحة</th>
                      <th>التاريخ</th>
                      <th>المبلغ</th>
                      <th style="width: 100px">العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(moyenne, index) in props.moyennes.data" :key="index">
                      <td>{{ index + 1 }}.</td>
                      <td>
                        {{ moyenne.type }}
                      </td>
                      <td>
                        {{ moyenne.niveau }}
                      </td>
                      <td>
                        {{ moyenne.reference }}
                      </td>

                      <td>{{ moyenne.date }}</td>
                      <th dir="ltr">{{ moyenne.montant.toLocaleString() }} UM</th>

                      <td class="d-flex gap-2 text-left">
                        <button
                          style="margin-left: 10px"
                          class="btn btn-info btn-sm"
                          @click="openEditMoyenne(moyenne.id)"
                        >
                          <i class="fas fa-pencil-alt"> </i>
                        </button>
                        <button
                          @click="deleteConfimation(moyenne.id)"
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
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="card-footer clearfix">
                <Pagination
                  :links="props.moyennes.links"
                  :prev="props.moyennes.prev_page_url"
                  :next="props.moyennes.next_page_url"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <EditMoyenne
    :moyenne_id="editingMoyenneId"
    :show="showModal"
    @modal-closed="modalClosed"
  />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import { useSwalConfirm, useSwalError, useSwalSuccess } from "../../../composables/alert";
import { router } from "@inertiajs/vue3";
import CreateMoyenne from "./CreateMoyenne.vue";
import EditMoyenne from "./EditMoyenne.vue";

const per_page = ref("");
const editingMoyenneId = ref(0);
const showModal = ref(false);
const month = ref("");

const props = defineProps({
  moyennes: Object,
});
const modalClosed = () => {
  editingMoyenneId.value = 0;
  showModal.value = false;
};

const openEditMoyenne = (id) => {
  editingMoyenneId.value = id;
  showModal.value = true;
};

const deleteMoyenne = (id) => {
  const url = route("moyenne.destroy", { moyenne: id });
  router.delete(url, {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("La moyenne supprime avec succés");
    },
    onError: (errors) => {
      // afficher un message d'error
      useSwalError(errors[0]);
    },
  });
};

const deleteConfimation = (id) => {
  const message = "Etes vous sur de supprimer cet moyenne";
  useSwalConfirm(message, () => {
    deleteMoyenne(id);
  });
};

const returnTotal = function () {
  var total = 0;
  props.moyennes.data.forEach((element) => {
    total += element.montant;
  });
  return total;
};

const search = _.throttle(() => {
  const url = route("moyenne.index", {
    per_page: per_page.value,
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
