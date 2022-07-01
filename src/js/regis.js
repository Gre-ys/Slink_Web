// Import Data
var DataUsers = JSON.parse(localStorage.getItem("data-users"));

//registrasi User
const Register = (e) => {
  e.preventDefault();

  let newUser = {
    id: Math.random(),
    nama: document.getElementById("inputnama1").value,
    namab: document.getElementById("inputnama2").value,
    telp: document.getElementById("inputTelp").value,
    prof: document.getElementById("inputProfesi").value,
    username: document.getElementById("inputUsername").value,
    pass: document.getElementById("inputPassword").value,
    linked: document.getElementById("inputlinkedin").value,
  };
if(newUser.nama.length === 0 || newUser.namab.length === 0 ||newUser.telp.length === 0 ||newUser.prof.length === 0 
  ||newUser.username.length === 0 || newUser.pass.length === 0 || newUser.linked.length === 0 ){
  return alert("Mohon isi kolom yang ada!!");
}


  let gender = document.getElementsByName("inputGender");
  for (let i = 0; i < gender.length; i++) {
    if (gender[i].checked) {
      newUser.gender = gender[i].value;
    }
  }

  let usedusername = false;
  let usedtelp = false;
  if (DataUsers !== null && DataUsers.length !== 0) {
    DataUsers.map((user) => {
      if (newUser.username === user.username) {
        usedusername = true;
      }
      if (newUser.telp === user.telp) {
        usedtelp = true;
      }
    });
  }

  if (usedusername) {
    return (document.getElementById("user-text").innerHTML = "Username sudah digunakan");
  }

  if (usedtelp) {
    return (document.getElementById("telp-text").innerHTML = "No telephone sudah digunakan");
  }

  console.log(newUser);
  if (DataUsers === null) {
    DataUsers = [];
    DataUsers.push(newUser);
    localStorage.setItem("data-users", JSON.stringify(DataUsers));
    document.location.href = "../src/Login.html";
  } else {
    DataUsers.push(newUser);
    localStorage.setItem("data-users", JSON.stringify(DataUsers));
    return alert("Registrasi berhasil");
    document.location.href = "../src/Login.html";
  }
};

// Trigger Registrasi User
document.getElementById("submit_user").addEventListener("click", Register);
