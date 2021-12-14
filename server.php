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

        $result = $newdb->setNewQuery($textArea, $optionSelected);

        $createTable = "CREATE TABLE IF NOT EXISTS SqlHistory (
                id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                sentence VARCHAR(500) NOT NULL,
                executed_at DATETIME DEFAULT CURRENT_TIMESTAMP
                )";

        $newdb->setNewQuery()($createTable, $optionSelected);

        if ($operation === 'SELECT') {
            if ($result) {
                // var_dump($result);
                $tablasReg = array();
                $tablasColumnas = array();

                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($tablasReg, $row);
                }
                //Cabecera provisional, substituir por el array con las cabeceras
                $titles = array();

                echo '<div class="getResult"> Se ha encontrado una coincidencia! </div>';

                echo '<table>';

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
            } else {
                echo '<div class="getBadResult">' . $db->getConnection()->error . '</div>';
            }
        } elseif ($operation === 'UPDATE' || $operation === 'DELETE' || $operation === 'INSERT') {
            if ($result) {
                echo '<div class="getResult"> El ' . $operation . ' se ha producido correctamente</div>';
            } else {
                echo '<div class="getBadResult">' . $db->getConnection()->error . '</div>';
            }
        } else {
            echo '<div class="getBadResult"> Your query is not correct!!! </div>';
        }
    }
}
