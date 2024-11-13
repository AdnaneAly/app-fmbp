<template>
    <section dir="rtl" style="text-align: right" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan">
                    <i class="fas fa-bars"></i> قائمة اصحاب المخابز
                </h4>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <div dir="rtl" style="text-align: right" class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-md-1">
                                    <div class="text-right">
                                        <CreateProprietaire />
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>إسم صاحب المخبزة</th>
                                            <th>رقم الهاتف</th>
                                            <th>المكان</th>
                                            <th>عدد المخابز</th>
                                            <th style="width: 100px">
                                                العمليات
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="proprietaire in props
                                                .proprietaires.data"
                                            :key="proprietaire.id"
                                        >
                                            <td>1.</td>
                                            <td>{{ proprietaire.name }}</td>
                                            <td>{{ proprietaire.tel }}</td>
                                            <td>{{ proprietaire.address }}</td>
                                            <td>
                                                {{
                                                    proprietaire.boulangers
                                                        .length
                                                }}
                                            </td>

                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditProprietaire(
                                                            proprietaire.id
                                                        )
                                                    "
                                                    style="margin-left: 10px"
                                                    class="btn btn-info btn-sm"
                                                    href="#"
                                                >
                                                    <i
                                                        class="fas fa-pencil-alt"
                                                    >
                                                    </i>
                                                </button>
                                                <button
                                                    @click="
                                                        deleteConfimation(
                                                            proprietaire.id
                                                        )
                                                    "
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination
                                    :links="props.proprietaires.links"
                                    :prev="props.proprietaires.prev_page_url"
                                    :next="props.proprietaires.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditProprietaire
        :proprietaire_id="editingProprietaireId"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import CreateProprietaire from "./CreateProprietaire.vue";
import EditProprietaire from "./EditProprietaire.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingProprietaireId = ref(0);
const showModal = ref(false);

const props = defineProps({
    proprietaires: Object,
});

const modalClosed = () => {
    editingProprietaireId.value = 0;
    showModal.value = false;
};

const openEditProprietaire = (id) => {
    editingProprietaireId.value = id;
    showModal.value = true;
};

const deleteProprietaire = (id) => {
    const url = route("operationproprietaire.destroy", { proprietaire: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le proprietaire supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer ce proprietaire";
    useSwalConfirm(message, () => {
        deleteProprietaire(id);
    });
};
</script>
