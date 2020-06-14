const registerValidation = () => {
  let username = $("#username").val();
  let password = $("#password").val();
  let email = $("#email").val();
  let confirmPassword = $("#confirmPassword").val();

  if (username === "") {
    Swal.fire({
      icon: "warning",
      title: "Warning",
      text: "Username cannot be Empty",
    });
    return false;
  }

  if (email === "") {
    Swal.fire({
      icon: "warning",
      title: "Warning",
      text: "Email cannot be Empty",
    });
    return false;
  }

  if (password === "") {
    Swal.fire({
      icon: "warning",
      title: "Warning",
      text: "Password cannot be Empty",
    });
    return false;
  }

  if (password.length < 6) {
    Swal.fire({
      icon: "warning",
      title: "Warning",
      text: "Password must be atleast 6 Character Long",
    });
    return false;
  }

  if (confirmPassword === "") {
    Swal.fire({
      icon: "warning",
      title: "Warning",
      text: "Confirm Password cannot be Empty",
    });
    return false;
  }
};
