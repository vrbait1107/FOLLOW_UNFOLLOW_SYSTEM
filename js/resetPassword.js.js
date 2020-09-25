$(document).ready(function () {
  $("#resetPasswordForm").on("submit", function () {
    let newPassword = $("#password").val();
    let confirmNewPassword = $("#confirmNewPassword").val();

    if (newPassword.length < 8) {
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Password length must be atleast 8 Characters",
      });
      return false;
    }

    if (!/[a-z]/g.test(newPassword)) {
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Password must contain at least one Lowercase Letter (a-z)",
      });
      return false;
    }

    if (!/[A-Z]/g.test(newPassword)) {
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Password must contain at least one Uppercase Letter (A-Z).",
      });
      return false;
    }

    if (!/\d/g.test(newPassword)) {
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Password must contain at least one number (0-9)",
      });
      return false;
    }

    if (!/[-!$%^&*()_+|~=`{}[:;<>?,.@#\]]/g.test(newPassword)) {
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text:
          "Password must contain at least one Special Character. ([-!$%^&*()_+|~=`{}[:;<>?,.@#])",
      });
      return false;
    }

    if (newPassword !== confirmNewPassword) {
      Swal.fire({
        icon: "error",
        title: "ERROR",
        text: "Password & Confirm password field are not Same",
      });
      return false;
    }
  });
});
