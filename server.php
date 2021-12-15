<?php

require_once './DatabaseConnection/database.php';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$db = Database::getInstance();

$result = $db->setDatabaseISc();

$tables = array();
if (!$result->num_rows) {
    echo 'No Rows Returned From Pivot Query';
} else {
    while ($row = mysqli_fetch_array($result)) {
        array_push($tables, $row['schema_name']);
    }
}
$arrayCount = count($tables);
$charToEvaluate = '/';
for ($i = 1; $i < $arrayCount; $i++) {
    if (strpos($tables[$i], $charToEvaluate)) {
        $unicas = explode("/", $tables[$i]);
        $tables[$i] = $unicas[0];
    }
}
$final = array();
$final = array_unique($tables);
echo '<select id="desplegable" name="desplegableOption">';
foreach ($final as $name) {
    echo  '<option value="' . $name . '" > ' . $name . '</option>';
}
echo '</select>';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['textarea'])) {
        $valor1Err = 'Empty value';
    } else {
        $textArea = $_POST['textarea'];
        $valor1Err = '';
    }

    if (empty($_POST['desplegableOption'])) {
        $valor2Err = 'Empty value';
    } else {
        $optionSelected = $_POST['desplegableOption'];
        $valor2Err = '';
    }

    $operation = explode(" ", $textArea)[0];

    if ($valor1Err === '' && $valor2Err === '') {
        $newdb = Database::getInstance();
        $checkHistory = Database::getInstance();
        $injectHistroy = Database::getInstance();

        $result = $newdb->setNewQuery($textArea, $optionSelected);

        //Aqui creamos la tabla SQL History si no existe

        $checkQuery = "SELECT * FROM SqlHistory";

        $resultCheck = $checkHistory->setNewQuery($checkQuery, $optionSelected);

        if ($resultCheck) {
            $historial = array();
            while ($row = mysqli_fetch_assoc($resultCheck)) {
                array_push($historial, $row);
            }
            if ($historial) {
                echo '<table>';

                echo '<tr>';
                foreach ($historial[0] as $columna => $fila) {
                    echo '<th> ' . $columna . '</th>';
                }
                echo '</tr>';

                foreach ($historial as $registros) {
                    echo '<tr>';
                    foreach ($registros as $columna => $fila) {
                        echo '<td> ' . $fila . '</td>';
                    }
                    echo '</tr>';
                }
                echo "</table>";
            }
        } else {
            $dbCreate = Database::getInstance();
            $createTable = "CREATE TABLE IF NOT EXISTS sqlhistory (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                sentence VARCHAR(500) NOT NULL,
                executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )";

            $dbCreate->setNewQuery($createTable, $optionSelected);
        }

        if ($operation === 'SELECT') {
            if ($result) {
                // var_dump($result);
                $tablasReg = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($tablasReg, $row);
                }
                //Cabecera provisional, substituir por el array con las cabeceras

                echo '<div class="getResult"> Se ha encontrado una coincidencia! </div>';

                echo '<table class="showData">';

                echo '<tr>';
                foreach ($tablasReg[0] as $columna => $fila) {
                    echo '<th> ' . $columna . '</th>';
                }
                echo '</tr>';

                foreach ($tablasReg as $registros) {
                    echo '<tr>';
                    foreach ($registros as $columna => $fila) {
                        echo '<td> ' . $fila . '</td>';
                    }
                    echo '</tr>';
                }
                echo "</table>";
                $date = date("Y-m-d H:i:s");
                $newHistorial = "INSERT INTO sqlhistory (sentence, executed_at) 
                VALUES ('$textArea', '$date')";
                $resultInject = $injectHistroy->setNewQuery($newHistorial, $optionSelected);
            } else {
                echo '<div class="getBadResult">' . $newdb->getConnection()->error . '</div>';
            }
        } elseif ($operation === 'UPDATE' || $operation === 'DELETE' || $operation === 'INSERT') {
            if ($result) {
                $date = date("Y-m-d H:i:s");
                echo '<div class="getResult"> El ' . $operation . ' se ha producido correctamente</div>';
                $newHistorial = "INSERT INTO sqlhistory (sentence, executed_at) 
                VALUES ('$textArea', '$date')";
                $injectHistroy->setNewQuery($newHistorial, $optionSelected);
            } else {
                echo '<div class="getBadResult">' . $newdb->getConnection()->error . '</div>';
            }
        } else {
            echo '<div class="getBadResult"> Your query is not correct!!! </div>';
        }
    }
}
