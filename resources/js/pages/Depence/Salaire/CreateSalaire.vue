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
                  <h5 class="text-right">إضافة راتب جديد :</h5>
                </div>
              </div>

              <form action="" @submit.prevent="soumettre" id="createFormStore">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
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
                        <span v-if="form.errors.date" class="error invalid-feedback">{{
                          form.errors.date
                        }}</span>
                      </div>

                      <div class="form-group">
                        <label for="InputnombreJoursTravail">عدد ايام العمل :</label>
                        <input
                          type="number"
                          class="form-control"
                          id="InputnombreJoursTravail"
                          @input="montantJoursTravailCalcul($event)"
                          placeholder="ادخل العدد هنا..."
                          v-model="form.nombreJoursTravail"
                          :class="{
                            'is-invalid': form.errors.nombreJoursTravail,
                          }"
                        />
                        <span
                          v-if="form.errors.nombreJoursTravail"
                          class="error invalid-feedback"
                          >{{ form.errors.nombreJoursTravail }}</span
                        >
                      </div>

                      <!-- /.form-group -->
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="InputEmployeur">العامل المستفيد :</label>
                        <select
                          id="InputEmployeur"
                          class="form-control"
                          style="width: 100%"
                          v-model="form.employeur_id"
                          :class="{
                            'is-invalid': form.errors.employeur_id,
                          }"
                          @change="getSalaire($event)"
                        >
                          <option value="" selected="selected">إختر...</option>
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
                        <label for="InputMontantJoursTravail"
                          >المبلغ مقابل عدد ايام العمل :</label
                        >
                        <input
                          type="number"
                          class="form-control"
                          id="InputMontantJoursTravail"
                          :disabled="true"
                          v-model="form.montantJoursTravail"
                          :class="{
                            'is-invalid': form.errors.montantJoursTravail,
                          }"
                        />
                        <span
                          v-if="form.errors.montantJoursTravail"
                          class="error invalid-feedback"
                          >{{ form.errors.montantJoursTravail }}</span
                        >
                      </div>
                      <div class="form-group">
                        <label for="InputMontantAvance">المبلغ المقدم :</label>
                        <input
                          type="number"
                          class="form-control"
                          id="InputMontantAvance"
                          :disabled="true"
                          v-model="form.montantAS"
                          :class="{
                            'is-invalid': form.errors.montantAS,
                          }"
                        />
                        <span
                          v-if="form.errors.montantAS"
                          class="error invalid-feedback"
                          >{{ form.errors.montantAS }}</span
                        >
                      </div>

                      <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>ملاحظات :</label>
                        <textarea
                          class="form-control"
                          rows="1"
                          placeholder="اكتب ملاحظة هنا ..."
                          v-model="form.description"
                        ></textarea>
                      </div>
                      <div class="form-group">
                        <label for="InputSalaireNet"> الراتب الصافي :</label>
                        <input
                          type="number"
                          class="form-control"
                          id="InputSalaireNet"
                          :disabled="true"
                          v-model="form.salaireNet"
                          :class="{
                            'is-invalid': form.errors.salaireNet,
                          }"
                        />
                        <span
                          v-if="form.errors.salaireNet"
                          class="error invalid-feedback"
                          >{{ form.errors.salaireNet }}</span
                        >
                      </div>
                      <div class="form-group">
                        <label for="InputMontantNet">المبلغ بعد الاقتطاع :</label>
                        <input
                          type="number"
                          class="form-control"
                          id="InputMontantNet"
                          :disabled="true"
                          v-model="form.montantNet"
                          :class="{
                            'is-invalid': form.errors.montantNet,
                          }"
                        />
                        <span
                          v-if="form.errors.montantNet"
                          class="error invalid-feedback"
                          >{{ form.errors.montantNet }}</span
                        >
                      </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                  </div>
                </div>
                <div class="card-footer justify-content-start">
                  <button type="submit" form="createFormStore" class="btn btn-success">
                    حفظ العملية
                  </button>
                  <Link :href="route('salaire.index')" class="btn btn-secondary mr-3"
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
import { Link, useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";

const date = new Date();
const anneeActualle = date.getFullYear();
const formattedDate = date.toISOString().slice(0, 10);

const form = useForm({
  employeur_id: "",
  created_by: 1,
  nombreJoursTravail: 0,
  montantJoursTravail: 0,
  salaireNet: 0,
  montantNet: 0,
  montantAS: "",
  date: formattedDate,
  annee: anneeActualle,
  description: "",
});

const props = defineProps({
  employeurs: Object,
});

const soumettre = () => {
  form.post(route("salaire.store"), {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("لقد تم إضافة راتب بنجاح !");
      form.reset();
    },
    onError: (errors) => {
      useSwalError("Une erreur s'est produite");
    },
  });
};

const getSalaire = (id) => {
  axios
    .get(route("employeur.show", { employeur: id.target.value }))
    .then((response) => {
      form.salaireNet = response.data.employeur.montantSalaire;
    })
    .catch((error) => {
      console.log(error);
    });
  totalAvanceSalaire(id);
};

const totalAvanceSalaire = (id) => {
  axios
    .get(route("salaireavancer", { id: id.target.value }))
    .then((response) => {
      form.montantAS = response.data.totalAvancer;
    })
    .catch((error) => {
      console.log(error);
    });
};

const montantJoursTravailCalcul = (event) => {
  let nbrJourTravail = parseFloat(event.target.value) || 0;
  let montantJT = Math.round((form.salaireNet / 30) * nbrJourTravail, 2) || 0;
  form.montantJoursTravail = montantJT || 0;
  form.montantNet = montantJT - parseFloat(form.montantAS) || 0;
};
</script>
