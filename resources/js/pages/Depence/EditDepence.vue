<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditDepence"
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
                        تعديل مصروف
                    </h4>
                </div>
                <div class="modal-body">
                    <form action="" @submit.prevent="soumettre" id="editForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputDate">التاريخ :</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editDepence.dateDepence"
                                        :class="{
                                            'is-invalid':
                                                editDepence.messageError.hasOwnProperty(
                                                    'date'
                                                ),
                                        }"
                                    />
                                    <span
                                        v-if="
                                            editDepence.messageError.hasOwnProperty(
                                                'date'
                                            )
                                        "
                                        class="error invalid-feedback"
                                        >{{
                                            editDepence.messageError.date
                                        }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label>إسم المستفيد :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editDepence.employeurIdDepence"
                                    >
                                        <option value="" selected="selected">
                                            إختر...
                                        </option>
                                        <option
                                            v-for="item in props.employeurs"
                                            :value="item.id"
                                            :key="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نوع المصروف :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="
                                            editDepence.typedepenceIdDepence
                                        "
                                    >
                                        <option value="" selected="selected">
                                            إختر...
                                        </option>
                                        <option
                                            v-for="item in props.typedepences"
                                            :value="item.id"
                                            :key="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="InputMontant">المبلغ : </label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontant"
                                        v-model="editDepence.montantDepence"
                                        :class="{
                                            'is-invalid':
                                                editDepence.messageError.hasOwnProperty(
                                                    'montant'
                                                ),
                                        }"
                                    />
                                    <span
                                        v-if="
                                            editDepence.messageError.hasOwnProperty(
                                                'montant'
                                            )
                                        "
                                        class="error invalid-feedback"
                                        >{{
                                            editDepence.messageError.montant
                                        }}</span
                                    >
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>ملاحظات :</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        v-model="editDepence.descriptionDepence"
                                    ></textarea>
                                </div>
                            </div>
                            <!-- /.col -->
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
    depence_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    employeurs: Object,
    typedepences: Object,
});

const editDepence = reactive({
    id: "",
    typedepenceIdDepence: "",
    employeurIdDepence: "",
    montantDepence: "",
    dateDepence: "",
    descriptionDepence: "",
    annee: "2024",
    created_by: 1,
    messageError: {},
});

const openModal = () => {
    getDepenceById();
    $("#EditDepence").modal("show");
};

const closeModal = () => {
    $("#EditDepence").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("depence.update", { depence: props.depence_id });
    router.put(
        url,
        {
            type_depence_id: editDepence.typedepenceIdDepence,
            employeur_id: editDepence.employeurIdDepence,
            montant: editDepence.montantDepence,
            date: editDepence.dateDepence,
            created_by: editDepence.created_by,
            description: editDepence.descriptionDepence,
            annee: editDepence.annee,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("لقد تم تعديل المصروف بنجاح !");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editDepence.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getDepenceById = () => {
    axios
        .get(route("depence.edit", { depence: props.depence_id }))
        .then((response) => {
            editDepence.id = response.data.depence.id;
            editDepence.typedepenceIdDepence =
                response.data.depence.type_depence_id;
            editDepence.employeurIdDepence = response.data.depence.employeur_id;
            editDepence.montantDepence = response.data.depence.montant;
            editDepence.dateDepence = response.data.depence.date;
            editDepence.descriptionDepence = response.data.depence.description;
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
