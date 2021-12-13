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
        echo $textArea;
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

            while ($row = mysqli_fetch_assoc($result)) {
                array_push($tablasColumnas, $row);
            }

            $arrayAssoc = count($tablasColumnas);

            echo $arrayAssoc;

            for ($i = 0; $i < $arrayAssoc; $i++) {
                $keysArray = array_keys($tablasColumnas[$i]);
                print_r($keysArray);
            }

            $arrayIndex = count($tablasReg);
            for ($i = 0; $i < $arrayIndex; $i++) {
                // array_keys($tablasReg[$i]);
                $indexReg = count($tablasReg[$i]);
                // echo "<br> <br> <br> <br>";
                // $arrayColumnas = $tablasReg[$i];
                // $keysArray = array_keys($tablasReg[$i]);
                // print_r($arrayColumnas);
                // print_r($keysArray);
                // echo $keysArray[0];
                for ($j = 0; $j < $indexReg; $j++) {
                    echo $tablasReg[$i][$j];
                    echo "<br>";
                }
                // for ($j = 0; $j < $indexReg; $j++) {
                //     echo "<br> <br> <br>";
                //     if ($tablasReg[$i][$j]) {
                //         echo $tablasReg[$i][$j];
                //     }
                // }

                echo "<br> <br> <br>";
            }
        } else {
            echo "Error: " . $db->getConnection()->error;
        }
    }
}
