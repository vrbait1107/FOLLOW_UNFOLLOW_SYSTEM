$(document).ready(function () {
  $("#logout").click(function (e) {
    e.preventDefault();
    let logout = "logout";

    Swal.fire({
      title: "Logout",
      text: "Are you sure you want to Logout?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, Logout!",
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "logout.php",
          type: "post",
          data: {
            logout: logout,
          },
          success(data) {
            location.reload();
          },
          error(err) {
            alert("Something Went Wrong");
          },
        });
      }
    });
  });
});
