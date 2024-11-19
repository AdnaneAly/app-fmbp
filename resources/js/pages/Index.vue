<template>
  <div class="content-header">
    <div class="container-fluid">
      <section dir="rtl" style="text-align: center" class="content">
        <div class="container-fluid">
          <img
            style="padding-top: 3em; padding-bottom: 30px; justify-content: center"
            class="img-fluid pad"
            src="~admin-lte/dist/img/fmbp.png"
            alt=""
          />
        </div>
      </section>
    </div>
  </div>
</template>

<script>
$(function () {
  //Initialize Select2 Elements
  $(".select2").select2();

  //Initialize Select2 Elements
  $(".select2bs4").select2({
    theme: "bootstrap4",
  });
});

// DropzoneJS Demo Code End
</script>
