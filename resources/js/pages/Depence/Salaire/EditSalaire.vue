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
                  <h3 class="text-right">تعديل معلومات الراتب :</h3>
                </div>
              </div>

              <form action="" @submit.prevent="soumettre" id="editFormSalaire">
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
                      <!-- /.form-group -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
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
                        <label>ملاحظات : </label>
                        <textarea
                          class="form-control"
                          rows="1"
                          placeholder="اكتب ملاحظة هنا ..."
                          v-model="form.description"
                        ></textarea>
                      </div>
                    </div>
                    <!-- /.col -->

                    <!-- /.col -->
                  </div>
                </div>
                <div class="card-footer justify-content-start">
                  <button type="submit" form="editFormSalaire" class="btn btn-success">
                    حفظ التعديل
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
import { useForm } from "@inertiajs/vue3";
import { useSwalSuccess, useSwalError } from "../../../composables/alert";
import { onMounted } from "vue";

const props = defineProps({
  salaire: {
    type: Object,
    required: true,
  },
  employeurs: Object,
});

const form = useForm({
  employeur_id: props.salaire.employeur_id,
  created_by: props.salaire.created_by,
  nombreJoursTravail: props.salaire.nombreJoursTravail,
  montantJoursTravail: props.salaire.montantJoursTravail,
  salaireNet: 0,
  montantNet: props.salaire.montantNet,
  montantAS: props.salaire.montantAS,
  date: props.salaire.date,
  annee: props.salaire.annee,
  description: props.salaire.description,
});

const soumettre = () => {
  form.put(route("salaire.update", { salaire: props.salaire.id }), {
    onSuccess: (page) => {
      // afficher un message de succes
      useSwalSuccess("لقد تم تعديل راتب بنجاح !");
    },
    onError: (errors) => {
      useSwalError("Une erreur s'est produite");
    },
  });
};

const getSalaire = (id) => {
  axios
    .get(route("employeur.show", { employeur: id }))
    .then((response) => {
      form.salaireNet = response.data.employeur.montantSalaire;
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

onMounted(() => {
  getSalaire(props.salaire.employeur_id);
});
</script>
