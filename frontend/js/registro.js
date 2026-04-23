/**
 * Función para el registro de nuevos clientes en Coffee Luda
 * Recopila múltiples campos y los envía al controlador de usuarios
 */
function registro() {
    const mensaje = document.getElementById("mensaje");
    
    // Captura de valores desde el DOM
    const id = document.getElementById("id").value;
    const nombre = document.getElementById("nombre").value;
    const apellido = document.getElementById("apellido").value;
    const telefono = document.getElementById("telefono").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;
    const pregunta = document.getElementById("pregunta").value;
    const respuesta = document.getElementById("respuesta").value;

// Validación de campos obligatorios para integridad de la DB
    if (!email || !password || !id) {
        mensaje.innerHTML = "<span style='color: red;'>ID, Email y Password son obligatorios</span>";
        return;
    }
    // Validación de concordancia de contraseñas (Seguridad del lado del cliente)
    if (password !== confirm) {
        mensaje.innerHTML = "<span style='color: red;'>Las contraseñas no coinciden</span>";
        return;
    }

    /**
     * Objeto FormData: Empaqueta los datos para enviarlos con la misma 
     * estructura que un formulario HTML tradicional (multipart/form-data)
     */
    const datosParaEnviar = new FormData();
    datosParaEnviar.append("id", id);
    datosParaEnviar.append("nombre", nombre);
    datosParaEnviar.append("apellido", apellido);
    datosParaEnviar.append("telefono", telefono);
    datosParaEnviar.append("email", email);
    datosParaEnviar.append("password", password);
    datosParaEnviar.append("confirmpassword", confirm);
    datosParaEnviar.append("pregunta", pregunta);
    datosParaEnviar.append("respuesta", respuesta);

    // Envío de datos al controlador específico con la acción de registro
    fetch("../controlador/controller_usuarios.php?action=registrarNuevo", {
        method: "POST",
        body: datosParaEnviar
    })
    .then(res => res.text()) // Se espera una respuesta de texto plano desde el controlador
    .then(respuestaServidor => {
        // Validación de la respuesta personalizada enviada por el controlador PHP
        if (respuestaServidor.includes("registro_exitoso")) {
            mensaje.innerHTML = "<span style='color: green;'>¡Cuenta creada! Redirigiendo...</span>";
            // Temporizador para mejorar la experiencia de usuario (UX)
            setTimeout(() => {
                window.location.href = "login.php";
            }, 2000);
        } else {
            mensaje.innerHTML = "<span style='color: red;'>Error: " + respuestaServidor + "</span>";
        }
    })
    .catch(error => {
        console.error("Error:", error);
        mensaje.innerHTML = "Error de conexión con el servidor";
    });
}