function login() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const error = document.getElementById("error");

  error.textContent = "";

  // VALIDACIÓN
  if (!email || !password) {
    error.textContent = "Completa todos los campos";
    return;
  }

  fetch("http://localhost:3000/api/auth/login", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email, password })
  })
  .then(res => res.json())
  .then(data => {
    if (data.token) {
      localStorage.setItem("token", data.token);
      window.location.href = "menu.php";
    } else {
      error.textContent = data.error || "Error en login";
    }
  })
  .catch(() => {
    error.textContent = "Error de conexión con el servidor";
  });
}