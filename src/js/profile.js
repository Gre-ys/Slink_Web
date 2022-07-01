$(() => {
  // Menampilkan Follower
  $("#follower").on("click", function () {
    $("#modal_label").html("Follower");
    let get_id = $(this).data("id");

    // AJAX untuk Get Data Follower
    $.ajax({
      url: "async_profile.php",
      data: { follower: true, get_id: get_id },
      method: "POST",
      crossDomain: true,
      success: function (data) {
        $(".modal-body").html(data);
        $(".modal-follows").html(data);
      },
    });
  });

  // Menampilkan Following
  $("#following").on("click", function () {
    $("#modal_label").html("Following");
    let get_id = $(this).data("id");

    // AJAX untuk Get Data Following
    $.ajax({
      url: "async_profile.php",
      data: { following: true, get_id: get_id },
      method: "POST",
      crossDomain: true,
      success: function (data) {
        $(".modal-body").html(data);
        $(".modal-follows").html(data);
      },
    });
  });

  $(document).on("click", ".follow_button", function () {
    let other_id = $(this).data("id");
    let clicked_btn = $(this);

    // Menentukan Aksi yang Dilakukan User
    if (clicked_btn.hasClass("btn btn-primary")) {
      action = "follow";
    } else if (clicked_btn.hasClass("btn btn-outline-danger")) {
      action = "unfollow";
    }

    //Ajax untuk Mengubah Tombol dan Manipulasi data Likes di DB Secara Async
    $.ajax({
      url: "async_profile.php",
      data: {
        action: action,
        other_id: other_id,
      },
      method: "POST",
      crossDomain: true,
      success: function () {
        // Ubah Tombol Secara Real-Time
        if (action == "follow") {
          clicked_btn.removeClass("btn btn-primary");
          clicked_btn.addClass("btn btn-outline-danger");
          clicked_btn.html("Unfollow");
        } else if (action == "unfollow") {
          clicked_btn.removeClass("btn btn-outline-danger");
          clicked_btn.addClass("btn btn-primary");
          clicked_btn.html("Follow");
        }
      },
      error: function (errorMessage) {
        alert(errorMessage);
      },
    });
  });
});
