// Jquery Untuk Manipulasi Modal
$(() => {
  // Sesuaikan Modal Form untuk Keperluan Inset Data
  $("#trigger_createPost").click(function () {
    $("#modal_label").html("Tambah Data Post");
    $("#modal_button").attr("name", "submit_createPost");
    $("#modal_button").html("Submit");
    $("#id").val("");
    $("#user_id").val("");
    $("#judul").val("");
    $("#deskripsi").val("");
    $("#link").val("");
    $("#category").val("");
  });

  // Sesuaikan Modal Form untuk Keperluan Update Data
  $(".trigger_updatePost").click(function () {
    let id = $(this).data("id");
    $("#modal_label").html("Update Data Post");
    $("#modal_button").attr("name", "submit_updatePost");
    $("#modal_button").html("Update");

    // AJAX untuk Get Data Mahasiswa Sesuai Id Tertentu
    $.ajax({
      url: "async_cms.php",
      data: { id: id },
      method: "POST",
      dataType: "JSON",
      crossDomain: true,
      success: function (data) {
        console.log(data);
        // Inisialisasi Form dalam Modal untuk di Update
        $("#id").val(data.post.id);
        $("#judul").val(data.post.judul);
        $("#deskripsi").val(data.post.deskripsi);
        $("#link").val(data.post.link);
        $("#category").val(data.post.nama);
        let list_cat = ``;
        data.category.map((cat) => {
          list_cat += `<option value="${cat.nama}"></option>`;
          console.log(list_cat);
        });
        $("#list_category").html(list_cat);
      },
    });
  });
});
