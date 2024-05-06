$(document).ready(function () {
  const form = $("#form-login");
  const email = $("#email");
  const password = $("#contraseña");

  $("#email, #contraseña").on("input", function () {
    if ($(this).val().trim() != "") {
      $(this).parent().removeClass("error");
    }
  });

  function mostrarToast(tipo, titulo, mensaje) {
    const toast = $(".toast");
    toast.addClass(`${tipo} show`);
    $(".toast-header strong").text(titulo.toUpperCase());
    $(".toast-body").text(mensaje);
    $(".close-toast").on("click", function () {
      if (toast) {
        cerrarToast();
      }
    });
  }

  function cerrarToast() {
    const toast = $(".toast");
    toast.removeClass("show");
  }

  form.submit(function (e) {
    e.preventDefault();
    cerrarToast();
    if (email.val().trim() == "") {
      mostrarToast("error", "error", "Rellena el campo de email");
      email.parent().addClass("error");
    } else {
      email.parent().removeClass("error");
    }

    if (password.val().trim() == "") {
      mostrarToast("error", "error", "Rellena el campo de la contraseña");
      password.parent().addClass("error");
    } else {
      password.parent().removeClass("error");
    }

    if (email.val().trim() == "" && password.val().trim() == "") {
      mostrarToast("error", "error", "Rellena los campos vacios");
      email.parent().addClass("error");
      password.parent().addClass("error");
    } else {
      const method = $(this).attr("method");
      const action = $(this).attr("action");
      $.ajax({
        url: action,
        type: method,
        data: $(this).serialize(),
        success: function (response) {
          var data = JSON.parse(response);
          if (data.status == 200) {
            console.log(data);
            mostrarToast("success", data.title, data.message);
            setTimeout(() => {
              window.location.href = data.url;
            }, 2000);
          } else {
            mostrarToast("error", data.title, data.message);
          }
        },
        error: function (error) {
          mostrarToast("error", "Error en el servidor");
        },
      });
    }
  });

  $(".icon-view").on("click", function () {
    if (password.attr("type") === "password") {
      password.attr("type", "text");
      $(".view").css("display", "none");
      $(".view-off").css("display", "block");
    } else {
      password.attr("type", "password");
      $(".view-off").css("display", "none");
      $(".view").css("display", "block");
    }
  });
});
