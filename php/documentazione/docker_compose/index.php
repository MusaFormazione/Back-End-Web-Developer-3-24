<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TestPage</title>
</head>
<body style="background-color: #ffeeff">
    <?="Hello World!"?>

    <?php

    echo getenv('DB_HOST_PATH');

    # MICRO-SERVIZI
    # SE IO PUNTO UN ALTRO CONTAINER (UN ALTRO SERVIZIO) ... USO IL NOME DEL SERVIZIO PIU' LA PORTA
    # database:3306

    # SE VOGLIO PUNTARE AD UN DATABASE CHE SI TROVA NEL HOST, DAL CONTAINER
    # host.docker.internal:3306

    ?>

</body>
</html>