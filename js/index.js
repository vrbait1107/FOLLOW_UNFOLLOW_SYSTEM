let readingPost;
let readingUserProfiles;

$(document).ready(function () {
  // -------------------------------->READING RECORD

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

  // --------------------------------> DISPLAYING USER PROFILES

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

  // // --------------------------------> INSERTING POST

  $("#postForm").on("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: "ajaxHandlerPHP/ajaxIndex.php",
      type: "post",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success(data) {
        $("#responseMessage").html(data);
        $("#postForm").trigger("reset");
        $("#frame").attr("src", "");
        $("#frame").removeClass("p-5");
        readingPost();
      },
      error() {
        $("#responseMessage").html("Something Went Wrong");
      },
    });
  });
});

//--------------------------------> FOLLOW USER AJAX REQUEST

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

//--------------------------------> LIKE POST AJAX REQUEST

const likePost = (id) => {
  let postId = id;
  let likeButton = "like";

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      postId: postId,
      likeButton: likeButton,
    },
    success(data) {
      readingPost();
    },
    error(err) {
      alert("Something Went Wrong");
    },
  });
};

//--------------------------------> RETWEET POST AJAX REQUEST

const retweet = (id) => {
  let postId = id;
  let retweet = "retweet";

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      postId: postId,
      retweet: retweet,
    },
    success(data) {
      readingPost();
    },
    error(err) {
      alert("Something Went Wrong");
    },
  });
};

//--------------------------------> UNFOLLOW USER AJAX REQUEST

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
        error(err) {
          alert(err);
        },
      });
    }
  });
};

//--------------------------------> UNLIKE POST AJAX REQUEST

const unlikePost = (id) => {
  let postId = id;
  let unlikeButton = "unlike";

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to Unfollow this Post?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Unlike",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "ajaxHandlerPHP/ajaxIndex.php",
        type: "post",
        data: {
          postId: postId,
          unlikeButton: unlikeButton,
        },
        success(data) {
          readingPost();
        },
        error(err) {
          alert(err);
        },
      });
    }
  });
};

//--------------------------------> UNTWEET POST AJAX REQUEST

const untweet = (id) => {
  let postId = id;
  let untweet = "untweet";

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to Undo this Retweet?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Undo Retweet",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "ajaxHandlerPHP/ajaxIndex.php",
        type: "post",
        data: {
          postId: postId,
          untweet: untweet,
        },
        success(data) {
          $("#responseRetweet").html(data);
          readingPost();
        },
        error(err) {
          alert(err);
        },
      });
    }
  });
};

// ---------------------------------->> DELETE POST

const deletePost = (id) => {
  let postId = id;
  let postDelete = "postDelete";

  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to delete this post?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Delete",
  }).then((result) => {
    if (result.value) {
      $.ajax({
        url: "ajaxHandlerPHP/ajaxIndex.php",
        type: "post",
        data: {
          postId: postId,
          postDelete: postDelete,
        },
        success(data) {
          $("#responseDelete").html(data);
          readingPost();
        },
        error(err) {
          alert(err);
        },
      });
    }
  });
};

//-------------------------------> COMMENT TOGGLE

var post_id;
$(document).on("click", ".toggleButton", function () {
  post_id = $(this).attr("id");

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      fetchComment: "fetchComment",
      postId: post_id,
    },
    success(data) {
      $("#oldComments" + post_id).html(data);
    },
    error(err) {
      alert(err);
    },
  });

  $("#commentForm" + post_id).toggle();
});

//-------------------------------->COMMENT ON POST

$(document).on("click", ".insertComment", function (e) {
  e.preventDefault();

  let comment = $("#comments" + post_id).val();

  if (comment === "") {
    alert("Comment Cannot be Empty");
    return false;
  }

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      submitComment: "submitComment",
      comment: comment,
      postId: post_id,
    },
    success(data) {
      $("#commentForm" + post_id).toggle();
      $("#comments" + post_id).val("");
      readingPost();
    },
    error() {
      $("#responseComment").html("Something Went Wrong");
    },
  });
});

//-------------------------------------------->> LIKE TOOLTIP FUNCTIONALITY

$("body").tooltip({
  selector: ".likeButton",
  title: likeTooltip,
  html: true,
  placement: "right",
});

var tooltipData = "";

function likeTooltip() {
  let postId = $(this).data("like_id");
  let likedUsersList = "likedUsersList";

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      likedUsersList: likedUsersList,
      postId: postId,
    },
    success(data) {
      tooltipData = data;
    },
    error(err) {
      alert("Something Went Wrong");
    },
  });

  return tooltipData;
}

//-------------------------> PREVIEW OF IMAGE BEFORE UPLOAD
const loadImg = (event) => {
  $("#frame").attr("src", URL.createObjectURL(event.target.files[0]));
  $("#frame").addClass("p-5");
};
