<template>
    <button
        type="button"
        class="btn btn-block btn-primary"
        data-toggle="modal"
        data-target="#createTypeDepence"
    >
        <i class="fa fa-plus"></i> إضافة
    </button>

    <div
        class="modal fade"
        id="createTypeDepence"
        style="display: none"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header ">

                    <button
                        type="button"
                        @click="closeModel"
                        class="close"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">إضافة نوع مصروف جديد :</h4>
                </div>
                <div class="modal-body">
                    <form action="" @submit.prevent="soumettre" id="createFormTypeDepence">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="InputName">إسم المصروف :</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="InputName"
                                        placeholder="ادخل اسم المصروف هنا ..."
                                        v-model="nameTypeDepence"
                                        :class="{'is-invalid': nameError != ''}"
                                    />
                                    <span v-if="nameError != ''" class="error invalid-feedback">{{ nameError }}</span>
                                </div>


                                <!-- /.form-group -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" form="createFormTypeDepence" class="btn btn-success">
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

const nameTypeDepence = ref("");

let createModel = "";

onMounted(() => {
    createModel = $("#createTypeDepence");
})

const closeModel = () => {
    createModel.modal("hide");
    nameTypeDepence.value = "";
};

const soumettre = () => {
    const name = nameTypeDepence.value
    const url = route("operationtypedepence.store")
    router.post(
                url,
                {name},
                {
                    onSuccess: (page) => {
                        closeModel();
                        // afficher un message de succes
                        useSwalSuccess("Le TypeDepence ajouté avec succés")
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
