<template>
    <div
        class="modal fade"
        id="EditProprietaire"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        Editer une proprietaire {{ editProprietaire.name }}
                    </h4>
                    <button
                        type="button"
                        class="close"
                        @click="closeModal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
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
                                    <label for="InputName">Nom</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="Enter nom"
                                        v-model="editProprietaire.name"
                                        :class="{
                                            'is-invalid':
                                                editProprietaire.messageError.hasOwnProperty('name'),
                                        }"
                                    />
                                    <span
                                        v-if="editProprietaire.messageError.hasOwnProperty('name')"
                                        class="error invalid-feedback"
                                        >{{ editProprietaire.messageError.name }}</span
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="InputTel">Telephone</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputTel"
                                        placeholder="Enter telephone"
                                        v-model="editProprietaire.tel"
                                        :class="{
                                            'is-invalid':
                                                editProprietaire.messageError.hasOwnProperty('tel'),
                                        }"
                                    />
                                    <span
                                        v-if="editProprietaire.messageError.hasOwnProperty('tel')"
                                        class="error invalid-feedback"
                                        >{{ editProprietaire.messageError.tel }}</span
                                    >
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputAddress">Adresse</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputAddress"
                                        placeholder="Enter adresse"
                                        v-model="editProprietaire.address"
                                        :class="{
                                            'is-invalid':
                                                editProprietaire.messageError.hasOwnProperty('Address'),
                                        }"
                                    />
                                    <span
                                        v-if="editProprietaire.messageError.hasOwnProperty('Address')"
                                        class="error invalid-feedback"
                                        >{{ editProprietaire.messageError.Address }}</span
                                    >
                                </div>
                                <!-- textarea -->
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        placeholder="Enter ..."
                                        v-model="editProprietaire.description"
                                    ></textarea>

                                </div>
                                <!-- /.form-group -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="closeModal"
                    >
                        Fermer
                    </button>
                    <button
                        form="editForm"
                        type="submit"
                        class="btn btn-success"
                    >
                        Soumettre
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
    proprietaire_id: {
        type: Number,
        required: true,
    },
    show: {
        type: Boolean,
        default: false,
    },
});

const editProprietaire = reactive({
    id: "",
    name: "",
    tel: "",
    address: "",
    description: "",
    messageError: {},
});

const openModal = () => {
    getProprietaireById();
    $("#EditProprietaire").modal("show");
};

const closeModal = () => {
    $("#EditProprietaire").modal("hide");
    emit("modalClosed");
};

const soumettre = () => {
    const url = route("operationproprietaire.update", { proprietaire: props.proprietaire_id });
    router.put(
        url,
        {
            name: editProprietaire.name,
            tel: editProprietaire.tel,
            address: editProprietaire.address,
            description: editProprietaire.description,
        },
        {
            onSuccess: (page) => {
                closeModal();
                // afficher un message de succes
                useSwalSuccess("Le proprietaire edtité avec succés");
            },
            onError: (errors) => {
                // afficher un message d'error
                if (errors.length != 0) {
                    editProprietaire.messageError = errors;
                }
                useSwalError("Une erreur s'est produite");
            },
        }
    );
};

const getProprietaireById = () => {
    axios
        .get(route("operationproprietaire.edit", { proprietaire: props.proprietaire_id }))
        .then((response) => {
            editProprietaire.id = response.data.proprietaire.id;
            editProprietaire.name = response.data.proprietaire.name;
            editProprietaire.tel = response.data.proprietaire.tel;
            editProprietaire.address = response.data.proprietaire.address;
            editProprietaire.description = response.data.proprietaire.description;
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
