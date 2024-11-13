<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditEmployeur"
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
                        تعديل معلومات العامل : {{ editEmployeur.nameEmployeur }}
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
                                    <label for="InputName">إسم العامل :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        v-model="editEmployeur.nameEmployeur"
                                        :class="{
                                            'is-invalid': editEmployeur.messageError.hasOwnProperty('name'),
                                        }"
                                    />
                                    <span
                                        v-if="editEmployeur.messageError.hasOwnProperty('name')"
                                        class="error invalid-feedback"
                                        >{{ editEmployeur.messageError.name }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputTel">رقم الهاتف :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputTel"
                                        v-model="editEmployeur.telEmployeur"
                                        :class="{
                                            'is-invalid': editEmployeur.messageError.hasOwnProperty('tel'),
                                        }"
                                    />
                                    <span
                                        v-if="editEmployeur.messageError.hasOwnProperty('tel')"
                                        class="error invalid-feedback"
                                        >{{ editEmployeur.messageError.has('tel') }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label>الحالة :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editEmployeur.etatEmployeur"
                                    >
                                        <option selected="selected">
                                            إختر...
                                        </option>
                                        <option value="active">يعمل حاليا</option>
                                        <option value="noActive">لم يعد يعمل</option>
                                    </select>
                                </div>


                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>الرتبة :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editEmployeur.gradeIdEmployeur"
                                    >
                                        <option v-for="item in props.grades" :value="item.id" :key="item.id" >{{ item.name }}</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="InputNNI">رقم بطاقة التعريف :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputNNI"
                                        v-model="editEmployeur.nniEmployeur"
                                        :class="{
                                            'is-invalid': editEmployeur.messageError.hasOwnProperty('nni'),
                                        }"
                                    />
                                    <span
                                        v-if="editEmployeur.messageError.hasOwnProperty('nni')"
                                        class="error invalid-feedback"
                                        >{{ editEmployeur.messageError.nni }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label>ملاحظات :</label>
                                    <textarea
                                        class="form-control"
                                        rows="1"
                                        v-model="editEmployeur.descriptionEmployeur"
                                    ></textarea>
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="InputDate">تاريخ الاكتتاب :</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editEmployeur.dateEmployeur"
                                        :class="{
                                            'is-invalid': editEmployeur.messageError.hasOwnProperty('date'),
                                        }"
                                    />
                                    <span
                                        v-if="editEmployeur.messageError.hasOwnProperty('date')"
                                        class="error invalid-feedback"
                                        >{{ editEmployeur.messageError.date }}</span
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="InputMontantSalaire">المرتب :</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontantSalaire"
                                        v-model="editEmployeur.montantsalaireEmployeur"
                                        :class="{
                                            'is-invalid': editEmployeur.messageError.hasOwnProperty('montantSalaire'),
                                        }"
                                    />
                                    <span
                                        v-if="editEmployeur.messageError.hasOwnProperty('montantSalaire')"
                                        class="error invalid-feedback"
                                        >{{ editEmployeur.messageError.montantSalaire }}</span
                                    >
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
    employeur_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    grades: Object,
});

const editEmployeur = reactive({
    id: "",
    nameEmployeur: "",
    gradeIdEmployeur: "",
    montantsalaireEmployeur: "",
    telEmployeur: "",
    nniEmployeur: "",
    dateEmployeur: "",
    etatEmployeur: "",
    descriptionEmployeur: "",
    messageError: {},
});

const openModal = () => {
    getEmployeurById();
    $("#EditEmployeur").modal("show");
};

const closeModal = () => {
    $("#EditEmployeur").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("employeur.update", { employeur: props.employeur_id });
    router.put(
        url,
        {
            name: editEmployeur.nameEmployeur,
            grade_id: editEmployeur.gradeIdEmployeur,
            montantSalaire: editEmployeur.montantsalaireEmployeur,
            tel: editEmployeur.telEmployeur,
            nni: editEmployeur.nniEmployeur,
            date: editEmployeur.dateEmployeur,
            etat: editEmployeur.etatEmployeur,
            description: editEmployeur.descriptionEmployeur,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("لقد تم تعديل العامل بنجاح !");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editEmployeur.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getEmployeurById = () => {
    axios
        .get(route("employeur.edit", { employeur: props.employeur_id }))
        .then((response) => {
            editEmployeur.id = response.data.employeur.id;
            editEmployeur.nameEmployeur = response.data.employeur.name;
            editEmployeur.gradeIdEmployeur = response.data.employeur.grade_id;
            editEmployeur.telEmployeur = response.data.employeur.tel;
            editEmployeur.nniEmployeur = response.data.employeur.nni;
            editEmployeur.dateEmployeur = response.data.employeur.date;
            editEmployeur.montantsalaireEmployeur = response.data.employeur.montantSalaire;
            editEmployeur.etatEmployeur = response.data.employeur.etat;
            editEmployeur.descriptionEmployeur = response.data.employeur.description;
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
