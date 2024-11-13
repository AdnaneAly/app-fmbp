<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditTypeDepence"
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
                        تعديل نوع المصروف : {{ editTypeDepence.name }}
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
                                    <label for="InputName">إسم نوع المصروف :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        v-model="editTypeDepence.name"
                                        :class="{
                                            'is-invalid':
                                                editTypeDepence.messageError.hasOwnProperty('name'),
                                        }"
                                    />
                                    <span
                                        v-if="editTypeDepence.messageError.hasOwnProperty('name')"
                                        class="error invalid-feedback"
                                        >{{ editTypeDepence.messageError.name }}</span
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
    typedepence_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
});

const editTypeDepence = reactive({
    id: "",
    name: "",
    messageError: {},
});

const openModal = () => {
    getTypeDepenceById();
    $("#EditTypeDepence").modal("show");
};

const closeModal = () => {
    $("#EditTypeDepence").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("operationtypedepence.update", { typedepence: props.typedepence_id });
    router.put(
        url,
        {
            name: editTypeDepence.name,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le typedepence edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editTypeDepence.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getTypeDepenceById = () => {
    axios
        .get(route("operationtypedepence.edit", { typedepence: props.typedepence_id }))
        .then((response) => {
            editTypeDepence.id = response.data.typedepence.id;
            editTypeDepence.name = response.data.typedepence.name;
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
