<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Subir Archivo </title>

    <link rel="stylesheet" href="../css/bulma.min.css">
    <link rel="stylesheet" href="../css/multimedia.css">

    <script src="../js/subir_archivo.js"></script>
</head>

<body>

    <?php include "../inc/navbar.php" ?>

    <section class="section">
        <div class="container">
            <div class="columns">

                <div class="column is-one-quarter margn">
                <h1 class="title"> Subir Archivo </h1>
                <h2 class="subtitle"> Seleccionar tipo </h2>
                <div class="field">
                
                    <div class="control mt-2">
                        <div class="select">
                            <select onchange="mostrarTipoSeleccionado(this)">
                                <option> No seleccionado </option>
                                <option> Textos </option>
                                <option> Imágenes </option>
                                <option> Audios </option>
                                <option> Videos </option>
                                <option> Otros </option>
                            </select>
                        </div>
                    </div>
                </div>
                
                </div>
                <div class="column">
                <table class="table is-bordered is-hidden-mobile is-fullwidth">
                    <thead>
                    <tr>
                        <th colspan="3" class="has-text-centered"> <p id="tipoSeleccionado"> Seleccione un tipo de archivo </p> </th>
                    </tr>
                    <tr>
                        <th class="has-text-centered"> Nombre </th>
                        <th class="has-text-centered"> Vista previa </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="has-text-centered">
                        <div class="box has-text-centered contenedor_caja">
                            <span class="has-text-weight-bold"> "Nombre" </span>
                        </div>
                        </td>

                        <td class="has-text-centered">
                        <div class="box has-text-centered contenedor_caja">
                            <span class="has-text-weight-bold"> "Archivo" </span>
                        </div>
                        </td>

                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="column bajar_archivo_descripcion">
                <table class="table is-bordered is-hidden-mobile is-fullwidth">
                    <thead>
                    <tr>
                        <th colspan="2"> <p class="ml-5"> Descripción </p> </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="has-text-centered">
                        <div class="box contenedor_caja">
                            <br> <br>
                            <span class="has-text-weight-bold"> "Descripcion del archivo" </span>
                            <br> <br> <br>
                        </div>

                    </tr>
                    </tbody>
                </table>
                </div>

    <div class="columns">
        <div class="column">
            <a href="javascript:history.back()" class="button is-dark is-rounded ajustar_boton_salir"> Salir </a>
        </div>
        <div class="column">
            <a href="../upload/archivo_subido.php" class="is-pulled-left button is-primary is-rounded ajustar_boton_subir"> Subir </a>
        </div>
    </div>

    </section>

</body>
</html>