document.addEventListener("DOMContentLoaded", function () {
    const formularios_ajax = document.querySelectorAll(".FormularioAjax");

    formularios_ajax.forEach(formulario => {
        formulario.addEventListener("submit", function (e) {
            e.preventDefault();

            let data = new FormData(this);
            let method = this.getAttribute("method");
            let action = this.getAttribute("action");

            let encabezados = new Headers();

            let config = {
                method: method,
                headers: encabezados,
                mode: 'cors',
                cache: 'no-cache',
                referrerPolicy: 'origin',
                body: data
            };

            fetch(action, config)
                .then(respuesta => respuesta.text())
                .then(respuesta => {
                    let contenedor = document.querySelector(".form-rest");
                    contenedor.innerHTML = respuesta;
                });
        });
    });
});
