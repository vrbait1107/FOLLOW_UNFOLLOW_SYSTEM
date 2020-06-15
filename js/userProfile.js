let getProfileDetails;

$(document).ready(function () {
  getProfileDetails = () => {
    profileData = "profileData";

    $.ajax({
      url: "ajaxHandlerPHP/ajaxUserProfile.php",
      type: "post",
      data: {
        profileData: profileData,
      },
      success(data) {
        let profile = JSON.parse(data);
        $("#updateName").val(profile.name);
        $("#updateBio").val(profile.bio);
        $("#hiddenEmail2").val(profile.email);
        $("#hiddenEmail1").val(profile.email);
        $("#showProfileImage").attr(
          "src",
          `profileImage/${profile.profileImage}`
        );
      },
      error() {
        $("#updateResponse").html("Something Went Wrong");
      },
    });
  };

  getProfileDetails();

  // ############ UPDATE USER PROFILE

  $("#userProfileForm").on("submit", function (e) {
    e.preventDefault();

    let updateName = $("#updateName").val();
    let updateBio = $("#updateBio").val();
    let hiddenEmail2 = $("#hiddenEmail2").val();

    $.ajax({
      url: "ajaxHandlerPHP/ajaxUserProfile.php",
      type: "post",
      data: {
        updateName: updateName,
        updateBio: updateBio,
        hiddenEmail2: hiddenEmail2,
      },
      success(data) {
        $("#updateResponse").html(data);
        getProfileDetails();
      },
    });
  });

  //################ CHANGE PROFILE IMAGE
  $("#changeProfileImageForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "ajaxHandlerPHP/ajaxUserProfile.php",
      type: "post",
      data: new FormData(this),
      contentType: false,
      processData: false,
      beforeSend() {
        $("#updateImageResponse").html("...Uploading");
      },
      success(data) {
        $("#updateImageResponse").html(data);
        $("#updateProfileImage").val("");
      },
      error() {
        $("#updateImageResponse").html("Something Went Wrong");
      },
    });
  });
});
