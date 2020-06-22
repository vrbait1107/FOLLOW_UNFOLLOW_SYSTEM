$(document).ready(function () {
  // ########### Change Password
  $("#changePassword").click(function (e) {
    e.preventDefault();
    let changePassword = "changePassword";
    let newPassword = $("#newPassword").val();
    let conNewPassword = $("#conNewPassword").val();
    let currentPassword = $("#currentPassword").val();

    if (currentPassword === "") {
      Swal.fire({
        icon: "warning",
        title: "Warning",
        text: "Current Password Cannot be Empty",
      });
      return false;
    }

    if (newPassword === "") {
      Swal.fire({
        icon: "warning",
        title: "Warning",
        text: "New Password Cannot be Empty",
      });
      return false;
    }

    if (conNewPassword === "") {
      Swal.fire({
        icon: "warning",
        title: "Warning",
        text: "Confirm Password Cannot be Empty",
      });
      return false;
    }

    $.ajax({
      url: "ajaxHandlerPHP/ajaxUserAccount.php",
      type: "post",
      data: {
        changePassword: changePassword,
        newPassword: newPassword,
        conNewPassword: conNewPassword,
        currentPassword: currentPassword,
      },
      beforeSend() {
        $("#changeEmailResponse").html("Your Request is Processing");
      },
      success(data) {
        $("#changePasswordResponse").html(data);
        $("form").trigger("reset");
      },
      error() {
        $("#changePasswordResponse").html("Something Went Wrong");
      },
    });
  });

  //############## Change Email Addresss
  $("#changeEmail").click(function (e) {
    e.preventDefault();
    let changeEmail = "changeEmail";
    let newEmail = $("#newEmail").val();
    let password = $("#password").val();

    if (newEmail === "") {
      Swal.fire({
        icon: "warning",
        title: "Warning",
        text: "New Email Cannot be Empty",
      });
      return false;
    }

    if (password === "") {
      Swal.fire({
        icon: "warning",
        title: "Warning",
        text: "Password Cannot be Empty",
      });
      return false;
    }

    $.ajax({
      url: "ajaxHandlerPHP/ajaxUserAccount.php",
      type: "post",
      data: {
        changeEmail: changeEmail,
        newEmail: newEmail,
        password: password,
      },
      beforeSend() {
        $("#changeEmailResponse").html("Your Request is Processing");
      },
      success(data) {
        $("#changeEmailResponse").html(data);
        $("form").trigger("reset");
      },
      error() {
        $("#changeEmailResponse").html("Something Went Wrong");
      },
    });
  });

  // ######################    DELETE ACCOUNT

  $("#deleteAccount").click(function () {
    let deleteAccount = "deleteAccount";

    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete My Account!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "ajaxHandlerPHP/ajaxUserAccount.php",
          type: "post",
          data: {
            deleteAccount: deleteAccount,
          },
          beforeSend() {
            $("#deleteAccountResponse").html("Your Request Processing");
          },
          success(data) {
            $("#deleteAccountResponse").html(data);
            $("form").trigger("reset");
          },
          error() {
            $("#disableAccountResponse").html("Something Went Wrong");
          },
        });
      }
    });
  });
});
