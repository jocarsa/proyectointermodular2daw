var paquete = {};
// Cuando pulse el boton
document.querySelector("button").onclick = function(){
    // Recojo los datos del formulario
    paquete['nombre'] = document.querySelector("#nombre").value
    paquete['email'] = document.querySelector("#email").value
    paquete['telefono'] = document.querySelector("#telefono").value
    paquete['direccion'] = document.querySelector("#direccion").value
    // Los saco por pantalla
    console.log(paquete)
    // Y ahora los envío al servidor
    fetch("servidor.php", {
      method: "POST", 
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(paquete)
    })
}
