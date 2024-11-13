<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createProprietaire"
    >
        <i class="fa fa-plus"></i> إضافة
    </button>

    <div
        class="modal fade"
        id="createProprietaire"
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
                    <h4 class="modal-title">إضافة صاحب مخبزة جديد</h4>
                </div>
                <div class="modal-body">
                    <form action="" @submit.prevent="soumettre" id="createFormProprietaire">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputName">الإسم :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="ادخل إسم صاحب المخبزة هنا..."
                                        v-model="nameProprietaire"
                                        :class="{'is-invalid': nameError != ''}"
                                    />
                                    <span v-if="nameError != ''" class="error invalid-feedback">{{ nameError }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="InputTel">رقم الهاتف :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputTel"
                                        placeholder="ادخل رقم الهاتف هنا..."
                                        v-model="telProprietaire"
                                        :class="{'is-invalid': telError != ''}"
                                    />
                                    <span v-if="telError != ''" class="error invalid-feedback">{{ telError }}</span>
                                </div>

                                <!-- /.form-group -->
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="InputAddress">المكان :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputAddress"
                                        placeholder="ادخل المكان هنا..."
                                        v-model="addressProprietaire"
                                        :class="{'is-invalid': addressError != ''}"
                                    />
                                    <span v-if="addressError != ''" class="error invalid-feedback">{{ addressError }}</span>
                                </div>
                                <div class="form-group">
                                    <label>ملاحظات :</label>
                                    <textarea
                                        class="form-control"
                                        rows="1"
                                        placeholder="اكتب ملاحظة هنا ..."
                                        v-model="descriptionProprietaire"
                                    ></textarea>
                                </div>


                                <!-- /.form-group -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" form="createFormProprietaire" class="btn btn-success">
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
import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useSwalSuccess, useSwalError } from '../../../composables/alert';

const nameError = ref("");
const telError = ref("");
const addressError = ref("");

const nameProprietaire = ref("");
const telProprietaire = ref("");
const addressProprietaire = ref("");
const descriptionProprietaire = ref("");

let createModel = "";

onMounted(() => {
    createModel = $("#createProprietaire");
})

const closeModel = () => {
    createModel.modal("hide");
    nameProprietaire.value = "";
};

const soumettre = () => {
    const name = nameProprietaire.value
    const tel = telProprietaire.value
    const address = addressProprietaire.value
    const description = descriptionProprietaire.value
    const url = route("operationproprietaire.store")
    router.post(
                url,
                {name, tel, address, description},
                {
                    onSuccess: (page) => {
                        closeModel();
                        // afficher un message de succes
                        useSwalSuccess("لقد تم إضافة صاحب المخبزة بنجاح !");
                    },
                    onError: (errors) => {
                        // afficher un message d'error
                        if ( errors.name != null ) {
                            nameError.value = errors.name;
                        }
                        useSwalError("Une erreur s'est produite")
                    }
                }
            )
}
</script>
