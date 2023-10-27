<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./css/bulma.min.css">
  <link rel="stylesheet" href="./css/chat.css">

</head>

<body>

  <section class="section columns is-centered">

    <div class="column is-half is-centered">
      <div class="is-centered">
          <table class="table is-bordered is-hidden-mobile is-fullwidth">
              <thead>
              <tr>
                  <th colspan="2" class="has-text-centered"> Chats </p> </th>
              </tr>
              <tr>
                  <th class="has-text-centered"> Nombre </th>
                  <th class="has-text-centered"> <!-- Vacio --> </th>
              </tr>
              </thead>
              <tbody>
              <tr>
              <td class="has-text-centered">
              <div class="box has-text-centered">
                  <span class="has-text-weight-bold"> "Nombre" </span>
              </div>
              <div class="box has-text-centered">
                  <span class="has-text-weight-bold"> "Nombre" </span>
              </div>
              <div class="box has-text-centered">
                  <span class="has-text-weight-bold"> "Nombre" </span>
              </div>
              </td>

              <td class="has-text-centered">
              <div class="box has-text-centered">
                  <span class="has-text-weight-bold"> "Foto de perfil" </span>
              </div>
              <div class="box has-text-centered">
                  <span class="has-text-weight-bold"> "Foto de perfil" </span>
              </div>
              <div class="box has-text-centered">
                  <span class="has-text-weight-bold"> "Foto de perfil" </span>
              </div>
              </td>

              <tr class="has-text-centered" >
            <td colspan="1">
                <a href="#" class="button is-dark is-rounded is-small mt-3 mb-3"> Anterior </a>
                
            </td>
            <td colspan="1">
                <a href="#" class="button is-dark is-rounded is-small mt-3 mb-3"> Siguiente </a>
            </td>
          </tr>
            </tbody>
        </table>
        <div class="mt-6">
          <p class="has-text-centered">
            <a href="javascript:history.back()" class="boton_izquierda button is-link is-rounded">Salir</a>
          </p>
        </div>
      </div>
    </div>


     <div class="column is-centered">
        <div class="is-half margen_chat">
          <div class="box chat-box caja">
            <div class="chat-message">
            <h1 class="has-text-centered"> "Conversación de prueba" </h1>
            
              <div class="message is-info">
                <div class="message-body texto_contenedor">
                    <div class="four-fifths">
                    <span class="mensaje"> Estudiante: </span> Buen día, queria consultar sobre el ultimo tema </div>
                    <div class="one-fifth mt-2"> <p> 10:30 </p> </div>
                </div>
              </div>
            </div>

            <div class="chat-message">
              <div class="message is-success">
                <div class="message-body texto_contenedor">
                    <div class="four-fifths">
                    <span class="mensaje"> Docente: </span> Hola que tal, si dime </div>
                    <div class="one-fifth mt-2"> <p> 10:34 </p> </div>
                </div>
              </div>
            </div>

            <div class="chat-message">
              <div class="message is-info">
                <div class="message-body texto_contenedor">
                    <div class="four-fifths">
                      <span class="mensaje"> Estudiante: </span> No encuentro el repartido de funciones </div>
                      <div class="one-fifth mt-2"> <p> 10:36 </p> </div>
                </div>
              </div>
            </div>

            <div class="chat-message">
              <div class="message is-success has-text-white">
                <div class="message-body texto_contenedor">
                    <div class="four-fifths">
                    <span class="mensaje"> Docente: </span> Ah, me olvide de subirlo, ahora lo envío </div>
                    <div class="one-fifth mt-2"> <p> 10:37 </p> </div>
                </div>
              </div>
            </div>

            <div class="chat-message">
              <div class="message is-info">
                <div class="message-body texto_contenedor">
                    <div class="four-fifths">
                    <span class="mensaje"> Estudiante: </span> Ok, gracias! </div>
                    <div class="one-fifth mt-2"> <p> 10:37 </p> </div>
                </div>
              </div>
            </div>

            <div class="chat-message">
              <div class="message is-success has-text-white">
                <div class="message-body texto_contenedor">
                    <div class="four-fifths">
                    <span class="mensaje"> Docente: </span> Ya se encuentra en la carpeta Repartidos </div>
                    <div class="one-fifth mt-2"> <p> 10:49 </p> </div>
                </div>
              </div>
            </div>
          </div>

          <div class="field caja">
            <div class="control">
              <textarea class="textarea" placeholder="Escribe tu mensaje"></textarea>
            </div>
          </div>

          <div class="field">
            <div class="control">
              <button class="button is-primary boton">Enviar</button>
            </div>
          </div>
        </div>
    </div>
    
    
  </section>


</body>
</html>