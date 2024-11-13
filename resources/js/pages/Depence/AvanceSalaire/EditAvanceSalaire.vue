<template>
    <div
        dir="rtl"
        class="modal fade"
        id="EditAvanceSalaire"
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
                        تعديل مقدم راتب
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

                                        placeholder="Enter montantAvanceSalaire"
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
                                        @change="getSalaires($event)"
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
                                        >الراتب :</label
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
                                    <label>ملاحظات</label>
                                    <textarea
                                        class="form-control"
                                        rows="1"
                                        placeholder="Enter ..."
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
                                        >مجموع ما تم تقديمه :</label
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
                                        >{{ form.errors.montantTotalAvancer }}</span
                                    >
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="closeModal"
                    >
                        إلغاء
                    </button>
                    <button
                        form="editForm"
                        type="submit"
                        class="btn btn-success"
                    >
                        حفظ التعديل
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script setup>
import { watch } from "vue";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(["modalClosed"]);

const props = defineProps({
    avancesalaire_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
    employeurs: Object
});

const form = useForm({
    employeur_id: 0,
    montantAvanceSalaire: 0,
    montantTotalAvancer: 0,
    montantSalaire: 0,
    date: null,
    created_by: 1,
    etat: "",
    annee: "2024",
    description: "",
});




const openModal = () => {
    getAvanceSalaireById();
    $("#EditAvanceSalaire").modal("show");
};

const closeModal = () => {
    $("#EditAvanceSalaire").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    form.put(route("avancesalaire.update", {avancesalaire: props.avancesalaire_id}), {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le store mise a jour avec succés");
            closeModal()
        },
        onError: (errors) => {
            console.log(errors);
            useSwalError(errors[0]);
        },
    });
};


const getAvanceSalaireById = () => {
    axios
        .get(route("avancesalaire.edit", { avancesalaire: props.avancesalaire_id }))
        .then((response) => {
            form.employeur_id = response.data.avanceSalaire.employeur_id
            form.montantAvanceSalaire = response.data.avanceSalaire.montantAvanceSalaire
            form.date = response.data.avanceSalaire.date
            form.annee = response.data.avanceSalaire.annee
            form.description = response.data.avanceSalaire.description
            form.etat = response.data.avanceSalaire.etat
            form.created_by = response.data.avanceSalaire.created_by
            getSalaire(response.data.avanceSalaire.employeur_id);
        })
        .catch((error) => {
            console.log(error);
        });
};



const getSalaire = (id) => {
    axios
        .get(route("employeur.show", { employeur: id }))
        .then((response) => {
            form.montantSalaire = response.data.employeur.montantSalaire;
        })
        .catch((error) => {
            console.log(error);
        });
};

const getSalaires = (id) => {
    if(id.target.value != "") {
        axios
        .get(route("employeur.show", { employeur: id.target.value }))
        .then((response) => {
            form.montantSalaire = response.data.employeur.montantSalaire;
        })
        .catch((error) => {
            console.log(error);
        });
    }else {
        form.montantSalaire = 0;
        form.montantTotalAvancer = 0;
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
