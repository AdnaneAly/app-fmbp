<template>
  <div
    dir="rtl"
    class="modal fade"
    id="EditBoulanger"
    style="display: none; text-align: right"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" @click="closeModal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">تعديل مخبزة : {{ editBoulanger.name }}</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="editForm">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputName">إسم المخبزة :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputName"
                    v-model="editBoulanger.name"
                    :class="{
                      'is-invalid': editBoulanger.messageError.hasOwnProperty('name'),
                    }"
                  />
                  <span
                    v-if="editBoulanger.messageError.hasOwnProperty('name')"
                    class="error invalid-feedback"
                    >{{ editBoulanger.messageError.name }}</span
                  >
                </div>
                <div class="form-group">
                  <label>المالك :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="editBoulanger.proprietaire_id"
                    :class="{
                      'is-invalid': editBoulanger.messageError.hasOwnProperty(
                        'proprietaire_id'
                      ),
                    }"
                  >
                    <option
                      v-for="item in props.proprietaires"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span
                    v-if="editBoulanger.messageError.hasOwnProperty('proprietaire_id')"
                    class="error invalid-feedback"
                    >{{ editBoulanger.messageError.proprietaire_id }}</span
                  >
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="InputAddress">مكان المخبزة :</label>
                  <input
                    type="text"
                    class="form-control"
                    id="InputAddress"
                    v-model="editBoulanger.address"
                    :class="{
                      'is-invalid': editBoulanger.messageError.hasOwnProperty('address'),
                    }"
                  />
                  <span
                    v-if="editBoulanger.messageError.hasOwnProperty('address')"
                    class="error invalid-feedback"
                    >{{ editBoulanger.messageError.address }}</span
                  >
                </div>
                <div class="form-group">
                  <label>حالة المخبزة :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="editBoulanger.etat"
                    :class="{
                      'is-invalid': editBoulanger.messageError.hasOwnProperty('etat'),
                    }"
                  >
                    <option selected="selected">إختر...</option>
                    <option value="active">تعمل حاليا</option>
                    <option value="noActive">لم تعد تعمل</option>
                  </select>
                  <span
                    v-if="editBoulanger.messageError.hasOwnProperty('etat')"
                    class="error invalid-feedback"
                    >{{ editBoulanger.messageError.etat }}</span
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
                    v-model="editBoulanger.description"
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

const props = defineProps({
  boulanger_id: {
    type: Number,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
  proprietaires: Object,
});

const editBoulanger = reactive({
  id: "",
  name: "",
  address: "",
  proprietaire_id: "",
  etat: "",
  description: "",
  created_by: 1,
  messageError: {},
});

const openModal = () => {
  getBoulangerById();
  $("#EditBoulanger").modal("show");
};

const closeModal = () => {
  $("#EditBoulanger").modal("hide");
  emit("modalClosed");
};

const soumettre = () => {
  const url = route("boulanger.update", { boulanger: props.boulanger_id });
  router.put(
    url,
    {
      name: editBoulanger.name,
      address: editBoulanger.address,
      proprietaire_id: editBoulanger.proprietaire_id,
      etat: editBoulanger.etat,
      description: editBoulanger.description,
      created_by: editBoulanger.created_by,
    },
    {
      onSuccess: (page) => {
        closeModal();
        // afficher un message de succes
        useSwalSuccess("لقد تم تعديل المخبزة بنجاح !");
      },
      onError: (errors) => {
        // afficher un message d'error
        if (errors.length != 0) {
          editBoulanger.messageError = errors;
        }
        useSwalError("Une erreur s'est produite");
      },
    }
  );
};

const getBoulangerById = () => {
  axios
    .get(route("boulanger.edit", { boulanger: props.boulanger_id }))
    .then((response) => {
      editBoulanger.id = response.data.boulanger.id;
      editBoulanger.name = response.data.boulanger.name;
      editBoulanger.address = response.data.boulanger.address;
      editBoulanger.etat = response.data.boulanger.etat;
      editBoulanger.proprietaire_id = response.data.boulanger.proprietaire_id;
      editBoulanger.description = response.data.boulanger.description;
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
