document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    fetchHistorial();
});

// Función para cargar el historial de medicamentos desde la base de datos
function fetchHistorial() {
    var tbody = document.getElementById('tbody-rows');
    tbody.innerHTML = ''; // Limpiar contenido previo

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/listar_historial.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var historial = JSON.parse(xhr.responseText);
            var fechaActual = new Date();
            historial.forEach(function(registro) {
                var fechaFin = new Date(registro.fecha_fin);
                // Obtener la fecha de finalización del medicamento
                var fechaFin = new Date(registro.fecha_fin);
                // Verificar si la fecha de finalización es anterior a la fecha actual
                if (fechaFin < fechaActual) {
                    // Si la fecha de finalización ha pasado, ocultar el medicamento
                    return;
                }
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${registro.nombre}</td>
                    <td>${registro.dosis}</td>
                    <td>${registro.fecha_inicio}</td>
                    <td>${registro.fecha_fin}</td>
                    <td>
                        <button class="btn waves-effect waves-light red" onclick="ocultarMedicamento(${registro.id}, this)">Ocultar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    };
    xhr.send();
}

// Función para ocultar un medicamento del historial
function ocultarMedicamento(id, button) {
    var confirmOcultar = confirm('¿Estás seguro de ocultar este medicamento del historial?');
    if (confirmOcultar) {
        // Ocultar el elemento tr que contiene el medicamento
        var tr = button.closest('tr');
        tr.style.display = 'none';
    }
}
