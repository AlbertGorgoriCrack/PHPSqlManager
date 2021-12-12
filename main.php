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

    <?php include './server.php';?>

    <textarea id="textArea" name="textarea" rows="10" cols="50"></textarea>

    <button id="submit">Enviar</button>
</body>
</html>