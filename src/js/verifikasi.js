$(() => {
  $("#getOtp").on("click", function () {
    let email = $("#email").val();
    $.ajax({
      url: "async_verifikasi.php",
      method: "POST",
      data: { email: email },
      crossDomain: true,
      success: function (data) {
        $("#info_otp").html(data);
      },
      error: function (errorMessage) {
        alert(errorMessage);
      },
    });
  });
});
