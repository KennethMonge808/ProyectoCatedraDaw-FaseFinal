function mostrarDescripcion(numeroEstudiante) {
    var descripcion = document.querySelectorAll('.descripcion');
    descripcion.forEach(function(elem, index) {
      if (index + 1 === numeroEstudiante) {
        elem.style.display = 'block';
      }
    });
  }

  function ocultarDescripcion() {
    var descripcion = document.querySelectorAll('.descripcion');
    descripcion.forEach(function(elem) {
      elem.style.display = 'none';
    });
  }