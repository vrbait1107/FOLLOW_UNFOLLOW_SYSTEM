let readingPost;
let readingUserProfiles;

$(document).ready(function () {
  // ########### READING RECORD

  readingPost = () => {
    readingPostData = "readingPostData";

    $.ajax({
      url: "ajaxHandlerPHP/ajaxIndex.php",
      type: "post",
      data: {
        readingPostData: readingPostData,
      },
      success(data) {
        $("#responsePostData").html(data);
      },
      error() {
        $("#responsePostData").html("Something Went Wrong");
      },
    });
  };

  readingPost();

  // ############# DISPLAYING USER PROFILES

  readingUserProfiles = () => {
    let readingProfiles = "readingProfiles";

    $.ajax({
      url: "ajaxHandlerPHP/ajaxIndex.php",
      type: "post",
      data: {
        readingProfiles: readingProfiles,
      },
      success(data) {
        $("#responseUserProfiles").html(data);
      },
      error() {
        $("#responseUserProfiles").html("Something Went Wrong");
      },
    });
  };

  readingUserProfiles();

  // // ####################################### INSERTING POST

  $("#postForm").on("submit", function (e) {
    e.preventDefault();
    let post = $("#post").val();
    let insert = "insert";

    if (post === "") {
      alert("Story Cannot be Empty");
      return false;
    }

    $.ajax({
      url: "ajaxHandlerPHP/ajaxIndex.php",
      type: "post",
      data: {
        post: post,
        insert: insert,
      },
      success(data) {
        $("#responseMessage").html(data);
        $("#postForm").trigger("reset");
        readingPost();
      },
      error() {
        $("#responseMessage").html("Something Went Wrong");
      },
    });
  });
});

//################################## FOLLOW USER AJAX REQUEST

const followUser = (id) => {
  let followingId = id;
  let follow = "follow";

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      followingId: followingId,
      follow: follow,
    },
    success(data) {
      $("#responseFollow").html(data);
      readingUserProfiles();
      readingPost();
    },
    error() {
      $("#responseFollow").html("Something Went Wrong");
    },
  });
};

//################################## UNFOLLOW USER AJAX REQUEST
const unfollowUser = (id) => {
  let followingId = id;
  let unfollow = "unfollow";

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to Unfollow this User?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Unfollow",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "ajaxHandlerPHP/ajaxIndex.php",
        type: "post",
        data: {
          followingId: followingId,
          unfollow: unfollow,
        },
        success(data) {
          $("#responseUnfollow").html(data);
          readingUserProfiles();
          readingPost();
        },
        error() {
          $("#responseUnfollow").html("Something Went Wrong");
        },
      });
    }
  });
};
var post_id;
$(document).on("click", ".toggleButton", function () {
  post_id = $(this).attr("id");
  $("#commentForm" + post_id).toggle();
});
