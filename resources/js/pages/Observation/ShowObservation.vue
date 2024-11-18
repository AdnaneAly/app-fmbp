<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section dir="rtl" style="text-align: right" class="content-header">
      <div class="card card-cyan card-outline mx-2">
        <div class="card-header">
          <div class="card-default">
            <div class="row">
              <div class="col-md-5">
                <h4 class="text-cyan">
                  <i class="fas fa-bars"></i>ملاحظات على مخبزة :
                  {{ props.observations.boulanger.name }}
                </h4>
              </div>
              <div class="col-md-7 text-left">
                <Link
                  style="margin-right: 10px"
                  :href="route('observation.prints', { id: props.observations.id })"
                  class="btn btn-success"
                  ><i class="fas fa-print"></i> طباعة</Link
                >
                <button
                  style="margin-right: 10px"
                  class="btn btn-primary"
                  @click="addCommentBoulanger(props.observations.boulanger_id)"
                >
                  <i class="fas fa-plus"></i> إضافة
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">{{ props.observations.date }}</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div dir="rtl" style="text-align: right">
                <div class="timeline-item">
                  <span class="time float-left"><i class="fas fa-clock"></i> 7:56</span>
                  <h3 class="timeline-header">
                    المخبزة :
                    {{ props.observations.boulanger.name }}
                  </h3>

                  <div class="timeline-body">
                    {{ props.observations.message }}
                  </div>
                  <div class="timeline-footer">
                    <small class="text-blue"
                      >العامل : {{ props.observations.employeur.name }}</small
                    >
                  </div>
                </div>
              </div>

              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div
                v-for="comment in props.observations.comments"
                :key="comment.id"
                dir="rtl"
                style="text-align: right"
              >
                <i
                  :class="
                    comment.image === null
                      ? 'fas fa-comments bg-yellow'
                      : 'fas fa-camera bg-purple'
                  "
                ></i>
                <div class="timeline-item">
                  <span class="time float-left"
                    ><i class="fas fa-clock"></i>{{ comment.date }}</span
                  >
                  <h3 class="timeline-header">
                    المراقب : {{ employeur[comment.employeur_id] }}
                  </h3>
                  <div class="timeline-body">{{ comment.message }}</div>
                  <div class="timeline-body">
                    <div
                      class="filtr-item text-center"
                      data-category="3, 4"
                      data-sort="red sample"
                    >
                      <a
                        href="#"
                        :hidden="comment.image === null"
                        data-toggle="lightbox"
                        data-title=""
                      >
                        <img
                          :src="pic(comment.image)"
                          class="img-fluid mb-2"
                          alt="red sample"
                        />
                      </a>
                    </div>
                  </div>
                  <div class="timeline-footer">
                    <button
                      style="margin-right: 10px; margin-left: 10px"
                      class="btn btn-info btn-sm"
                      @click="openEditComment(comment.id)"
                      title="تعديل"
                    >
                      <i class="fas fa-pencil-alt"> </i>
                      تعديل
                    </button>
                    <button
                      @click="deleteConfimation(comment.id)"
                      class="btn btn-danger btn-sm"
                      title="مسح"
                    >
                      <i class="fa fa-trash"></i>مسح
                    </button>
                    <form
                      action="#"
                      method="post"
                      id="delete-"
                      style="display: none"
                    ></form>
                  </div>
                </div>
              </div>

              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <AddComment
    :observation_id="props.observations.id"
    :boulanger="props.observations.boulanger"
    :show="showModal"
    :employeurs="props.employeurs"
    @modal-closed="modalClosed"
  />

  <EditComment
    :comment_id="editingCommentId"
    :boulanger="props.observations.boulanger"
    :employeurs="props.employeurs"
    :show="showModal2"
    @modal-closed="modalClosed2"
  />
</template>
<script setup>
import { ref } from "vue";
import AddComment from "./AddComment.vue";
import { useSwalConfirm, useSwalError, useSwalSuccess } from "../../composables/alert";
import { Link, router } from "@inertiajs/vue3";
import EditComment from "./EditComment.vue";

const addingComment = ref("");
const editingCommentId = ref(0);
const showModal = ref(false);
const showModal2 = ref(false);

const props = defineProps({
  observations: Object,
  employeurs: Object,
  employeur: Object,
});

const modalClosed = () => {
  addingComment.value = "";
  showModal.value = false;
};

const addCommentBoulanger = (id) => {
  addingComment.value = id;
  showModal.value = true;
};

const modalClosed2 = () => {
  editingCommentId.value = 0;
  showModal2.value = false;
};

const openEditComment = (id) => {
  editingCommentId.value = id;
  showModal2.value = true;
};

const deleteCommentBoulanger = (id) => {
  const url = route("comment.destroy", { comment: id });
  router.delete(url, {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("Le comment supprime avec succés");
    },
    onError: (errors) => {
      // afficher un message d'error
      useSwalError("Une erreur s'est produite");
    },
  });
};

const deleteConfimation = (id) => {
  const message = "Etes vous sur de supprimer cette boulangerie";
  useSwalConfirm(message, () => {
    deleteCommentBoulanger(id);
  });
};

const pic = (imageUrl) => {
  return imageUrl !== null ? "/storage/" + imageUrl : "";
};
</script>
