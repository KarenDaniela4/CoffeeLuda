document.addEventListener("DOMContentLoaded", () => {

  const productos = [
    { id: 1, nombre: "Espresso", precio: 7000 },
    { id: 2, nombre: "Capuccino", precio: 9000 },
    { id: 3, nombre: "Latte", precio: 8000 }
  ];

  const contenedor = document.getElementById("productos");

  if (!contenedor) return;

  const imagenes = {
    "Espresso": "espresso.jpg",
    "Capuccino": "capuccino.jpg",
    "Latte": "latte.jpg"
  };

  productos.forEach(p => {
    contenedor.innerHTML += `
      <div class="card">
        <img src="images/${imagenes[p.nombre]}" alt="${p.nombre}">
        <h3>${p.nombre}</h3>
        <p>$${p.precio}</p>
        <button class="btn" onclick="agregar(${p.id})">
          Agregar al carrito
        </button>
      </div>
    `;
  });

  mostrarAuth();
});

function agregar(id) {

  const productos = [
    { id: 1, nombre: "Espresso", precio: 7000 },
    { id: 2, nombre: "Capuccino", precio: 9000 },
    { id: 3, nombre: "Latte", precio: 8000 }
  ];

  const producto = productos.find(p => p.id == id);

  let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

  carrito.push(producto);

  localStorage.setItem("carrito", JSON.stringify(carrito));

  alert("Producto agregado 🛒");
}

function mostrarAuth() {
  const authDiv = document.getElementById("auth");

  if (!authDiv) return;

  const token = localStorage.getItem("token");

  if (token) {
    authDiv.innerHTML = `
      <span style="color:white;">👤 Usuario</span>
      <button onclick="logout()">Salir</button>
    `;
  } else {
      
   
  }
}

function logout() {
  localStorage.removeItem("token");
  location.reload();
}