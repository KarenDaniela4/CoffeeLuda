// Manejo del formulario de Login mediante peticiones asíncronas
document.getElementById("loginForm").addEventListener("submit", function(e) {
  e.preventDefault();

  let email = document.getElementById("email").value;
  let password = document.getElementById("password").value;

// Comunicación con el servidor mediante Fetch (envío de JSON)
  fetch("backend/login.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email, password })
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      alert("Bienvenido");
      window.location.href = "menu.php";
    } else {
      alert("Error en login");
    }
  });
});
if (err) {
  if (err.code === "ER_DUP_ENTRY") {
    return res.status(400).json({ error: "El email ya está registrado" });
  }
  return res.status(500).json(err);
}