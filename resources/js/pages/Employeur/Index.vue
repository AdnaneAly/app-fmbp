<template>
    <section dir="rtl" style="text-align: right;" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan" ><i class="fas fa-bars"></i> لائحة العمال</h4>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div dir="rtl" style="text-align: right;" class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-1 ml-2">
                                        <CreateEmployeur
                                        :grades="props.grades"
                                        :boulangers="props.boulangers"
                                    />
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <input
                                        @keyup="search"
                                        v-model="searchEmployeur"
                                        type="text"
                                        class="form-control"
                                        placeholder="ابحث عن اسم العامل"
                                    />
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <select
                                        @change="search"
                                        v-model="grade_id"
                                        class="form-control"
                                    >
                                    <option value="" selected>الرتب...</option>
                                    <option v-for="item in props.grades" :value="item.id" :key="item.id" >{{ item.name }}</option>

                                    </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <select
                                        @change="search"
                                        v-model="per_page"
                                        class="form-control"
                                    >
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <Link
                                            :href="
                                                route('employeur.print', {
                                                    per_page,
                                                    grade_id,
                                                    searchEmployeur,
                                                })
                                            "
                                            class="btn btn-info"
                                            ><i class="fa fa-print"></i>
                                            سحب</Link
                                        >
                                    </div>


                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">#</th>
                                            <th>الإسم الكامل</th>
                                            <th>رقم الهاتف</th>
                                            <th>الرتبة</th>
                                            <th>تاريخ الاكتتاب</th>
                                            <th>الحالة</th>
                                            <th>المرتب</th>
                                            <th style="width: 100px">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="employeur in props.employeurs
                                                .data" :key="employeur.id"
                                        >
                                            <td>1.</td>
                                            <td>{{ employeur.name }}</td>
                                            <td>{{ employeur.tel }}</td>
                                            <td>{{ employeur.grade.name }}</td>
                                            <td>{{ employeur.date }}</td>
                                            <td>
                                                <span class="badge" :class="employeur.etat === 'active' ? 'bg-success' : 'bg-danger'">{{
                                                    employeur.etat
                                                }}</span>
                                            </td>
                                            <th>
                                                {{ employeur.montantSalaire.toLocaleString() }}
                                            </th>
                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditEmployeur(
                                                            employeur.id
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
                                                            employeur.id
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
                                    :links="props.employeurs.links"
                                    :prev="props.employeurs.prev_page_url"
                                    :next="props.employeurs.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditEmployeur
        :employeur_id="editingEmployeurId"
        :grades="props.grades"
        :show="showModal"
        @modal-closed="modalClosed"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import CreateEmployeur from "./CreateEmployeur.vue";
import EditEmployeur from "./EditEmployeur.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingEmployeurId = ref(0);
const showModal = ref(false);
const searchEmployeur = ref("");
const grade_id = ref("");
const per_page = ref(5);

const props = defineProps({
    employeurs: Object,
    grades: Object,
});

const modalClosed = () => {
    editingEmployeurId.value = 0;
    showModal.value = false;
};

const openEditEmployeur = (id) => {
    editingEmployeurId.value = id;
    showModal.value = true;
};

const deleteEmployeur = (id) => {
    const url = route("employeur.destroy", { employeur: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le employeur supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cet employeur";
    useSwalConfirm(message, () => {
        deleteEmployeur(id);
    });
};

const search = _.throttle(() => {
    const url = route("employeur.index", {
        search: searchEmployeur.value,
        per_page: per_page.value,
        grade_id: grade_id.value,
    });
    router.get(
        url,
        {},
        {
            replace: true,
            preserveState: true,
        }
    );
}, 500);
</script>
