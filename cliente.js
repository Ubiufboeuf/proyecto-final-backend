// cliente.js o en Astro del lado del cliente
const socket = new WebSocket("ws://localhost:8080");

socket.onopen = () => {
  console.log("Conectado al servidor WebSocket");
};

socket.onmessage = (event) => {
  console.log("Mensaje recibido:", event.data);
};

socket.onclose = () => {
  console.log("Conexión cerrada");
};

socket.onerror = (error) => {
  console.error("Error en WebSocket:", error);
};

// Enviar mensaje cada segundo
setInterval(() => {
  if (socket.readyState === WebSocket.OPEN) {
    socket.send("Hola desde el cliente");
  }
}, 1000);
