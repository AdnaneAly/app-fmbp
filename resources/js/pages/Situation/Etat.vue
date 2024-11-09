<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <!-- Info boxes -->
                <!-- Small boxes (Stat box) -->

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="position-relative">
                                        <img
                                            src="~admin-lte/dist/img/cover-01.png"
                                            alt="Photo 1"
                                            class="img-fluid"
                                        />
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div style="margin-top: 1em" dir="rtl" class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-8">
                                    <table class="table table-sm no-border">
                                        <tr>
                                            <td
                                                style="
                                                    text-align: center;
                                                    font-size: x-large;
                                                "
                                                colspan="2"
                                            >
                                                <strong> الوضعية العامة</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="
                                                    text-align: left;
                                                    font-size: x-large;
                                                "
                                            >
                                                من : {{ props.data.dates['debutSearch'] }}
                                            </td>
                                            <td
                                                style="
                                                    text-align: right;
                                                    font-size: x-large;
                                                "
                                            >
                                                <i class="fa fa-arrow-left"></i>
                                                إلى : {{ props.data.dates['finSearch'] }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                style="
                                                    text-align: center;
                                                    font-size: x-large;
                                                "
                                            >
                                                عدد المخابز :
                                                <strong> 5 </strong>
                                            </td>
                                            <td
                                                style="
                                                    text-align: center;
                                                    font-size: x-large;
                                                "
                                            >
                                                عدد عمال الإدارة :
                                                <strong> 4 </strong>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-2"></div>
                            </div>
                            <!-- /.row -->

                            <div
                                dir="rtl"
                                style="text-align: right"
                                class="row"
                            >
                                <div class="col-12">
                                    <strong>مجموع المداخيل :</strong>

                                    <div style="margin-top: 20px" class="table">
                                        <table
                                            class="table table-sm table-bordered table-hover"
                                        >
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>وضعية المخابز</th>
                                                    <th>عدد الاشهر</th>
                                                    <th>المبلغ المدفوع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(montant, etat) in props.data.dupMontantRecette" :key="etat"  style="padding: 0">
                                                    <th style="width: 5%">{{ 1 }}</th>
                                                    <th dir="ltr" style="width: 65%">{{ etat }}</th>
                                                    <th
                                                        dir="ltr"
                                                        style="width: 10%"
                                                    >{{ props.data.dupRecette[etat] }}</th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >{{ montant.toLocaleString() }}</td>
                                                </tr>

                                                <tr v-for="(montant, etat) in props.data.dupAutreRecette" :key="etat" style="padding: 0">
                                                    <th style="width: 5%"></th>
                                                    <th style="width: 65%">{{ etat }}</th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 10%"
                                                    ></td>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >{{ montant }}
                                                        UM
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">
                                                        المجموع الكامل :
                                                    </th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                        {{ returnTotalRecette().toLocaleString() }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div
                                dir="rtl"
                                style="text-align: right"
                                class="row"
                            >
                                <div class="col-12">
                                    <strong>مجموع المصاريف :</strong>

                                    <div style="margin-top: 20px" class="table">
                                        <table
                                            class="table table-sm table-bordered table-hover"
                                        >
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>نوع المصروف</th>
                                                    <th>العدد</th>
                                                    <th>المبلغ المصروف</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(name, i) in props.data.typeDepences" :key="i">
                                                    <th style="width: 5%">{{ i }}</th>
                                                    <th style="width: 65%">{{ name }}</th>
                                                    <th
                                                        dir="ltr"
                                                        style="width: 10%"
                                                    >{{ props.data.dupDepence[i] }}</th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                    {{ props.data.dupMontantDepence[i].toLocaleString() }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style="width: 5%"></th>
                                                    <th style="width: 65%">
                                                        مجموع مصاريف الرواتب
                                                    </th>
                                                    <th
                                                        dir="ltr"
                                                        style="width: 10%"
                                                    >{{ props.data.dupDepenceSalaire }}</th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                    {{ props.data.dupMontantDepenceSalaire.toLocaleString() }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th style="width: 5%"></th>
                                                    <th style="width: 65%">
                                                        مجموع مصاريف المقدمات
                                                    </th>
                                                    <th
                                                        dir="ltr"
                                                        style="width: 10%"
                                                    >{{ props.data.dupAvanceSalaire }}</th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                    {{ props.data.dupMontantAvanceSalaire.toLocaleString() }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">
                                                        المجموع الكامل :
                                                    </th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                        {{ returnTotalDepence().toLocaleString() }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div
                                dir="rtl"
                                style="text-align: right"
                                class="row"
                            >
                                <div class="col-12">
                                    <strong> الوضعية الحالية :</strong>

                                    <div style="margin-top: 20px" class="table">
                                        <table
                                            class="table table-sm table-bordered table-hover"
                                        >
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>الحالة</th>
                                                    <th>المجموع</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th style="width: 5%">1</th>
                                                    <th style="width: 75%">
                                                        مجموع المداخيل
                                                    </th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                    {{ returnTotalRecette().toLocaleString() }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 5%">2</th>
                                                    <th style="width: 75%">
                                                        مجموع المصاريف
                                                    </th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                        {{ returnTotalDepence().toLocaleString() }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">
                                                        المجموع المتبقي :
                                                    </th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    >
                                                        {{ (returnTotalRecette() - returnTotalDepence()).toLocaleString() }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <div
                                dir="rtl"
                                style="text-align: right"
                                class="row"
                            >
                                <div class="col-12">
                                    <strong> معلومات إضافية :</strong>

                                    <div style="margin-top: 20px" class="table">
                                        <table
                                            class="table table-sm table-bordered table-hover"
                                        >
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>الرقم</th>
                                                    <th>وضعية المخابز</th>
                                                    <th>عدد الاشهر</th>
                                                    <th>
                                                        المبلغ المتبقي (لم يدفع)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="padding: 0">
                                                    <th style="width: 5%"></th>
                                                    <th style="width: 65%"></th>
                                                    <th
                                                        dir="ltr"
                                                        style="width: 10%"
                                                    ></th>
                                                    <td
                                                        dir="ltr"
                                                        style="width: 20%"
                                                        class="text-bold"
                                                    ></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- Table row -->
                            <div style="margin-top: 1em" class="col-sm-12">
                                <table class="table no-border">
                                    <tr>
                                        <td
                                            style="text-align: left"
                                            colspan="2"
                                        >
                                            المحاسب
                                        </td>
                                        <td
                                            style="text-align: right"
                                            colspan="2"
                                        >
                                            <strong> الرئيس </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="text-align: left"
                                            colspan="2"
                                        ></td>
                                        <td
                                            style="text-align: right"
                                            colspan="2"
                                        >
                                            <strong>66</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a
                                        href=""
                                        type="button"
                                        class="btn btn-success float-right"
                                        ><i class="fa fa-print"></i>
                                        Imprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</template>

<script setup>
const impots = ['PAYE', 'NONPAYE', 'SEMIPAYE', 'FERMER', 'EXONERER'];
const props = defineProps({
    data: Object,
});


const returnTotalRecette = function () {
    var total = 0;
    Object.entries(props.data.dupMontantRecette).forEach((montant) => {
        total += montant[1];
    });
    return total;
};

const returnTotalDepence = function () {
    var total = 0;
    Object.entries(props.data.dupMontantDepence).forEach((montant) => {
        total += montant[1];
    });
    return total + props.data.dupMontantDepenceSalaire + props.data.dupMontantAvanceSalaire;
};

console.log(returnTotalDepence());

</script>
