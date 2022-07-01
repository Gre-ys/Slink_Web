$(() => {
  $("#logout").on("click", function () {
    Swal.fire({
      icon: "warning",
      title: "Yakin untuk Log Out?",
      confirmButtonText: "Log Out",
      confirmButtonColor: "red",
      showCloseButton: "true",
    }).then((result) => {
      if (result.isConfirmed) {
        document.location.href = "./cms.php?logout=true";
      }
    });
  });

  $(".trigger_deletePost").on("click", function () {
    id = $(this).data("id");
    Swal.fire({
      icon: "warning",
      title: "Yakin untuk Hapus Post?",
      confirmButtonText: "Hapus",
      confirmButtonColor: "red",
      showCloseButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        document.location.href = "./cms.php?delete_id=" + id;
      }
    });
  });

  $("#delete_user_trigger").on("click", function (e) {
    text = $("#text").val();
    e.preventDefault();
    Swal.fire({
      icon: "warning",
      title: "Yakin untuk Hapus Akun?",
      confirmButtonText: "Hapus",
      confirmButtonColor: "red",
      showCloseButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $("#delete_user").click();
      }
    });
  });

  $("#submit_transfer_trigger").on("click", function (e) {
    e.preventDefault();
    Swal.fire({
      icon: "warning",
      title: "Yakin untuk Transfer Data Akun?",
      confirmButtonText: "Transfer",
      confirmButtonColor: "red",
      showCloseButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $("#submit_transfer").click();
      }
    });
  });
});
