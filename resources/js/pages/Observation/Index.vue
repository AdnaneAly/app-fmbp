<template>
    <section dir="rtl" style="text-align: right" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan">
                    <i class="fas fa-bars"></i> لائحة الملاحظات
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
                                <div class="row">
                                    <div class="col-md-1 ml-2">
                                        <CreateObservation :boulangers="props.boulangers" :employeurs="props.employeurs" />
                                    </div>

                                    <div class="col-md-2 ml-2">
                                        <select @change="search" v-model="boulanger_id" class="form-control">
                                            <option value="" selected>
                                                المخبزة...
                                            </option>
                                            <option v-for="item in props.boulangers" :value="item.id" :key="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <select @change="search" v-model="employeur_id" class="form-control">
                                            <option value="" selected>
                                                العامل...
                                            </option>
                                            <option v-for="item in props.employeurs" :value="item.id" :key="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <input @keyup="search" v-model="searchObservation" type="text"
                                            class="form-control" placeholder="ابحث في الملاحظات " />
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <select @change="search" v-model="per_page" class="form-control">
                                            <option value="">عدد الملاحظات...</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ml-2">
                                        <Link :href="route('observation.print', {
                                            per_page,
                                            boulanger_id,
                                            employeur_id,
                                            searchObservation,
                                        })
                                            " class="btn btn-info"><i class="fa fa-print"></i>
                                        سحب</Link>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 15%">المخبزة</th>
                                            <th style="width: 15%">العامل</th>
                                            <th style="width: 15%">
                                                التاريخ و التوقيت
                                            </th>
                                            <th style="width: 48%">الملاحظة</th>
                                            <th style="width: 12%">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="observation in props
                                            .observations.data" :key="observation.id">
                                            <td>1.</td>
                                            <td>
                                                {{ observation.boulanger.name }}
                                            </td>
                                            <td>
                                                {{ observation.employeur.name }}
                                            </td>
                                            <td>{{ observation.date }}</td>

                                            <th>
                                                {{ observation.message }}
                                            </th>
                                            <td class="d-flex gap-2 text-left">
                                                <Link
                                                    style="margin-left: 10px"
                                                    class="btn btn-primary btn-sm"
                                                    :href="
                                                        route(
                                                            'observation.show',
                                                            {
                                                                observation:
                                                                    observation.id,
                                                            }
                                                        )
                                                    "
                                                >
                                                    <i class="fas fa-folder">
                                                    </i>
                                                </Link>
                                                <button @click="
                                                    openEditObservation(
                                                        observation.id
                                                    )
                                                    " style="margin-left: 10px" class="btn btn-info btn-sm" href="#">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                </button>
                                                <button @click="
                                                    deleteConfimation(
                                                        observation.id
                                                    )
                                                    " class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination :links="props.observations.links" :prev="props.observations.prev_page_url"
                                    :next="props.observations.next_page_url" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditObservation :observation_id="editingObservationId" :boulangers="props.boulangers" :employeurs="props.employeurs" :show="showModal"
        @modal-closed="modalClosed" />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../Shared/Pagination.vue";
import CreateObservation from "./CreateObservation.vue";
import EditObservation from "./EditObservation.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../composables/alert";
import { router } from "@inertiajs/vue3";

const editingObservationId = ref(0);
const showModal = ref(false);
const searchObservation = ref("");
const boulanger_id = ref("");
const employeur_id = ref("");
const per_page = ref("");

const props = defineProps({
    observations: Object,
    boulangers: Object,
    employeurs: Object,
});

const modalClosed = () => {
    editingObservationId.value = 0;
    showModal.value = false;
};

const openEditObservation = (id) => {
    editingObservationId.value = id;
    showModal.value = true;
};

const deleteObservation = (id) => {
    const url = route("observation.destroy", { observation: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("لقد تم مسح الملاحظة بنجاح !");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "هل انت متأكد من مسح الملاحظة!";
    useSwalConfirm(message, () => {
        deleteObservation(id);
    });
};


const search = _.throttle(() => {
    const url = route("observation.index", {
        search: searchObservation.value,
        per_page: per_page.value,
        boulanger_id: boulanger_id.value,
        employeur_id: employeur_id.value,
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
