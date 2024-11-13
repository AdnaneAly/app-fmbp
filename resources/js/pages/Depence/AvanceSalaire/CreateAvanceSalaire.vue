<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createAvanceSalaire"
    >
        <i class="fa fa-plus"></i> إضافة
    </button>

    <div
        class="modal fade"
        id="createAvanceSalaire"
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
                    <h4 class="modal-title">إضافة مقدم راتب</h4>
                </div>
                <div class="modal-body">
                    <form
                        action=""
                        @submit.prevent="soumettre"
                        id="createFormAvanceSalaire"
                    >
                        <div class="row">
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
                                    <label for="InputMontantAvanceSalaire"
                                        >المبلغ المقدم :</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontantAvanceSalaire"
                                        placeholder="ادخل المبلغ المقدم هنا..."
                                        v-model="form.montantAvanceSalaire"
                                        :class="{
                                            'is-invalid':
                                                form.errors
                                                    .montantAvanceSalaire,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.montantAvanceSalaire"
                                        class="error invalid-feedback"
                                        >{{
                                            form.errors.montantAvanceSalaire
                                        }}</span
                                    >
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputEmployeur"
                                        >العامل المستفيد :</label
                                    >
                                    <select
                                        id="InputEmployeur"
                                        class="form-control"
                                        style="width: 100%"
                                        v-model="form.employeur_id"
                                        :class="{
                                            'is-invalid':
                                                form.errors.employeur_id,
                                        }"
                                        @change="getSalaire($event)"
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
                                    <span
                                        v-if="form.errors.employeur_id"
                                        class="error invalid-feedback"
                                        >{{ form.errors.employeur_id }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputMontantSalaire"
                                        >الراتب</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontantSalaire"
                                        :disabled="true"
                                        v-model="form.montantSalaire"
                                        :class="{
                                            'is-invalid':
                                                form.errors.montantSalaire,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.montantSalaire"
                                        class="error invalid-feedback"
                                        >{{ form.errors.montantSalaire }}</span
                                    >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>ملاحظات :</label>
                                    <textarea
                                        class="form-control"
                                        rows="1"
                                        placeholder="اكتب الملاحظات هنا..."
                                        v-model="form.description"
                                    ></textarea>
                                    <input
                                        type="hidden"
                                        name="created_by"
                                        v-model="form.created_by"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputMontantTotalAvancer"
                                        >مجموع ما تم تقديمه : </label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="InputMontantTotalAvancer"
                                        :disabled="true"
                                        v-model="form.montantTotalAvancer"
                                        :class="{
                                            'is-invalid':
                                                form.errors.montantTotalAvancer,
                                        }"
                                    />
                                    <span
                                        v-if="form.errors.montantTotalAvancer"
                                        class="error invalid-feedback"
                                        >{{
                                            form.errors.montantTotalAvancer
                                        }}</span
                                    >
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">

                    <button
                        type="submit"
                        form="createFormAvanceSalaire"
                        class="btn btn-success"
                    >
                        حفظ العملية
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
    employeur_id: "",
    montantAvanceSalaire: "",
    montantTotalAvancer: "",
    montantSalaire: "",
    date: formattedDate,
    created_by: 1,
    etat: "noPaye",
    annee: "2024",
    description: "",
});

const props = defineProps({
    employeurs: Object,
});

let createModel = "";

onMounted(() => {
    createModel = $("#createAvanceSalaire");
});

const closeModel = () => {
    createModel.modal("hide");
    form.reset();
};

const soumettre = () => {
    form.post(route("avancesalaire.store"), {
        onSuccess: (page) => {
            // afficher un message de succes
            closeModel();
            useSwalSuccess("L'avance salaireie ajouté avec succés");
            form.reset();
        },
        onError: (errors) => {
            useSwalError("Une erreur s'est produite");
            console.log(errors);
        },
    });
};

const getSalaire = (id) => {
    if (id.target.value != "") {
        axios
            .get(route("employeur.show", { employeur: id.target.value }))
            .then((response) => {
                form.montantSalaire = response.data.employeur.montantSalaire;
            })
            .catch((error) => {
                console.log(error);
            });
        totalAvanceSalaire(id);
    } else {
        form.montantSalaire = 0;
        form.montantTotalAvancer = 0;
    }
};

const totalAvanceSalaire = (id) => {
    axios
        .get(route("salaireavancer", { id: id.target.value }))
        .then((response) => {
            form.montantTotalAvancer = response.data.totalAvancer;
        })
        .catch((error) => {
            console.log(error);
        });
};
</script>
