document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    fetchMedicamentos();
});

// Función para cargar los medicamentos desde la base de datos
function fetchMedicamentos() {
    var tbody = document.getElementById('tbody-rows');
    tbody.innerHTML = ''; // Limpiar contenido previo

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/listar_medicamentos.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var medicamentos = JSON.parse(xhr.responseText);
            medicamentos.forEach(function(medicamento) {
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${medicamento.nombre}</td>
                    <td>${medicamento.dosis}</td>
                    <td>${medicamento.horario}</td>
                    <td>${medicamento.duracion_dias}</td>
                    <td>${medicamento.fecha_inicio}</td>
                    <td>${medicamento.fecha_fin}</td>
                    <td class="actions-column">
                        <a onclick="openUpdate(${medicamento.id})" class="btn-floating waves-effect teal tooltipped" data-tooltip="Editar">
                            <i class="material-icons">edit</i>
                        </a>
                        <a onclick="deleteMedicamento(${medicamento.id})" class="btn-floating waves-effect red tooltipped" data-tooltip="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                `;
                tbody.appendChild(tr);

                // Calcular la duración en días
                var fechaInicio = new Date(medicamento.fecha_inicio);
                var fechaFin = new Date(medicamento.fecha_fin);
                var duracionEnMs = fechaFin.getTime() - fechaInicio.getTime();
                var duracionEnDias = duracionEnMs / (1000 * 60 * 60 * 24);
                tr.children[3].textContent = duracionEnDias; // Actualizar la celda de duración
            });
        }
    };
    xhr.send();
}

// Función para abrir el modal de creación
function openCreate() {
    document.getElementById('modal-title').textContent = 'Crear Medicamento';
    document.getElementById('id').value = ''; // Limpiar ID
    M.Modal.getInstance(document.getElementById('save-modal')).open();
}

// Función para abrir el modal de actualización
function openUpdate(id) {
    document.getElementById('modal-title').textContent = 'Editar Medicamento';
    document.getElementById('id').value = id; // Establecer ID
    M.Modal.getInstance(document.getElementById('save-modal')).open();

    // Obtener datos del medicamento con el ID dado
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/obtener_medicamento.php?id=" + id, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var medicamento = JSON.parse(xhr.responseText);
            // Llenar el formulario con los datos del medicamento
            document.getElementById('nombre').value = medicamento.nombre;
            document.getElementById('dosis').value = medicamento.dosis;
            document.getElementById('horario').value = medicamento.horario;
            document.getElementById('duracion').value = medicamento.duracion_dias;
            document.getElementById('fecha_inicio').value = medicamento.fecha_inicio;
            document.getElementById('fecha_fin').value = medicamento.fecha_fin;
        }
    };
    xhr.send();
}

// Función para eliminar un medicamento
function deleteMedicamento(id) {
    var confirmDelete = confirm('¿Estás seguro de eliminar este medicamento?');
    if (confirmDelete) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "api/guardar_medicamento.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    fetchMedicamentos(); // Actualizar la tabla después de eliminar
                } else {
                    alert('Error al eliminar el medicamento: ' + response.error);
                }
            }
        };
        xhr.send("action=delete&id=" + id);
    }
}

// Función para manejar el envío del formulario de creación o actualización
document.getElementById("save-form").addEventListener("submit", function(event) {
    event.preventDefault();

    var id = document.getElementById('id').value;
    var nombre = document.getElementById('nombre').value;
    var dosis = document.getElementById('dosis').value;
    var horario = document.getElementById('horario').value;
    var duracion = document.getElementById('duracion').value;
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;

    // Validar que la duración sea un número positivo
    if (parseInt(duracion) < 0) {
        alert('La duración no puede ser un número negativo.');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api/guardar_medicamento.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                M.Modal.getInstance(document.getElementById('save-modal')).close(); // Cerrar modal después de guardar
                fetchMedicamentos(); // Actualizar la tabla después de guardar
                alert('El medicamento se ha modificado correctamente.'); // Mensaje de éxito
            } else {
                alert('Error al guardar el medicamento: ' + response.error);
            }
        }
    };
    var params = "action=" + (id ? "update" : "create") + "&id=" + id + "&nombre=" + encodeURIComponent(nombre) + "&dosis=" + encodeURIComponent(dosis) + "&horario=" + encodeURIComponent(horario) + "&duracion=" + encodeURIComponent(duracion) + "&fecha_inicio=" + encodeURIComponent(fecha_inicio) + "&fecha_fin=" + encodeURIComponent(fecha_fin);
    xhr.send(params);
});

// Función para reiniciar el formulario
document.getElementById("reset-btn").addEventListener("click", function() {
    document.getElementById("save-form").reset();
});

document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    fetchHistorial();
});
