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

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $sql = "SELECT `NAME` FROM `INNODB_SYS_TABLES`";
// } else {
//     $sql = false;
// }


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
        echo '<br><div class="displaySearch">' . $textArea . '</div><br>';
        $valor1Err = '';
    }

    if (empty($_POST['desplegableOption'])) {
        $valor2Err = 'Empty value';
    } else {
        $optionSelected = $_POST['desplegableOption'];
        $valor2Err = '';
    }

    if ($valor1Err === '' && $valor2Err === '') {
        $newdb = Database::getInstance();

        $result = $newdb->setNewQuery($textArea, $optionSelected);
        if ($result) {
            // var_dump($result);
            $tablasReg = array();
            $tablasColumnas = array();

            while ($row = mysqli_fetch_row($result)) {
                array_push($tablasReg, $row);
            }

            // foreach ($tablasReg as $name) {
            //     for ($i = 1; $i <= 10; $i++) {
            //         echo array_keys($name[$i]);
            //     }
            // }

            // while ($secondRow = mysqli_fetch_assoc($result)) {
            //     echo"Al fin he entrado<br>";
            //     array_push($tablasColumnas, $secondRow);
            // }

            //https://stackoverflow.com/questions/11084445/php-mysql-get-table-headers-function
            // $post = mysqli_fetch_assoc($result);
            // foreach($post as $title => $value){
            //     echo"Al fin he entrado<br>";
            //     $tablasColumnas[] = $title;
            // }

            $arrayAssoc = count($tablasColumnas);

            echo $arrayAssoc . '<br>';

            for ($i = 0; $i < $arrayAssoc; $i++) {
                $keysArray = array_keys($tablasColumnas[$i]);
                print_r($keysArray);
            }

            $arrayIndex = count($tablasReg);

            //Cabecera provisional, substituir por el array con las cabeceras
            $titles = array("ID", "Sabor de helado", "Nombre", "Orientacion", "Saludo");

            echo '<div class="getResult"> Se ha encontrado una coincidencia! </div>';

            echo '<table>';

            echo '<tr>';
            foreach ($titles as $showTitle) {
                echo '<th> ' . $showTitle . '</th>';
            }
            echo '</tr>';

            for ($i = 0; $i < $arrayIndex; $i++) {

                $indexReg = count($tablasReg[$i]);
                echo '<tr>';
                for ($j = 0; $j < $indexReg; $j++) {
                    echo '<td> ' . $tablasReg[$i][$j] . '</td>';
                }
                echo "</tr><br>";
            
            }
            echo "</table>";

        } else {
            echo "Error: " . $db->getConnection()->error;
        }
    }
}
