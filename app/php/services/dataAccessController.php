<?php
function readData($connection, $query){
    $result = $connection->query($query) or die($connection->error);
    $rows = array();
    while($tuple = $result->fetch_assoc()){
        $rows[] = $tuple;
    }
    return json_encode($rows);
}
function getData($connection, $query){
    $result = $connection->query($query) or die($connection->error);
    $rows = array();
    while($tuple = $result->fetch_assoc()){
        $rows[] = $tuple;
    }
    $rowCount = mysqli_affected_rows($connection);
    return json_encode($rows);
}
function writeData($connection, $query){
    $result = $connection->query($query) or die($connection->error);
    $rowCount = mysqli_affected_rows($connection);
    return $rowCount;
}
function deleteData($connection, $query){
    $result = $connection->query($query) or die($connection->error);
    $rowCount = mysqli_affected_rows($connection);
    return $rowCount;
}
function updateData($connection, $query){
    $result = $connection->query($query) or die($connection->error);
    $rowCount = mysqli_affected_rows($connection);
    return $rowCount;
}

