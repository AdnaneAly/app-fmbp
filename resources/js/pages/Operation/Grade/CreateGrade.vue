<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createGrade"
    >
        <i class="fa fa-plus"></i> إضافة
    </button>

    <div
        class="modal fade"
        id="createGrade"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        @click="closeModel"
                        class="close"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">إضافة رتبة جديدة :</h4>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="createFormGrade"
                    >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="InputName">إسم الرتبة :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="ادخل اسم الرتبة هنا..."
                                        v-model="nameGrade"
                                        :class="{
                                            'is-invalid': nameError != '',
                                        }"
                                        :autofocus="true"
                                    />
                                    <span
                                        v-if="nameError != ''"
                                        class="error invalid-feedback"
                                        >{{ nameError }}</span
                                    >
                                </div>

                                <!-- /.form-group -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="submit"
                        form="createFormGrade"
                        class="btn btn-success"
                    >
                        حفظ الرتبة
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="closeModel"
                    >
                        إلغاء
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";

const nameError = ref("");

const nameGrade = ref("");

let createModel = "";

onMounted(() => {
    createModel = $("#createGrade");
});

const closeModel = () => {
    createModel.modal("hide");
    nameGrade.value = "";
};

const soumettre = () => {
    const name = nameGrade.value;
    const url = route("operationgrade.store");
    router.post(
        url,
        { name },
        {
            onSuccess: (page) => {
                closeModel();
                // afficher un message de succes
                useSwalSuccess("لقد تمت إضافة الرتبة بنجاح !");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.name != null) {
                    nameError.value = errors.name;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

</script>
