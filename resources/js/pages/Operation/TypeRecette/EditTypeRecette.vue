<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditTypeRecette"
        style="display: none; text-align: right;"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
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
                        تعديل نوع الدخل : {{ editTypeRecette.name }}
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
                                    <label for="InputName">أسم نوع الدخل :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="ادخل الاسم هنا..."
                                        v-model="editTypeRecette.name"
                                        :class="{
                                            'is-invalid':
                                                editTypeRecette.messageError.hasOwnProperty('name'),
                                        }"
                                    />
                                    <span
                                        v-if="editTypeRecette.messageError.hasOwnProperty('name')"
                                        class="error invalid-feedback"
                                        >{{ editTypeRecette.messageError.name }}</span
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
    typerecette_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
});

const editTypeRecette = reactive({
    id: "",
    name: "",
    messageError: {},
});

const openModal = () => {
    getTypeRecetteById();
    $("#EditTypeRecette").modal("show");
};

const closeModal = () => {
    $("#EditTypeRecette").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("operationtyperecette.update", { typerecette: props.typerecette_id });
    router.put(
        url,
        {
            name: editTypeRecette.name,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le typerecette edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editTypeRecette.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getTypeRecetteById = () => {
    axios
        .get(route("operationtyperecette.edit", { typerecette: props.typerecette_id }))
        .then((response) => {
            editTypeRecette.id = response.data.typerecette.id;
            editTypeRecette.name = response.data.typerecette.name;
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
