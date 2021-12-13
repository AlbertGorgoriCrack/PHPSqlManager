<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hola</title>
</head>
<body>
    <style>
        #desplegable, #textArea {
            display: inline;
            vertical-align: middle;
        }
    </style>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <?php include './server.php';?>
        <textarea id="textarea" name="textarea" rows="10" cols="50"></textarea>
        <button value="submit" type="submit" name="submit">Enviar</button>
    </form>
</body>
</html>