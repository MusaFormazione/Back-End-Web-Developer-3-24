<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TestPage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="index">
    <?="Hello World Session!"?>

    <?php
    echo getenv('DB_HOST_PATH');
    $_SESSION['test'] = 'test';
    ?>

    <h2>Sakila Database Demo</h2>
    <p>This is a simple PHP implementation that uses the Sakila database.</p>
    
    <ul>
        <li><a href="actors.php">View and Edit Actors</a></li>
    </ul>

    <h3>Database Connection Notes:</h3>
    <p>
        <strong>For connecting to a database in another container:</strong><br>
        Use the service name plus port: <code>database:3306</code>
    </p>
    <p>
        <strong>For connecting to a database on the host machine:</strong><br>
        Use: <code>host.docker.internal:3306</code>
    </p>

<pre>

</pre>

</body>
</html>