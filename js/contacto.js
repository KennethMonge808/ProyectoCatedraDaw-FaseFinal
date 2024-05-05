document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        const inputs = form.querySelectorAll('input, textarea');

        for (let input of inputs) {
            if (!input.value.trim()) {
                alert("Por favor, llene todos los campos del formulario.");
                event.preventDefault(); 
                return;
            }
        }
    });
});
