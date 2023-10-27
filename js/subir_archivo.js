function mostrarInformacion(selectElement) {
    var tipoSeleccionado = selectElement.value;
    var tipoSeleccionadoElement = document.getElementById("tipoSeleccionado");
    var tipoArchivoElement = document.getElementById("tipoArchivo");
    var inputElement = document.querySelector('input[name="formulario_archivo"]');

    if (tipoSeleccionado == "Imágenes") {
        tipoSeleccionadoElement.textContent = "Imágenes";
        tipoArchivoElement.textContent = "JPG, GIF, PNG (MAX 10MB)";
        inputElement.accept = ".jpg, .gif, .png, .jpeg";

    } else if (tipoSeleccionado == "Textos") {
        tipoSeleccionadoElement.textContent = "Textos";
        tipoArchivoElement.textContent = "DOC, PDF, PPT (MAX 10MB)";
        inputElement.accept = ".doc, .pdf, .ppt";

    } else if (tipoSeleccionado == "Audios") {
        tipoSeleccionadoElement.textContent = "Audios";
        tipoArchivoElement.textContent = "MP3, WAV, FLAC (MAX 10MB)";
        inputElement.accept = ".mp3, .wav, .flac";

    } else if (tipoSeleccionado == "Videos") {
        tipoSeleccionadoElement.textContent = "Videos";
        tipoArchivoElement.textContent = "MP4, AVI, FLV (MAX 10MB)";
        inputElement.accept = ".mp4, .avi, .flv";
        
    }
}


document.addEventListener("DOMContentLoaded", function() {
    const toggleEditorButton = document.getElementById("toggleEditorButton");
    const editorContainer = document.getElementById("editor-container");
    const quill = new Quill("#editor", {
        theme: "snow",
        modules: {
            toolbar: {
                container: [
                    // Primera fila
                    [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
                    [{ 'align': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['blockquote', 'code-block'],
                ],                
            }
        }
    });

    quill.clipboard.dangerouslyPasteHTML(0, '<p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p>');
    quill.setSelection(0, 0);

    // Capturar el contenido de Quill al enviar el formulario
    const form = document.querySelector(".FormularioAjax");
    form.addEventListener("submit", function(event) {
        // Obtener el contenido HTML del editor Quill
        const quillContent = quill.root.innerHTML;
        // Almacenar el contenido en el campo oculto
        document.getElementById("quillContent").value = quillContent;
        // El formulario se enviará con el contenido de Quill
    });
});
