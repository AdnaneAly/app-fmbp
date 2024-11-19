<template>
  <div class="index">
    <div class="content-wrapper">
      <!-- Main content -->
      <section dir="rtl" style="text-align: right" class="content">
        <div class="container-fluid">
          <h2 style="padding-top: 3em; padding-bottom: 30px" class="text-center">
            قم بإختيار المجال الزمني :
          </h2>
          <div class="row">
            <div class="col-md-12 offset-md-2">
              <form action="#" @submit.prevent="soumettre" id="searchFormStore">
                <div class="row">
                  <div class="input-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <select
                        class="form-control form-control-lg select2"
                        name="rapport"
                        v-model="form.rapportSearch"
                        style="width: 100%; text-align: right"
                      >
                        <option selected value="All">الوضعية العامة ...</option>
                        <option value="recettes">وضعية المداخيل ...</option>
                        <option value="depences">وضعية المصاريف ...</option>
                      </select>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                </div>
                <br />
                <div class="row">
                  <div class="input-group">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                      <label for="">من :</label>
                      <input
                        type="date"
                        name="debut"
                        v-model="form.debutSearch"
                        class="form-control form-control-lg"
                      />
                    </div>
                    <div class="col-md-4">
                      <label for="">إلى :</label>
                      <input
                        type="date"
                        name="fin"
                        v-model="form.finSearch"
                        class="form-control form-control-lg"
                      />
                    </div>
                    <div class="col-md-2"></div>
                  </div>
                  <div
                    style="justify-content: center; margin-top: 22px"
                    class="input-group"
                  >
                    <button
                      type="submit"
                      form="searchFormStore"
                      class="btn btn-lg btn-primary"
                    >
                      قم بالبحث
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { useSwalError } from "../../composables/alert";

const date = new Date();
const formattedDate = date.toISOString().slice(0, 10);

const form = useForm({
  debutSearch: formattedDate,
  finSearch: formattedDate,
  rapportSearch: "All",
});

const soumettre = () => {
  form.post(route("situation.etat"), {
    onSuccess: (page) => {
      // afficher un message de succes
      form.reset();
    },
    onError: (errors) => {
      useSwalError(errors[0]);
    },
  });
};
</script>
