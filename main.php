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
        textarea, button, #desplegable{
            display: block;
            margin: auto;
        }

        button, .getResult{
            text-align: center;
        }

        .getResult{
            background-color: #B5FFA0;
            color: #336724;
            position: absolute;
            top:12%;
            padding: 1em;
            border-radius: 1em;
            width: 20%;
        }

        .getBadResult{
            background-color: #FF9898;
            color: #9D0000;
            position: absolute;
            top:12%;
            padding: 1em;
            border-radius: 1em;
            width: 20%;
        }

        button{
            position: absolute;
            top: 15%;
            right: 49%;
        }

        .showData{
            position: absolute;
            top:20%;
            text-align: center;
            margin: auto;
        }
        
        #textArea{
            position: absolute;
            top:1%;
            right: 10%;
        }

        th{
            background-color: #AFC9F6;
        }

        td{
            background-color: #90CDFE;
        }

    </style>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <?php include './server.php';?>
        <textarea id="textArea" name="textarea" rows="8" cols="50"></textarea>
        <button value="submit" type="submit" name="submit">Enviar</button>
    </form>
    
</body>
</html>