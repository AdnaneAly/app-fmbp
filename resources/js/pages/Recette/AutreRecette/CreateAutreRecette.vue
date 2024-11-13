<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createAutreRecette"
    >
        <i class="fa fa-plus"></i> إضافة
    </button>

    <div
        class="modal fade"
        id="createAutreRecette"
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
                    <h4 class="modal-title">إضافة دخل آخر جديد</h4>

                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="createFormAutreRecette"
                    >
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>نوع الدخل :</label>
                                    <select
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="form.type_recette_id"
                                        :class="{
                                            'is-invalid':
                                                form.errors.type_recette_id,
                                        }"
                                    >
                                        <option selected value="">إختر...</option>
                                        <option
                                            v-for="item in props.typerecettes"
                                            :value="item.id"
                                            :key="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <span
                                        v-if="form.errors.type_recette_id"
                                        class="error invalid-feedback"
                                        >{{ form.errors.type_recette_id }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputMontant">المبلغ :</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontant"
                                        placeholder="ادخل المبلغ هنا..."
                                        v-model="form.montant"
                                        :class="{
                                            'is-invalid': form.errors.montant,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.montant"
                                        class="error invalid-feedback"
                                        >{{ form.errors.montant }}</span
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
                                        v-model="form.date"
                                        :class="{
                                            'is-invalid': form.errors.date,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.date"
                                        class="error invalid-feedback"
                                        >{{ form.errors.date }}</span
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
                                        :class="{
                                            'is-invalid': form.errors.numeroFacture,
                                        }"

                                    />
                                    <span
                                        v-if="form.errors.numeroFacture"
                                        class="error invalid-feedback"
                                        >{{ form.errors.numeroFacture }}</span
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
                                        placeholder="اكتب ملاحظة هنا ..."
                                        v-model="form.description"
                                    ></textarea>
                                    <input
                                        type="hidden"
                                        name="created_by"
                                        v-model="form.created_by"
                                    />
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="submit"
                        form="createFormAutreRecette"
                        class="btn btn-success"
                    >
                        حفظ الدخل
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
import { onMounted } from "vue";
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";

const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);

const form = useForm({
    date: formattedDate,
    numeroFacture: "",
    type_recette_id: "",
    created_by: 1,
    montant: "",
    description: "",
    annee: "2024",
});


const props = defineProps({
    typerecettes: Object,
});

let createModel = "";

onMounted(() => {
    createModel = $("#createAutreRecette");
});

const closeModel = () => {
    createModel.modal("hide");
    form.reset()
};

const soumettre = () => {
    form.post(route("autrerecette.store"), {
        onSuccess: (page) => {
            // afficher un message de succes
            closeModel();
            useSwalSuccess("Le autrerecetteie ajouté avec succés");
            form.reset();
        },
        onError: (errors) => {
            console.log(errors);
            useSwalError("Une erreur s'est produite");
            console.log(errors);
        },
    });
};
</script>
