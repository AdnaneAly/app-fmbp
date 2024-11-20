<template>
  <section dir="rtl" style="text-align: right" class="content-header">
    <div class="card card-cyan card-outline mx-2">
      <div class="card-header">
        <h4 class="text-cyan"><i class="fas fa-bars"></i>معلومات عامة</h4>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section dir="rtl" style="text-align: center" class="content">
    <div class="container-fluid">
      <!-- AREA CHART -->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-cyan card-outline">
            <div class="card-header">
              <h3 class="card-title">Statistiques Recettes depences</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas
                  id="areaChart"
                  style="
                    min-height: 250px;
                    height: 250px;
                    max-height: 250px;
                    max-width: 100%;
                  "
                ></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </section>
  <section class="content" dir="rtl" style="text-align: right">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-2 col-4">
          <!-- small box -->
          <div class="small-box bg-lightblue">
            <div class="inner">
              <h3>{{ props.data.countBoulanger }}</h3>

              <p>مجموع المخابز</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <Link
              :href="route('boulanger.index', { per_page: '100' })"
              class="small-box-footer"
              >مزيد من المعلومات <i class="fas fa-arrow-circle-left"></i
            ></Link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-4">
          <!-- small box -->
          <div class="small-box bg-gradient-success">
            <div class="inner">
              <h3>{{ props.data.impotPaye }}<sup style="font-size: 20px"></sup></h3>

              <p>عدد ما دفع من الجباية</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <Link
              :href="route('recette.index', { etatImpot: 'PAYE' })"
              class="small-box-footer"
              >مزيد من المعلومات <i class="fas fa-arrow-circle-left"></i
            ></Link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-4">
          <!-- small box -->
          <div class="small-box bg-gradient-warning">
            <div class="inner">
              <h3>{{ props.data.impotSemiPaye }}</h3>

              <p>عدد التسوية</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <Link
              :href="route('recette.index', { etatImpot: 'SEMIPAYE' })"
              class="small-box-footer"
              >مزيد من المعلومات <i class="fas fa-arrow-circle-left"></i
            ></Link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-4">
          <!-- small box -->
          <div class="small-box bg-gradient-danger">
            <div class="inner">
              <h3>{{ props.data.impotNoPaye }}</h3>

              <p>عدد ما لم يدفع</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <Link
              :href="route('recette.index', { etatImpot: 'NONPAYE' })"
              class="small-box-footer"
              >مزيد من المعلومات <i class="fas fa-arrow-circle-left"></i
            ></Link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-4">
          <!-- small box -->
          <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{ props.data.impotFermer }}</h3>

              <p>عدد أشهر الإغلاق</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <Link
              :href="route('recette.index', { etatImpot: 'FERMER' })"
              class="small-box-footer"
              >مزيد من المعلومات <i class="fas fa-arrow-circle-left"></i
            ></Link>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-4">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ props.data.impotExonerer }}</h3>

              <p>عدد أشهر الاعفاءات</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <Link
              :href="route('recette.index', { etatImpot: 'EXONERER' })"
              class="small-box-footer"
              >مزيد من المعلومات <i class="fas fa-arrow-circle-left"></i
            ></Link>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div>
  </section>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  data: Object,
  recettes: Array,
  depences: Array,
});

$(function () {
  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //--------------
  //- AREA CHART -
  //--------------

  // Get context with jQuery - using jQuery's .get() method.
  var areaChartCanvas = $("#areaChart").get(0).getContext("2d");

  var areaChartData = {
    labels: [
      "Janv",
      "Févr",
      "Mars",
      "Avr",
      "Mai",
      "Juin",
      "Juil",
      "Août",
      "Sept",
      "Oct",
      "Nov",
      "Déc",
    ],
    datasets: [
      {
        label: "Depences",
        backgroundColor: "rgba(60,141,188,0.9)",
        borderColor: "rgba(60,141,188,0.8)",
        pointRadius: false,
        pointColor: "#12384e",
        pointStrokeColor: "rgba(60,141,188,1)",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(60,141,188,1)",
        data: props.recettes,
      },
      {
        label: "Recettes",
        backgroundColor: "rgba(210, 214, 222, 1)",
        borderColor: "rgba(210, 214, 222, 1)",
        pointRadius: false,
        pointColor: "rgba(210, 214, 222, 1)",
        pointStrokeColor: "#c1c7d1",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(220,220,220,1)",
        data: props.depences,
      },
    ],
  };

  var areaChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: true,
    },
    scales: {
      xAxes: [
        {
          gridLines: {
            display: true,
          },
        },
      ],
      yAxes: [
        {
          gridLines: {
            display: true,
          },
        },
      ],
    },
  };

  // This will get the first returned node in the jQuery collection.
  new Chart(areaChartCanvas, {
    type: "line",
    data: areaChartData,
    options: areaChartOptions,
  });
});
</script>
