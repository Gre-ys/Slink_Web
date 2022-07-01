$(() => {
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 3,
    nav: true,
    autoWidth: true,
    autoplay: true,
    autoplayTimeout: 2000,
    autoplayHoverPause: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 5,
      },
    },
  });

  getComments($("#post_id").val());

  // Trigger Like dan Unlike
  $(".like_button").on("click", function () {
    let post_id = $(this).data("id");
    let clicked_btn = $(this);


    // Menentukan Aksi yang Dilakukan User
    if (clicked_btn.hasClass("bi bi-heart")) {
      action = "like";
    } else if (clicked_btn.hasClass("bi bi-heart-fill")) {
      action = "unlike";
    }

    //Ajax untuk Mengubah Tombol dan Manipulasi data Likes di DB Secara Async
    $.ajax({
      url: "async_home.php",
      data: {
        action: action,
        post_id: post_id,
      },
      method: "POST",
      crossDomain: true,
      success: function (data) {
        // Ubah Tombol Secara Real-Time
        if (action == "like") {
          clicked_btn.removeClass("bi bi-heart");
          clicked_btn.addClass("bi bi-heart-fill text-danger");
        } else if (action == "unlike") {
          clicked_btn.removeClass("bi bi-heart-fill text-danger");
          clicked_btn.addClass("bi bi-heart");
        }

        // Menampilkan Jumlah Like
        clicked_btn.siblings("span.likes").html(`<span class='likes'>${data} Likes</span`);
      },
      error: function (errorMessage) {
        alert(errorMessage);
      },
    });
  });

  // Trigger Bookmark
  $(".bookmark_button").on("click", function () {
    let post_id = $(this).data("id");
    let clicked_btn = $(this);
    let reload = $(this).data("reload");
    console.log(clicked_btn);
    if (clicked_btn.hasClass("bi bi-bookmark")) {
      action = "mark";
    } else if (clicked_btn.hasClass("bi bi-bookmark-fill")) {
      action = "unmark";
    }

    $.ajax({
      url: "async_home.php",
      data: {
        action: action,
        post_id: post_id,
      },
      method: "POST",
      crossDomain: true,
      success: function () {
        if (action == "mark") {
          clicked_btn.removeClass("bi bi-bookmark");
          clicked_btn.addClass("bi bi-bookmark-fill text-primary");
        } else if (action == "unmark") {
          clicked_btn.removeClass("bi bi-bookmark-fill text-primary");
          clicked_btn.addClass("bi bi-bookmark");
        }

        if (reload == 1) {
          document.location.reload();
        }
      },
      error: function (errorMessage) {
        alert(errorMessage);
      },
    });
  });

  // Trigger Komentar
  $(".comment_button").on("click", function () {
    $("#post_id").val($(this).data("id"));

    // Ajax untuk Menampilkan Komentar
    getComments($(this).data("id"));

    // Trigger Menutup Komentar
    $("#close").on("click", function () {
      post_id = "";
      $("#post_id").val("");
      $("#comment_form")[0].reset();
    });
  });

  // Trigger untuk Membuat Komentar
  $("#comment_form").on("submit", function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    var formData = $(this).serialize();

    $.ajax({
      url: "async_home.php",
      method: "POST",
      data: formData,
      crossDomain: true,
      success: function () {
        $("#comment_form")[0].reset();
        $("#parent_comment_id").val("0");
        getComments($("#post_id").val());
      },
      error: function (errorMessage) {
        alert(errorMessage);
      },
    });
  });

  // Trigger Melakukan Reply Pada Komentar
  $(document).on("click", ".reply", function () {
    let parent_comment_id = $(this).attr("id");
    $("#parent_comment_id").val(parent_comment_id);
    $("#comment").focus();
  });

  // Fungsi untuk Menampilkan Komentar
  function getComments(post_id) {
    $.ajax({
      url: "async_home.php",
      method: "POST",
      data: { getComments: true, post_id: post_id },
      success: function (data) {
        $(".modal-body").html(data);
        $("#comments").html(data);
      },
      error: function (errorMessage) {
        alert(errorMessage);
      },
    });
  }

  // Trigger See More
  $("#button_seeMore").on("click", function () {
    $.ajax({
      url: "async_home.php",
      method: "POST",
      data: { seeMore: true },
      crossDomain: true,
      success: function (data) {
        console.log(data);
        document.location.reload();
      },
      error: function (errorMessage) {
        console.log(errorMessage);
      },
    });
  });

  // Trigger See Less
  $("#button_seeLess").on("click", function () {
    $.ajax({
      url: "async_home.php",
      method: "POST",
      data: { seeLess: true },
      crossDomain: true,
      success: function (data) {
        console.log(data);
        document.location.reload();
      },
      error: function (errorMessage) {
        console.log(errorMessage);
      },
    });
  });
});
