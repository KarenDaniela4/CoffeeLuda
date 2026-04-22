// Al cargar la página, recuperamos el pedido desde sessionStorage
const pedidoPendiente = JSON.parse(sessionStorage.getItem("pedidoPendiente"));

// Si no hay pedido pendiente, regresamos al carrito
if (!pedidoPendiente || !pedidoPendiente.items || pedidoPendiente.items.length === 0) {
    alert("No hay ningún pedido pendiente. Vuelve al carrito.");
    window.location.href = "carrito.php";
}

// Resumen del pedido
const contenedorItems = document.getElementById("resumen-items");
pedidoPendiente.items.forEach(item => {
    contenedorItems.innerHTML += `
        <div class="item-resumen">
            <span>${item.nombre} × ${item.cantidad}</span>
            <span>$${item.subtotal.toLocaleString()}</span>
        </div>
    `;
});
document.getElementById("resumen-total").innerText = "$" + pedidoPendiente.total.toLocaleString();

// Alternar campos según el método de pago
const radios = document.querySelectorAll('input[name="metodo"]');
const camposTarjeta = document.getElementById("campos-tarjeta");
const mensajeEfectivo = document.getElementById("mensaje-efectivo");

function actualizarMetodo() {
    const metodo = document.querySelector('input[name="metodo"]:checked').value;
    if (metodo === "tarjeta") {
        camposTarjeta.style.display = "block";
        mensajeEfectivo.style.display = "none";
    } else {
        camposTarjeta.style.display = "none";
        mensajeEfectivo.style.display = "block";
    }
}
radios.forEach(r => r.addEventListener("change", actualizarMetodo));
actualizarMetodo();

// Formato automático del número de tarjeta (agrega espacios cada 4 dígitos)
document.getElementById("numero").addEventListener("input", function(e) {
    let valor = e.target.value.replace(/\s/g, "").replace(/\D/g, "");
    e.target.value = valor.replace(/(.{4})/g, "$1 ").trim();
});

// Formato de vencimiento MM/AA
document.getElementById("vencimiento").addEventListener("input", function(e) {
    let valor = e.target.value.replace(/\D/g, "");
    if (valor.length >= 3) {
            valor = valor.slice(0, 2) + "/" + valor.slice(2, 4);
    }
    e.target.value = valor;
});

// CVV solo números
document.getElementById("cvv").addEventListener("input", function(e) {
    e.target.value = e.target.value.replace(/\D/g, "");
});

function validarDatosTarjeta() {
    const titular = document.getElementById("titular").value.trim();
    const numero = document.getElementById("numero").value.replace(/\s/g, "");
    const vencimiento = document.getElementById("vencimiento").value;
    const cvv = document.getElementById("cvv").value;

    if (titular.length < 3) {
        alert("Ingresa el nombre del titular.");
        return false;
    }
    if (numero.length < 13 || numero.length > 19) {
        alert("El número de tarjeta no es válido.");
        return false;
    }
    if (!/^\d{2}\/\d{2}$/.test(vencimiento)) {
        alert("El vencimiento debe tener el formato MM/AA.");
        return false;
    }
    if (cvv.length < 3) {
        alert("El CVV debe tener 3 o 4 dígitos.");
        return false;
    }
    return true;
}

function confirmarPago() {
    const metodo = document.querySelector('input[name="metodo"]:checked').value;

    if (metodo === "tarjeta" && !validarDatosTarjeta()) {
        return;
    }

    const btn = document.getElementById("btn-confirmar");
    btn.disabled = true;
    btn.innerText = "Procesando...";

    // Enviamos el carrito al controlador para que lo guarde en BD
    const datosParaEnviar = pedidoPendiente.items.map(p => ({
        id: p.id,
        cantidad: p.cantidad,
        precio: p.precio
    }));

    fetch("../controlador/controller_procesar_compra.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ carrito: datosParaEnviar })
    })
    .then(respuesta => respuesta.text().then(texto => {
        try {
            return JSON.parse(texto);
        } catch (e) {
            console.error("Respuesta no es JSON:", texto);
            throw new Error("El servidor respondió algo inesperado.");
        }
    }))
    .then(datos => {
        if (datos.status === "ok") {
            // Guardamos info para la pantalla de confirmación
            sessionStorage.setItem("ultimaCompra", JSON.stringify({
                total: pedidoPendiente.total,
                items: pedidoPendiente.items,
                metodo: metodo,
                fecha: new Date().toLocaleString("es-CO")
            }));

            // Limpiamos carrito y pedido pendiente
            localStorage.removeItem("carrito");
            sessionStorage.removeItem("pedidoPendiente");

            // Vamos a la pantalla de confirmación
            window.location.href = "confirmacion.php";
        } else {
            alert("Hubo un problema: " + datos.mensaje);
            btn.disabled = false;
            btn.innerText = "Confirmar pago";
        }
    })
    .catch(error => {
        console.error("Error en el fetch:", error);
        alert("Error: " + error.message);
        btn.disabled = false;
        btn.innerText = "Confirmar pago";
    });
}