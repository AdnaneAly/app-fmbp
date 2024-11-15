<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section dir="rtl" style="text-align: right;" class="content-header">
            <div class="card card-cyan card-outline mx-2">
                <div class="card-header">
                    <div class="card-default ">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="text-cyan"><i class="fas fa-bars"></i>title </h4>
                            </div>
                            <div class="col-md-7 text-left">
                                <a style="margin-right: 10px;" href="#" class="btn btn-success "><i class="fas fa-print"></i> طباعة</a>
                                <a style="margin-right: 10px;" href="#" class="btn btn-primary "><i class="fas fa-plus"></i> إضافة</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Timelime example  -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- The time line -->
                        <div class="timeline">
                            <!-- timeline time label -->
                            <div class="time-label">
                                <span class="bg-red">24-12-22</span>
                            </div>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <div dir="rtl" style="text-align: right">
                                <div class="timeline-item">
                                    <span class="time float-left"><i class="fas fa-clock"></i>
                                        7:56</span>
                                    <h3 class="timeline-header">المخبزة : السماحة</h3>

                                    <div class="timeline-body">
                                        الرسالة
                                    </div>
                                    <div class="timeline-footer">
                                        <small class="text-blue">الرتبة :
                                            العامل</small>
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->

                                <!-- timeline time label -->
                                <div class="time-label">
                                    <span class="bg-green">24-12-24</span>
                                </div>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <div dir="rtl" style="text-align: right">
                                    <i class="fas {{$value->image === null ? 'fa-comments bg-yellow' : 'fa-camera bg-purple'}}"></i>
                                    <div class="timeline-item">
                                        <span class="time float-left"><i class="fas fa-clock"></i>
                                            7:56</span>
                                        <h3 class="timeline-header">الرتبة :
                                            العامل
                                        </h3>
                                        <div class="timeline-body">
                                            الرسالة
                                        </div>
                                        <div class="timeline-body">
                                            <div class="filtr-item text-center" data-category="3, 4" data-sort="red sample">
                                                <a href="#" data-toggle="lightbox" data-title="{{$value->numeroFacture}}">
                                                  <img src="#" class="img-fluid mb-2" alt="red sample"/>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="timeline-footer">
                                            <a style="margin-right: 10px; margin-left: 10px;" class="btn btn-info btn-sm" href="#" title="تعديل">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                تعديل
                                            </a>
                                            <a href="javascript:void(0)" onclick="#" class="btn btn-danger btn-sm" title="مسح"><i class="fa fa-trash"></i>مسح</a>
                                            <form action="#" method="post" id="delete-" style="display: none">

                                            </form>
                                          </div>
                                    </div>


                                </div>






                            <div>
                                <i class="fas fa-clock bg-gray"></i>

                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.timeline -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>
<script setup>

</script>
