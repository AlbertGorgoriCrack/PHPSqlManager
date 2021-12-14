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
        *{
            font-family: "Dosis", sans-serif;
        }

        body{
            background-color: #E9EBF2;
        }
        textarea, button, #desplegable, .displaySearch{
            display: block;
            margin: auto;
        }

        button, .displaySearch, .getResult{
            text-align: center;
        }

        .getResult{
            background-color: #B5FFA0;
            color: #336724;
            margin: auto;
            padding: 1em;
            border-radius: 1em;
            width: 20%;
        }

        .displaySearch{
            margin: 1em;
        }

        table{
            text-align: center;
            margin: auto;
        }

        th{
            background-color: #AFC9F6;
        }

        td{
            background-color: #90CDFE;
        }

    </style>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <textarea id="textarea" name="textarea" rows="10" cols="50"></textarea>
        <button value="submit" type="submit" name="submit">Enviar</button>
    </form>
    <?php include './server.php';?>
</body>
</html>