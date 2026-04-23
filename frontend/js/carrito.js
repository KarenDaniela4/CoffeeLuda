// Recuperación y procesamiento del carrito almacenado
let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

const contenedor = document.getElementById("carrito");
let total = 0;

// Agrupar productos
let agrupados = {};

carrito.forEach(p => {
  if (agrupados[p.id]) {
    agrupados[p.id].cantidad++;
  } else {
    agrupados[p.id] = {
      ...p,
      cantidad: 1
    };
  }
});

// Mostrar productos
const imagenes = {
    "Espresso": "espresso.jpg",
    "Capuccino": "capuccino.jpg",
    "Latte": "latte.jpg"
};

// Mostrar productos
for (let id in agrupados) {
    let p = agrupados[id];

    const rutaImagen = p.nombre in imagenes ? `images/${imagenes[p.nombre]}` : "images/logo.png";

    contenedor.innerHTML += `
    <div class="item">
      
      <img src="${rutaImagen}" alt="${p.nombre}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">

      <div class="info">
        <h3>${p.nombre}</h3>
        <p class="precio">$${p.precio}</p>

        <div class="cantidad">
          <button onclick="restar(${p.id})">➖</button>
          <span>${p.cantidad}</span>
          <button onclick="sumar(${p.id})">➕</button>
        </div>
      </div>

      <div class="acciones">
        <button onclick="eliminar(${p.id})">❌</button>
      </div>

    </div>
  `;

    total += p.precio * p.cantidad;
}

document.getElementById("total").innerText = "Total: $" + total;

// FUNCIONES
function guardar(carrito){
  localStorage.setItem("carrito", JSON.stringify(carrito));
  location.reload();
}

function sumar(id){
  let producto = carrito.find(p => p.id == id);
  carrito.push(producto);
  guardar(carrito);
}

function restar(id){
  let index = carrito.findIndex(p => p.id == id);
  if(index !== -1){
    carrito.splice(index, 1);
  }
  guardar(carrito);
}

function eliminar(id){
  carrito = carrito.filter(p => p.id != id);
  guardar(carrito);
}

function vaciar(){
  localStorage.removeItem("carrito");
  location.reload();
}

function comprar() {
    if (carrito.length === 0) {
        alert("Tu carrito está vacío, añade un delicioso café primero.");
        return;
    }

    // datos para la pantalla de pago
    const datosPedido = {
        items: Object.values(agrupados).map(p => ({
            id: p.id,
            nombre: p.nombre,
            cantidad: p.cantidad,
            precio: p.precio,
            subtotal: p.precio * p.cantidad
        })),
        total: total
    };

    // Almacenamiento temporal en SessionStorage para el checkout
    sessionStorage.setItem("pedidoPendiente", JSON.stringify(datosPedido));

    // Redirigimos a la pantalla de pago
    window.location.href = "pago.php";
}