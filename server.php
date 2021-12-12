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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT `NAME` FROM `INNODB_SYS_TABLES`";
}

$result = $db->getConnection()->query($sql);

$tables = array();


if (!$result->num_rows) {
    echo 'No Rows Returned From Pivot Query';
} else {
    // echo '<table>';
    //     echo '<tr><th>Names</th></tr>';
    while ($row = mysqli_fetch_array($result)) {
        ;
        array_push($tables, $row['NAME']);
    }
}

//Exclusivas

$arrayCount = count($tables);
$charToEvaluate = '/';

for ($i = 1; $i < $arrayCount; $i++) {
    if (strpos($tables[$i], $charToEvaluate)) {
        $unicas = explode("/", $tables[$i]);
        $tables[$i] = $unicas[0];
    }
}

//Imprimir array entera
foreach ($tables as $name) {
    echo $name . "<br>";
}

// foreach ($tables as $name) {
//     echo $name . "<br>";
// }
