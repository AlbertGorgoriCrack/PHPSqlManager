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
    while ($row = mysqli_fetch_array($result)) {
        ;
        array_push($tables, $row['NAME']);
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

echo '<select id="desplegable">';

foreach ($final as $name) {
    echo  '<option value="' . $name . '" > ' . $name . '</option>';
}

echo '</select>';
