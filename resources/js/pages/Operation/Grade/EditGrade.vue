<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditGrade"
        style="display: none; text-align: right;"
        aria-hidden="true"
    >
        <div  class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <button
                        type="button"
                        class="close"
                        @click="closeModal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">
                        تعديل الرتبة : {{ editGrade.name }}
                    </h4>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="editForm"
                    >
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="InputName">إسم الرتبة :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="اكتب اسم الرتبة هنا..."
                                        v-model="editGrade.name"
                                        :class="{
                                            'is-invalid':
                                                editGrade.messageError.hasOwnProperty('name'),
                                        }"
                                    />
                                    <span
                                        v-if="editGrade.messageError.hasOwnProperty('name')"
                                        class="error invalid-feedback"
                                        >{{ editGrade.messageError.name }}</span
                                    >
                                </div>


                                <!-- /.form-group -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        form="editForm"
                        type="submit"
                        class="btn btn-success"
                    >
                        حفظ التعديل
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="closeModal"
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
import axios from "axios";
import { reactive, watch } from "vue";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);

const props = defineProps({
    grade_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
});

const editGrade = reactive({
    id: "",
    name: "",
    messageError: {},
});

const openModal = () => {
    getGradeById();
    $("#EditGrade").modal("show");
};

const closeModal = () => {
    $("#EditGrade").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("operationgrade.update", { grade: props.grade_id });
    router.put(
        url,
        {
            name: editGrade.name,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("لقد تم تعديل الرتبة بنجاح !");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editGrade.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getGradeById = () => {
    axios
        .get(route("operationgrade.edit", { grade: props.grade_id }))
        .then((response) => {
            editGrade.id = response.data.grade.id;
            editGrade.name = response.data.grade.name;
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
