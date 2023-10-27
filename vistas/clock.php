<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, inicial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title> Reloj </title>
    <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel="stylesheet">
    
</head>

<body class="reloj_body">
    <div class="wrap">
        <div class="widget">
            <div class="fecha">
                <p id="diaSemana" class="diaSemana parrafo"></p>
                <p id="dia" class="dias parrafo"></p>
                <p>de </p>
                <p id="mes" class="mes parrafo"></p>
                <p>del </p>
                <p id="year" class="year parrafo"></p>
            </div>

            <div class="reloj">
                <p id="horas" class="horas parrafo"></p>
                <p>:</p>
                <p id="minutos" class="minutos parrafo"></p>
                <p>:</p>
                <div class="caja-segundos">
                    <p id="ampm" class="ampm parrafo"></p>
                    <p id="segundos" class="segundos parrafo"></p>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/reloj.js"></script>
</body>
</html>