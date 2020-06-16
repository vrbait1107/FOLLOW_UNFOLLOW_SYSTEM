let readingPost;

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

  $("#commentForm").on("submit", function (e) {
    e.preventDefault();
    let comment = $("#comment").val();
    let insert = "insert";

    if (comment === "") {
      alert("Story Cannot be Empty");
      return false;
    }

    // ######### INSERTING POST
    $.ajax({
      url: "ajaxHandlerPHP/ajaxIndex.php",
      type: "post",
      data: {
        comment: comment,
        insert: insert,
      },
      success(data) {
        $("#responseMessage").html(data);
        $("#commentForm").trigger("reset");
        readingPost();
      },
      error() {
        $("#responseMessage").html("Something Went Wrong");
      },
    });
  });
});
