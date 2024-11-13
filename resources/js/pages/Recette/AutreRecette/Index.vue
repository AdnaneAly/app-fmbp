<template>
    <section dir="rtl" style="text-align: right;" class="content-header">
        <div class="card card-cyan card-outline mx-2">
            <div class="card-header">
                <h4 class="text-cyan" ><i class="fas fa-bars"></i> قائمة المداخيل الاخرى</h4>
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
                                    <div class="col-md-1 ">
                                        <CreateAutreRecette
                                            :typerecettes="props.typerecettes"
                                        />
                                        </div>
                                    <div class="col-md-2 ">
                                            <select
                                                @change="search"
                                                v-model="type_recette_id"
                                                class="form-control"
                                            >
                                                <option value="" selected>
                                                    انواع المداخيل...
                                                </option>
                                                <option
                                                    v-for="item in props.typerecettes"
                                                    :value="item.id"
                                                    :key="item.id"
                                                >
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <select
                                            @change="search"
                                            v-model="month"
                                            class="form-control"
                                        >
                                            <option value="" selected>
                                                شهر الدخل...
                                            </option>
                                            <option value="1">يناير</option>
                                            <option value="2">قبراير</option>
                                            <option value="3">مارس</option>
                                            <option value="4">ابريل</option>
                                            <option value="5">مايو</option>
                                            <option value="6">يونيو</option>
                                            <option value="7">يوليو</option>
                                            <option value="8">اغصطس</option>
                                            <option value="9">سبتمبر</option>
                                            <option value="10">اكتوبر</option>
                                            <option value="11">نوفمبر</option>
                                            <option value="12">
                                                دجمبر
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 ">
                                        <input
                                            @keyup="search"
                                            v-model="numeroFacture"
                                            type="number"
                                            class="form-control"
                                            placeholder="ادخل رقم الوصل هنا..."
                                        />
                                    </div>

                                    <div class="col-md-1 ">
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
                                    <div class="col-md-2 ">
                                        <Link
                                            :href="
                                                route('autrerecette.print', {
                                                    per_page,
                                                    type_recette_id,
                                                    numeroFacture,
                                                    month
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
                                            <th>نوع الدخل </th>
                                            <th>ملاحظة </th>
                                            <th>رقم الوصل</th>
                                            <th>التاريخ</th>
                                            <th>المبلغ</th>
                                            <th style="width: 100px">العمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="(autrerecette, index) in props
                                                .autrerecettes.data"
                                            :key="autrerecette.id"
                                        >
                                            <td>{{ index + 1 }}.</td>
                                            <td>
                                                {{ autrerecette.typerecette.name }}
                                            </td>
                                            <td>{{ autrerecette.description }}</td>
                                            <td>{{ autrerecette.numeroFacture }}</td>
                                            <td>{{ autrerecette.date }}</td>
                                            <th dir="ltr">
                                                {{
                                                    autrerecette.montant.toLocaleString()
                                                }}
                                                UM
                                            </th>
                                            <td class="d-flex gap-2 text-left">
                                                <button
                                                    @click="
                                                        openEditAutreRecette(
                                                            autrerecette.id
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
                                                            autrerecette.id
                                                        )
                                                    "
                                                    class="btn btn-danger btn-sm"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">المجموع :</th>
                                            <th dir="ltr">
                                                {{
                                                    returnTotal().toLocaleString()
                                                }}
                                                UM
                                            </th>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="card-footer clearfix">
                                <Pagination
                                    :links="props.autrerecettes.links"
                                    :prev="props.autrerecettes.prev_page_url"
                                    :next="props.autrerecettes.next_page_url"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <EditAutreRecette
        :autrerecette_id="editingAutreRecetteId"
        :show="showModal"
        @modal-closed="modalClosed"
        :typerecettes="typerecettes"
    />
</template>

<script setup>
import { ref } from "vue";
import Pagination from "../../../Shared/Pagination.vue";
import EditAutreRecette from "./EditAutreRecette.vue";
import {
    useSwalConfirm,
    useSwalError,
    useSwalSuccess,
} from "../../../composables/alert";
import { router } from "@inertiajs/vue3";
import CreateAutreRecette from "./CreateAutreRecette.vue";

const editingAutreRecetteId = ref(0);
const showModal = ref(false);
const numeroFacture = ref("");
const type_recette_id = ref("");
const month = ref("");
const per_page = ref(5);

const props = defineProps({
    autrerecettes: Object,
    typerecettes: Object,
});

const modalClosed = () => {
    editingAutreRecetteId.value = 0;
    showModal.value = false;
};

const openEditAutreRecette = (id) => {
    editingAutreRecetteId.value = id;
    showModal.value = true;
};

const deleteAutreRecette = (id) => {
    const url = route("autrerecette.destroy", { autrerecette: id });
    router.delete(url, {
        onSuccess: (page) => {
            // afficher un message de succes
            useSwalSuccess("Le autrerecetteie supprime avec succés");
        },
        onError: (errors) => {
            // afficher un message d'error
            useSwalError("Une erreur s'est produite");
        },
    });
};

const deleteConfimation = (id) => {
    const message = "Etes vous sur de supprimer cette autrerecetteie";
    useSwalConfirm(message, () => {
        deleteAutreRecette(id);
    });
};

const returnTotal = function () {
    var total = 0;
    props.autrerecettes.data.forEach((element) => {
        total += element.montant;
    });
    return total;
};

const search = _.throttle(() => {
    const url = route("autrerecette.index", {
        numeroFacture: numeroFacture.value,
        per_page: per_page.value,
        type_recette_id: type_recette_id.value,
        month: month.value,
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
