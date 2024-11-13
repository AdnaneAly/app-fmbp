<template>
    <section dir="rtl" style="text-align: right" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan">
                    <i class="fas fa-bars"></i> قائمة الرتب
                </h4>
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
                                <div class="col-md-1">
                                    <div class="text-right">
                                        <CreateGrade />
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>الرتبة</th>
                                            <th style="width: 100px">
                                                العمليات
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="grade in props.grades.data"
                                            :key="grade.id"
                                        >
                                            <td>1.</td>
                                            <td>{{ grade.name }}</td>

                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditGrade(grade.id)
                                                    "
                                                    style="margin-left: 10px"
                                                    class="btn btn-info btn-sm"
                                                    href="#"
                                                >
                                                    <i
                                                        class="fas fa-pencil-alt"
                                                    >
                                                    </i>
                                                </button>
                                                <button
                                                    @click="
                                                        deleteConfimation(
                                                            grade.id
                                                        )
                                                    "
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
                                    :links="props.grades.links"
                                    :prev="props.grades.prev_page_url"
                                    :next="props.grades.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditGrade
        :grade_id="editingGradeId"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import CreateGrade from "./CreateGrade.vue";
import EditGrade from "./EditGrade.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingGradeId = ref(0);
const showModal = ref(false);

const props = defineProps({
    grades: Object,
});

const modalClosed = () => {
    editingGradeId.value = 0;
    showModal.value = false;
};

const openEditGrade = (id) => {
    editingGradeId.value = id;
    showModal.value = true;
};

const deleteGrade = (id) => {
    const url = route("operationgrade.destroy", { grade: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le grade supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer ce grade";
    useSwalConfirm(message, () => {
        deleteGrade(id);
    });
};
</script>
