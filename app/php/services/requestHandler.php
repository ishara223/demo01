<?php
include "requestController.php";

$inputData = json_decode(file_get_contents("php://input"));
$requestType = $inputData->requestType;

/**
 * Initially client request hits here.
 * Will direct request to the correct request handler based on the
 * request type.
 * 0 -> Read data
 * 1 -> Write data
 * 2 -> Delete data
 * 3 -> Update data
 */
switch($requestType){
    case '0':
        readRequestHandler($inputData);
        break;
    case '1':
        writeRequestHandler($inputData);
        break;
    case '2':
        deleteRequestHandler($inputData);
        break;
    case '3':
        updateRequestHandler($inputData);
        break;
    default:
        echo 'Invalid request 001';
}

function readRequestHandler($inputData){
    $operation = $inputData->operation;

    switch($operation){
        case 'Login':
            loginController($inputData);
            break;
        case 'getItems':
            getItemsController($inputData);
           
            break;
        default:
            echo 'Invalid request 002';
    }
}


