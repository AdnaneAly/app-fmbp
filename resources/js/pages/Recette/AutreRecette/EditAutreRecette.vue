<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditAutreRecette"
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
                        تعديل دخل آخر
                    </h4>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="editForm"
                    >
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>نوع الدخل :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="editAutreRecette.type_recette_id"
                                        :class="{
                                            'is-invalid':
                                                editAutreRecette.messageError.hasOwnProperty('type_recette_id'),
                                        }"
                                    >
                                    <option v-for="item in props.typerecettes" :value="item.id" :key="item.id" >{{ item.name }}</option>
                                    </select>
                                    <span
                                        v-if="editAutreRecette.messageError.hasOwnProperty('type_recette_id')"
                                        class="error invalid-feedback"
                                        >{{ editAutreRecette.messageError.type_recette_id }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="InputMontant">المبلغ :</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontant"
                                        v-model="editAutreRecette.montant"
                                        :class="{
                                            'is-invalid':
                                                editAutreRecette.messageError.hasOwnProperty('montant'),
                                        }"
                                    />
                                    <span
                                        v-if="editAutreRecette.messageError.hasOwnProperty('montant')"
                                        class="error invalid-feedback"
                                        >{{ editAutreRecette.messageError.montant }}</span
                                    >
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputDate">التاريخ :</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="editAutreRecette.date"
                                        :class="{
                                            'is-invalid':
                                                editAutreRecette.messageError.hasOwnProperty(
                                                    'date'
                                                ),
                                        }"
                                    />
                                    <span
                                        v-if="
                                            editAutreRecette.messageError.hasOwnProperty(
                                                'date'
                                            )
                                        "
                                        class="error invalid-feedback"
                                        >{{
                                            editAutreRecette.messageError.date
                                        }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputFacture">رقم الوصل :</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputFacture"
                                        v-model="editAutreRecette.numeroFacture"
                                        :class="{
                                            'is-invalid':
                                                editAutreRecette.messageError.hasOwnProperty('numeroFacture'),
                                        }"
                                    />
                                    <span
                                        v-if="editAutreRecette.messageError.hasOwnProperty('numeroFacture')"
                                        class="error invalid-feedback"
                                        >{{ editAutreRecette.messageError.numeroFacture }}</span
                                    >
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>ملاحظات :</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        v-model="editAutreRecette.description"
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
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);

const props = defineProps({
    autrerecette_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    typerecettes: Object
});

const editAutreRecette = reactive({
    id: "",
    numeroFacture: "",
    type_recette_id: "",
    montant: "",
    date: null,
    description: "",
    created_by: 1,
    annee: "2024",
    messageError: {},
});

const openModal = () => {
    getAutreRecetteById();
    $("#EditAutreRecette").modal("show");
};

const closeModal = () => {
    $("#EditAutreRecette").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("autrerecette.update", { autrerecette: props.autrerecette_id });
    router.put(
        url,
        {
            montant: editAutreRecette.montant,
            numeroFacture: editAutreRecette.numeroFacture,
            type_recette_id: editAutreRecette.type_recette_id,
            date: editAutreRecette.date,
            description: editAutreRecette.description,
            created_by: editAutreRecette.created_by,
            annee: editAutreRecette.annee,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le autrerecetteie edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editAutreRecette.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getAutreRecetteById = () => {
    axios
        .get(route("autrerecette.edit", { autrerecette: props.autrerecette_id }))
        .then((response) => {
            editAutreRecette.id = response.data.autreRecette.id;
            editAutreRecette.montant = response.data.autreRecette.montant;
            editAutreRecette.numeroFacture = response.data.autreRecette.numeroFacture;
            editAutreRecette.date = response.data.autreRecette.date;
            editAutreRecette.type_recette_id = response.data.autreRecette.type_recette_id;
            editAutreRecette.description = response.data.autreRecette.description;
            editAutreRecette.annee = response.data.autreRecette.annee;
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
