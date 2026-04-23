/**
 * Función para gestionar el inicio de sesión
 * Captura credenciales y se comunica con el API de autenticación
 */
function login() {
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const error = document.getElementById("error");

  // Limpia mensajes de error previos
    error.textContent = "";

  // VALIDACIÓN
  if (!email || !password) {
    error.textContent = "Completa todos los campos";
    return;
  }

  /**
   * Petición asíncrona mediante Fetch API
   * Envía las credenciales en formato JSON al endpoint de autenticación
   */
    fetch("http://localhost:3000/api/auth/login", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({ email, password })
  })
  .then(res => res.json())
  .then(data => {
    // Si el servidor retorna un token, la autenticación es exitosa
    if (data.token) {
    // PERSISTENCIA: Se guarda el token en el LocalStorage para mantener la sesión
      localStorage.setItem("token", data.token);
      window.location.href = "menu.php";
    } else {
    // Manejo de errores específicos enviados por el servidor
      error.textContent = data.error || "Error en login";
    }
  })
  .catch(() => {
    // Manejo de errores de red o servidor caído
    error.textContent = "Error de conexión con el servidor";
  });
}