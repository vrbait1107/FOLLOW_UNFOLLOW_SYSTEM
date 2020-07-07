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

    var post = $("#post").val();
    let insert = "insert";

    if ($("#postType" === "upload")) {
      var post = $("#post").val($("#subDivision").html());
    }

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
        error() {
          $("#responseUnfollow").html("Something Went Wrong");
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

//---------------------------------------> RETWEET FUNCTIONALITY

$(document).on("click", ".repostButton", function () {
  let postId = $(this).data("post_id");
  let retweet = "retweet";

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      postId: postId,
      retweet: retweet,
    },
    success(data) {
      $("#responseRetweet").html(data);
      readingPost();
    },
    error(err) {
      alert("Something Went Wrong");
    },
  });
});

// ----------------------------------------------------->> LIKE FUNCTIONALITY

$(document).on("click", ".likeButton", function () {
  let postId = $(this).data("like_id");
  let likeButton = "like";

  $.ajax({
    url: "ajaxHandlerPHP/ajaxIndex.php",
    type: "post",
    data: {
      postId: postId,
      likeButton: likeButton,
    },
    success(data) {
      $("#responseLike").html(data);
      readingPost();
    },
    error(err) {
      alert("Something Went Wrong");
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

//---------------------------------->> UPLOAD IMAGE AND VIDEO AS POST

$("#uploadFile").on("change", function (event) {
  var html = '<div id= "mainDivision"> <div id= "subDivision"> </div> </div>';

  // This Will Replace with Test Story Input
  html += '<input type="hidden" name="post" id= "post">';

  // This will indicate that user wants to share Images and Videoes
  $("#postType").val("upload");

  // This will replace normal story content with above code
  $("#dynamicField").html(html);

  // This Will Show uploaded Image and Video in Subdivision
  $("#uploadImage").ajaxSubmit({
    target: "#subDivision",
    resetForm: true,
  });
});
