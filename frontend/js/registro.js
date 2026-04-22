function registro() {
    const mensaje = document.getElementById("mensaje");
    
    const id = document.getElementById("id").value;
    const nombre = document.getElementById("nombre").value;
    const apellido = document.getElementById("apellido").value;
    const telefono = document.getElementById("telefono").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const confirm = document.getElementById("confirmPassword").value;
    const pregunta = document.getElementById("pregunta").value;
    const respuesta = document.getElementById("respuesta").value;

    if (!email || !password || !id) {
        mensaje.innerHTML = "<span style='color: red;'>ID, Email y Password son obligatorios</span>";
        return;
    }

    if (password !== confirm) {
        mensaje.innerHTML = "<span style='color: red;'>Las contraseñas no coinciden</span>";
        return;
    }

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

    fetch("../controlador/controller_usuarios.php?action=registrarNuevo", {
        method: "POST",
        body: datosParaEnviar
    })
    .then(res => res.text())
    .then(respuestaServidor => {
        if (respuestaServidor.includes("registro_exitoso")) {
            mensaje.innerHTML = "<span style='color: green;'>¡Cuenta creada! Redirigiendo...</span>";
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