<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditObservation"
        style="display: none; text-align: right;"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl">
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
                        تعديل معلومات العامل : {{ editObservation.nameObservation }}
                    </h4>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="editForm"
                    >
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>المخبزة :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editObservation.boulanger_id"
                                    >
                                        <option v-for="item in props.boulangers" :value="item.id" :key="item.id" >{{ item.name }}</option>

                                    </select>
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>العامل :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editObservation.employeur_id"
                                    >
                                        <option v-for="item in props.employeurs" :value="item.id" :key="item.id" >{{ item.name }}</option>

                                    </select>
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="InputDate">التاريخ  :</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editObservation.date"
                                        :class="{
                                            'is-invalid': editObservation.messageError.hasOwnProperty('date'),
                                        }"
                                    />
                                    <span
                                        v-if="editObservation.messageError.hasOwnProperty('date')"
                                        class="error invalid-feedback"
                                        >{{ editObservation.messageError.date }}</span
                                    >
                                </div>

                            </div>

                            <!-- /.col -->
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label>ملاحظات :</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        v-model="editObservation.message"
                                    ></textarea>
                                </div>
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
import { useSwalSuccess, useSwalError } from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);

const props = defineProps({
    observation_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    boulangers: Object,
    employeurs: Object,
});

const editObservation = reactive({
    id: "",
    date: null,
    boulanger_id: "",
    employeur_id: "",
    created_by: 1,
    message: "",
    annee: "2024",
    messageError: {},
});

const openModal = () => {
    getObservationById();
    $("#EditObservation").modal("show");
};

const closeModal = () => {
    $("#EditObservation").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("observation.update", { observation: props.observation_id });
    router.put(
        url,
        {
            boulanger_id: editObservation.boulanger_id,
            employeur_id: editObservation.employeur_id,
            created_by: editObservation.created_by,
            date: editObservation.date,
            annee: editObservation.annee,
            message: editObservation.message,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("لقد تم تعديل الملاحظة بنجاح !");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editObservation.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getObservationById = () => {
    axios
        .get(route("observation.edit", { observation: props.observation_id }))
        .then((response) => {
            editObservation.id = response.data.observation.id;
            editObservation.boulanger_id = response.data.observation.boulanger_id;
            editObservation.employeur_id = response.data.observation.employeur_id;
            editObservation.created_by = response.data.observation.created_by;
            editObservation.date = response.data.observation.date;
            editObservation.annee = response.data.observation.annee;
            editObservation.message = response.data.observation.message;
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
