<?php
include "../connection.php";
include "dataAccessController.php";

function getItemsController($inputData){
    $connection  = connect();
    /*$username = $inputData-> username;subCategory*/
    //$category = $inputData-> category;
    //$subCategory = $inputData-> subCategory;
    //$buyerRequestId = 1;
    $query = "SELECT * FROM `items`";
    $response = getData($connection, $query);
    echo $response;
}

function getOneItemController($inputData){
    $connection  = connect();
    $itemtId = $inputData-> itemId;
    $query = "SELECT * FROM items WHERE id = '$itemtId' ";
    $response = getData($connection, $query);
    echo $response;
}


