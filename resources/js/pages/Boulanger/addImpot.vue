<template>
    <div
        dir="rtl"
        class="modal fade"
        id="addImpotBolanger"
        style="display: none; text-align: right;"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <button
                        type="button"
                        @click="closeModal"
                        class="close"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">
                        إضافة جباية شهر : {{ props.mois }}
                    </h4>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="addFormImpotBoulanger"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>حالة الجباية :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="form.type_recette"
                                        @change="etatImpot($event)"
                                        :class="{
                                            'is-invalid':
                                                form.errors.type_recette,
                                        }"
                                    >
                                        <option value="" selected="selected">
                                            إختر...
                                        </option>
                                        <option value="PAYE">دفعت</option>
                                        <option value="SEMIPAYE">تسوية</option>
                                        <option value="FERMER">مغلقة</option>
                                        <option value="EXONERER">إعفاء</option>
                                    </select>
                                    <span
                                        v-if="form.errors.type_recette"
                                        class="error invalid-feedback"
                                        >{{ form.errors.type_recette }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputFacture">رقم الوصل :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputFacture"
                                        placeholder="ادخل رقم الوصل هنا..."
                                        v-model="form.numeroFacture"
                                        :disabled="
                                            form.type_recette === 'FERMER' ||
                                            form.type_recette === 'NONPAYE' ||
                                            form.type_recette === 'EXONERER'
                                        "
                                        :class="{
                                            'is-invalid':
                                                form.errors.numeroFacture,
                                        }"

                                    />
                                    <span
                                        v-if="form.errors.numeroFacture"
                                        class="error invalid-feedback"
                                        >{{ form.errors.numeroFacture }}</span
                                    >
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputAddress">مبلغ الجباية :</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputAddress"
                                        placeholder="ادخل المبلغ هنا ..."
                                        :disabled="
                                            form.type_recette !== 'SEMIPAYE'
                                        "
                                        v-model="form.montant"
                                        :class="{
                                            'is-invalid':
                                                form.errors.montant,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.montant"
                                        class="error invalid-feedback"
                                        >{{ form.errors.montant }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputDate">تاريخ العملية : </label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="InputDate"
                                        v-model="form.date"
                                        :class="{
                                            'is-invalid':
                                                form.errors.date,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.date"
                                        class="error invalid-feedback"
                                        >{{ form.errors.date }}</span
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
                                        placeholder="اكتب الملاحظات هنا ..."
                                        v-model="form.description"
                                    ></textarea>
                                    <input type="hidden" v-model="monthImpot" />
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">

                    <button
                        type="submit"
                        form="addFormImpotBoulanger"
                        class="btn btn-success"
                    >
                        حفظ الجباية
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
import { watch, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../composables/alert";

const emit = defineEmits(["modalClosed"]);
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
let monthImpot = "";

const props = defineProps({
    boulanger_id: {
        type: Number,
        required: true,
    },
    mois: {
        type: String,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
});

const form = useForm({
    boulanger_id: props.boulanger_id,
    type_recette: "",
    created_by: 1,
    montant: "",
    numeroFacture: "",
    date: formattedDate,
    month: "",
    annee: "2024",
    description: "",
});

const openModal = () => {
    $("#addImpotBolanger").modal("show");
    form.month = props.mois;
};

const closeModal = () => {
    $("#addImpotBolanger").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    form.post(route("recette.store"), {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le impot ajouté avec succés");
            form.reset();
            closeModal();
        },
        onError: (errors) => {
            console.log(errors);
            useSwalError("Une erreur s'est produit");
        },
    });
};

const etatImpot = (event) => {
    if (event.target.value == "PAYE") {
        form.montant = 55000;
    } else {
        form.montant = 0;
    }
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
