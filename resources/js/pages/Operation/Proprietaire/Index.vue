<template>
  <section dir="rtl" style="text-align: right" class="content-header">
    <div class="card card-cyan card-outline mx-2">
      <div class="card-header">
        <h4 class="text-cyan"><i class="fas fa-bars"></i> قائمة اصحاب المخابز</h4>
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
                    <div class="text-right">
                      <CreateProprietaire />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <input
                      @keyup="search"
                      v-model="searchProprietaire"
                      type="text"
                      class="form-control ml-3"
                      placeholder="أبحث عن إسم صاحب مخبزة "
                    />
                  </div>
                  <div class="col-md-2">
                    <select @change="search" v-model="per_page" class="form-control">
                      <option selected value="">عدد الاسطر...</option>
                      <option value="5">5</option>
                      <option value="10">10</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                    </select>
                  </div>
                  <div class="col-md-2 ml-2">
                    <Link
                      :href="
                        route('proprietaire.print', {
                          per_page,
                          searchProprietaire,
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
                      <th style="width: 10px">#</th>
                      <th>إسم صاحب المخبزة</th>
                      <th>رقم الهاتف</th>
                      <th>عدد المخابز</th>
                      <th style="width: 100px">العمليات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(proprietaire, i) in props.proprietaires.data"
                      :key="proprietaire.id"
                    >
                      <td>{{ i + 1 }}.</td>
                      <td>{{ proprietaire.name }}</td>
                      <td>{{ proprietaire.tel }}</td>
                      <td>
                        {{ proprietaire.boulangers.length }}
                      </td>

                      <td class="d-flex gap-2 text-left">
                        <button
                          @click="openEditProprietaire(proprietaire.id)"
                          style="margin-left: 10px"
                          class="btn btn-info btn-sm"
                          href="#"
                        >
                          <i class="fas fa-pencil-alt"> </i>
                        </button>
                        <button
                          @click="deleteConfimation(proprietaire.id)"
                          class="btn btn-danger btn-sm"
                        >
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="card-footer clearfix">
                <Pagination
                  :links="props.proprietaires.links"
                  :prev="props.proprietaires.prev_page_url"
                  :next="props.proprietaires.next_page_url"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <EditProprietaire
    :proprietaire_id="editingProprietaireId"
    :show="showModal"
    @modal-closed="modalClosed"
  />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import CreateProprietaire from "./CreateProprietaire.vue";
import EditProprietaire from "./EditProprietaire.vue";
import { useSwalConfirm, useSwalError, useSwalSuccess } from "../../../composables/alert";
import { Link, router } from "@inertiajs/vue3";

const editingProprietaireId = ref(0);
const showModal = ref(false);
const searchProprietaire = ref("");
const per_page = ref("");

const props = defineProps({
  proprietaires: Object,
});

const modalClosed = () => {
  editingProprietaireId.value = 0;
  showModal.value = false;
};

const openEditProprietaire = (id) => {
  editingProprietaireId.value = id;
  showModal.value = true;
};

const deleteProprietaire = (id) => {
  const url = route("operationproprietaire.destroy", { proprietaire: id });
  router.delete(url, {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("لقد تم مسح صاحب المخبزة بنجاح !");
    },
    onError: (errors) => {
      // afficher un message d'error
      useSwalError(errors[0]);
    },
  });
};

const deleteConfimation = (id) => {
  const message = "هل انت متأكد من مسح صاحب المخبزة ؟";
  useSwalConfirm(message, () => {
    deleteProprietaire(id);
  });
};

const search = _.throttle(() => {
  const url = route("operationproprietaire.index", {
    search: searchProprietaire.value,
    per_page: per_page.value,
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
