<?php

session_start();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

$DB_HOST = '127.0.0.1';
$DB_USER = '';
$DB_PASS = '';
$DB_NAME = '';
$DB_PORT = '3306';

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

// Check connection
if ($mysqli->connect_errno) {
    //echo "Failed to connect to MySQL: "; /* . $mysqli->connect_error */

    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS);
    // Check connection
    if (!$conn) {
        die("<br>Connection failed: " . mysqli_connect_error());
    }
    mysqli_close($conn);
    exit();
}

// Table Name
$table = 'templates';
$columns = '';
$columns_array = [];
$datatype_array = [];

$sql = "SHOW FULL COLUMNS FROM $table";
$result = $mysqli->query($sql);
if (!empty($result->num_rows)) {
    while($row = $result->fetch_assoc()){
        if($row['Field'] != 'uuid' && $row['Extra'] != 'VIRTUAL GENERATED'){
            // echo "<pre>";
            // print_r($row['Field']);
            if(empty($columns)){
                $columns .= $row['Field'];
            } else {
                $columns .= ','.$row['Field'];
            }
            $columns_array[] = $row['Field'];
            $datatype_array[$row['Field']] = $row['Type'];
            // echo "</pre>";
        }
    }
}

echo "<pre>";
echo "Table : $table <br>";
print_r($columns_array);
echo "</pre>";

$insert_sql = "INSERT INTO $table ($columns) VALUES";

$sql = "SELECT $columns from $table";
echo "<pre>";
echo $sql;
echo "</pre>";
$result1 = $mysqli->query($sql);
if (!empty($result1->num_rows)) {
    while ($row = $result1->fetch_assoc()) {
        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
        foreach($columns_array as $key=>$val){
            if($key == 0){
                // $insert_sql .= '("'.$row[$val].'"';
                $insert_sql .= PHP_EOL."('".addslashes($row[$val])."'";
            } else {
                if($val == "additional_fields"){                    
                    if(empty($row[$val])){
                        $insert_sql .= ",'{}'";
                    } else {
                        $insert_sql .= ",'".addslashes($row[$val])."'";
                    }
                } else {                                        
                    if($datatype_array[$val] == "int unsigned" || $datatype_array[$val] == "int" || strpos($datatype_array[$val], 'int') !== false){
                        if(empty($row[$val])){
                            $insert_sql .= ",0";
                        } else {
                            $insert_sql .= ",".addslashes($row[$val])."";    
                        }
                    } else if(strpos($datatype_array[$val], 'decimal') !== false){
                        if(empty($row[$val])){
                            $insert_sql .= ",0.00";
                        } else {
                            $insert_sql .= ",".addslashes($row[$val])."";    
                        }
                    } else if($datatype_array[$val] == "timestamp"){
                        if(empty($row[$val])){
                            $insert_sql .= ",NULL";
                        } else {
                            $insert_sql .= ",'".addslashes($row[$val])."'";
                        }
                    } else {
                        $insert_sql .= ",'".addslashes($row[$val])."'";
                    }                    
                }
            }
        }
        $insert_sql .= '), ';
    }
    $insert_sql = rtrim($insert_sql, ", ");
    // $insert_sql = $insert_sql;
}

$insert_sql .= ";";

// $insert_sql = mysqli_real_escape_string($mysqli, $insert_sql);

// echo $insert_sql;


file_put_contents("./$table.sql",$insert_sql);


