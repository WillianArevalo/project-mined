$(document).ready(function () {
  $(".button-hamburger").on("click", function () {
    $(".navbar").toggleClass("open");

    if (window.innerWidth < 690) {
      $("#overlay").toggleClass("show");
    }
  });

  window.addEventListener("resize", function () {
    if (window.innerWidth <= 845) {
      $(".navbar").removeClass("open");
    }

    if (window.innerWidth < 690) {
      $("#overlay").removeClass("show");
    }
  });

  $(".button-alert").on("click", function () {
    $(".alerts").toggleClass("open");
  });

  $(document).on("click", function (e) {
    if (
      // Si el click no es en el contenedor de las alertas ni en el botón de las alertas se cierra el menú
      !$(e.target).closest(".alerts").length &&
      !$(e.target).closest(".button-alert").length
    ) {
      $(".alerts").removeClass("open");
    }
  });

  $(".button-close").on("click", function () {
    $(".navbar").removeClass("open");
    $("#overlay").removeClass("show");
  });
});
