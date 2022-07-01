<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- CSS only -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/style.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <title>Slink</title>
</head>

<body>
  <!-- navbar -->
  <div class="animasi2">
    <nav class="navbar navbar-expand">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="./Foto/logo.png" alt="" /></a>
      </div>
      <a class="navbar-brand p-2" href="./src/login.php"><button type="button" class="btn btn-light shadow" style="border-color: #45625d">Login</button></a>
      <a class="navbar-brand p-2" href="./src/register.php"><button type="button" class="btn shadow text-white" style="border-color: #45625d; background-color: #6aa5a9;">Register</button></a>
    </nav>
  </div>
  <div class="animasi">
    <!-- banner -->
    <div class="container-fluid p-5">
      <div class="jumbotron p-5 mt-5 mb-5">
        <h1 class="newbanner pt-5">Welcome Back!</h1>
        <p class="newbanner pb-5">Register! to become our member as Slinker's</p>
      </div>
    </div>

    <!-- easy info -->
    <center>
      <div class="container">
        <h4 class="text-center p-5" style="color: #6aa5a9; text-shadow: 1px 1px 5px #fff">Why use Slink?</h4>
        <div class="row mt-5 mb-5">
          <div class="col-sm m-auto justify-content-center">
            <img src="./Foto/click.png" alt="" width="20%" height="90%"><br>
            <h5 class="mt-4 pb-5"><b>First</b> | Easy to use</h5>
          </div>
          <div class="col-sm  m-auto justify-content-center">
            <img src="./Foto/key.png" alt="" width="20%" height="90%"><br>
            <h5 class="mt-4 pb-5"><b>Second</b> | Easy to learn</h5>
          </div>
          <div class="col-sm  m-auto justify-content-center">
            <img src="./Foto/kn.png" alt="" width="20%" height="90%"><br>
            <h5 class="mt-4 pb-5"><b>Third</b> | Easy to access</h5>
          </div>
        </div>
      </div>
    </center>

    <div class="ht container-fluid" style="background-color: #6aa5a9">
      <h4 class="text-center pt-5 text-white">Our Developer</h4>
      <div class="row">
        <div class="col-md-4 p-5">
          <div class="card user-card">
            <div class="card-block shadow ">
              <div class="user-image d-flex justify-content-center mt-5">
                <img src="./Foto/dhafin.jpg" width="100" height="100" class="img-radius shadow" alt="User-Profile-Image" />
              </div>
              <h6 class="f-w-600 mt-5 mb-5 m-t-25 m-b-10 text-center">Dhafin Taufiqi</h6>
            </div>
          </div>
        </div>
        <div class="col-md-4 p-5">
          <div class="card user-card">
            <div class="card-block shadow">
              <div class="user-image d-flex justify-content-center mt-5">
                <img src="./Foto/surya.jpeg" width="100" height="100" class="img-radius shadow" alt="User-Profile-Image" />
              </div>
              <h6 class="f-w-600 mt-5 mb-5 m-t-25 m-b-10 text-center">Raden Surya M.P</h6>
            </div>
          </div>
        </div>
        <div class="col-md-4 p-5">
          <div class="card user-card">
            <div class="card-block shadow">
              <div class="user-image d-flex justify-content-center mt-5">
                <img src="./Foto/raka.jpg" width="100" height="100" class="img-radius shadow" alt="User-Profile-Image" />
              </div>
              <h6 class="f-w-600 mt-5 mb-5 m-t-25 m-b-10 text-center">Raka Ryandra Guntara</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="row">
      <div class="col-lg-12 text-center mt-5 mb-5">
        <p><small>Copyright &copy; Slink 2022</small></p>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </footer>

</body>

</html>