<template>
  <section dir="rtl" style="text-align: right" class="content-header">
    <div></div>
    <!-- /.container-fluid -->
  </section>
  <div dir="rtl" style="text-align: right" class="content">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card card-info">
                <div class="card-header">
                  <h5 class="text-right"><i class="fas fa-bars"></i> إضافة مصروف جديد</h5>
                </div>
              </div>

              <form action="" @submit.prevent="soumettre" id="createFormDepence">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="InputDate">التاريخ : </label>
                        <input
                          type="date"
                          class="form-control"
                          id="InputDate"
                          v-model="dateDepence"
                        />
                      </div>
                      <!-- /.form-group -->
                    </div>
                  </div>
                  <div class="row">
                    <table class="table table-bordered" id="invoice_details">
                      <thead>
                        <tr>
                          <th>مسح</th>
                          <th>نوع المصروف</th>
                          <th>المستفيد</th>
                          <th>ملاحظات</th>
                          <th>المبلغ</th>
                        </tr>
                      </thead>

                      <tbody id="depence_fields">
                        <tr
                          class="cloning_row"
                          v-for="(item, index) in forms"
                          :key="item"
                          id="0"
                        >
                          <td style="width: 3%">
                            <button
                              type="button"
                              class="btn btn-danger btn-sm delegated-btn"
                              @click="removeRow(index)"
                            >
                              <i class="fa fa-minus"></i>
                            </button>
                          </td>
                          <td style="width: 22%">
                            <select
                              id="InputTypeDepence"
                              class="form-control"
                              style="width: 100%"
                              v-model="item.type_depence_id"
                            >
                              <option value="" selected="selected">إختر...</option>
                              <option
                                v-for="itm in props.typedepences"
                                :value="itm.id"
                                :key="itm.id"
                                :class="{
                                  'is-invalid': forms.messageError,
                                }"
                              >
                                {{ itm.name }}
                              </option>
                            </select>
                          </td>
                          <td style="width: 25%">
                            <select
                              id="InputEmployeur"
                              class="form-control"
                              style="width: 100%"
                              v-model="item.employeur_id"
                            >
                              <option value="" selected="selected">إختر...</option>
                              <option
                                v-for="ite in props.employeurs"
                                :value="ite.id"
                                :key="ite.id"
                              >
                                {{ ite.name }}
                              </option>
                            </select>
                          </td>
                          <td style="width: 25%">
                            <textarea
                              class="form-control"
                              rows="1"
                              placeholder="اكتب ملاحظة هنا ..."
                              v-model="item.description"
                            ></textarea>
                          </td>
                          <td style="width: 25%">
                            <input
                              type="number"
                              class="form-control"
                              id="InputMontant"
                              placeholder="ادخل المبلغ هنا..."
                              v-model="item.montant"
                            />
                          </td>
                        </tr>
                      </tbody>

                      <tfoot>
                        <tr>
                          <td colspan="5">
                            <button
                              type="button"
                              @click="addRow"
                              class="btn btn-primary btn_add"
                            >
                              <i class="fa fa-plus-circle"></i> إضافة مصروف جديد
                            </button>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="3"></td>
                          <th style="text-align: left">المجموع الكامل :</th>
                          <td>
                            <input
                              type="number"
                              step="0.01"
                              name="sub_total"
                              :value="returnTotal()"
                              class="sub_total form-control"
                              readonly
                              id=""
                            />
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div class="card-footer justify-content-start">
                  <button type="submit" form="createFormDepence" class="btn btn-success">
                    حفظ المصاريف
                  </button>
                  <Link :href="route('depence.index')" class="btn btn-secondary mr-3"
                    >إلغاء العملية</Link
                  >
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { useSwalSuccess, useSwalError } from "../../composables/alert";
import { reactive, ref } from "vue";
import { Link, router } from "@inertiajs/vue3";
const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);
const anneeActualle = date.getFullYear();
const dateDepence = ref(formattedDate);

const forms = reactive([
  {
    type_depence_id: "",
    employeur_id: "",
    montant: 0,
    description: "",
    messageError: {},
  },
]);

const addRow = () => {
  forms.push({
    type_depence_id: "",
    employeur_id: "",
    montant: 0,
    description: "",
  });
};

const removeRow = (index) => {
  if (forms.length > 1) {
    forms.splice(index, 1);
  }
};

const props = defineProps({
  typedepences: Object,
  employeurs: Object,
});

const soumettre = () => {
  const date = dateDepence.value;
  const created_by = 1;
  const annee = anneeActualle;
  const formData = forms;
  const url = route("depence.store");
  router.post(
    url,
    { date, created_by, annee, formData },
    {
      onSuccess: (page) => {
        // afficher un message de succes
        useSwalSuccess("لقد تم إضافة المصروف بنجاح !");
      },
      onError: (errors) => {
        // afficher un message d'error
        if (errors.length > 0) {
          forms.messageError = errors;
        }
        console.log(errors);
        useSwalError("يجب عليك ادخال المعلومات");
      },
    }
  );
};

const returnTotal = function () {
  var total = 0;
  forms.forEach((element) => {
    total += element.montant;
  });
  return total;
};
</script>
