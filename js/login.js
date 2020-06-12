const loginValidation = () => {
  let username = $("#username").val();
  let password = $("#password").val();

  if (username === "") {
    Swal.fire({
      icon: "warning",
      title: "Warning",
      text: "Username cannot be Empty",
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
};
