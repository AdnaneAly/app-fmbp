<template>
  <div
    dir="rtl"
    class="modal fade"
    id="EditComment"
    style="display: none; text-align: right"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" @click="closeModal" class="close" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title">إضافة ملاحظة على مخبزة : {{ boulanger.name }}</h4>
        </div>
        <div class="modal-body">
          <form action="" @submit.prevent="soumettre" id="EditFormComment">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputDate">تاريخ الملاحظة : </label>
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
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <div class="form-group">
                  <label>العامل :</label>
                  <select
                    class="form-control"
                    style="width: 100%"
                    v-model="form.employeur_id"
                    :class="{
                      'is-invalid': form.errors.employeur_id,
                    }"
                  >
                    <option selected value="">إختر العامل</option>
                    <option
                      v-for="item in props.employeurs"
                      :value="item.id"
                      :key="item.id"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                  <span v-if="form.errors.employeur_id" class="error invalid-feedback">{{
                    form.errors.employeur_id
                  }}</span>
                </div>

                <!-- /.form-group -->
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="InputImage">صورة توثق الحدث :</label>
                  <div class="custom-file">
                    <label class="custom-file-label text-left" for="InputImage"
                      >ضع الصورة هنا
                    </label>
                    <input
                      type="file"
                      class="custom-file-input"
                      id="InputImage"
                      ref="image"
                      @input="form.image = $event.target.files[0]"
                      multiple=""
                      accept="image/jpeg, image/png"
                      :class="{
                        'is-invalid': form.errors.image,
                      }"
                    />
                  </div>

                  <span v-if="form.errors.image" class="error invalid-feedback">{{
                    form.errors.image
                  }}</span>
                </div>
                <!-- /.form-group -->
              </div>

              <!-- /.col -->
            </div>
            <div class="row">
              <div class="col-md-12">
                <!-- textarea -->
                <div class="form-group">
                  <label>ملاحظات :</label>
                  <textarea
                    class="form-control"
                    rows="2"
                    placeholder="اكتب الملاحظات هنا ..."
                    v-model="form.message"
                  ></textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" form="EditFormComment" class="btn btn-success">
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
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../composables/alert";
import axios from "axios";

const emit = defineEmits(["modalClosed"]);
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);

const image = ref("");

const props = defineProps({
  comment_id: {
    type: Number,
    required: true,
  },
  boulanger: {
    type: Object,
    required: true,
  },
  employeurs: {
    type: Object,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
});

const form = useForm({
  observation_id: "",
  employeur_id: "",
  created_by: 1,
  image: null,
  message: "",
  date: null,
  annee: "2024",
});

const openModal = () => {
  getCommentById();
  $("#EditComment").modal("show");
};

const closeModal = () => {
  $("#EditComment").modal("hide");
  emit("modalClosed");
};

const soumettre = () => {
  form.post(route("comment.updateComment", { comment: props.comment_id }), {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("لقد تمت تعديل الملاحظة بنجاح !");
      form.reset();
      closeModal();
    },
    onError: (errors) => {
      console.log(errors);
      useSwalError("Une erreur s'est produit");
    },
  });
};

const getCommentById = () => {
  axios
    .get(route("comment.edit", { comment: props.comment_id }))
    .then((response) => {
      form.id = response.data.comment.id;
      form.observation_id = response.data.comment.observation_id;
      form.employeur_id = response.data.comment.employeur_id;
      form.created_by = response.data.comment.created_by;
      form.image = null;
      form.date = response.data.comment.date;
      form.annee = response.data.comment.annee;
      form.message = response.data.comment.message;
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
