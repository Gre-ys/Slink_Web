// Import Data
var DataUsers = JSON.parse(localStorage.getItem("data-users"));

// Login
const login = (e) => {
  e.preventDefault();
  const logUser = {
    username: document.getElementById("floatingInput").value,
    pass: document.getElementById("floatingPassword").value,
  };

  console.log(logUser);

  let auth = false;

  if (DataUsers !== null && DataUsers.length !== 0) {
    DataUsers.map((item) => {
      if (logUser.username == item.username && logUser.pass == item.pass) {
        auth = true;
        localStorage.setItem("log-user", JSON.stringify(item));
        window.location.href = "./home.html";
      }
    });
  }

  if (auth === false) {
    alert("Kamu siapa... aku siapa... kamu siapa...");
  }
};

// Trigger Login
document.getElementById("submit_login").addEventListener("click", login);

