$(document).ready(function () {
  $("#forgotPasswordForm").on("submit", function (e) {
    e.preventDefault();

    let email = $("#email").val();
    let submit = "submit";

    if (email === "") {
      Swal.fire({
        icon: "warning",
        title: "Warning",
        text: "Email Cannot be empty",
      });
      return false;
    }

    $.ajax({
      url: "ajaxHandlerPHP/ajaxForgotPassword.php",
      type: "post",
      data: {
        email: email,
        submit: submit,
      },
      beforeSend() {
        $("#responseMessage").html("Sending Email.....");
      },
      success(data) {
        $("#responseMessage").html(data);
        $("#forgotPasswordForm").trigger("reset");
      },
      error() {
        $("#responseMessage").html("Something Went Wrong");
      },
    });
  });
});
