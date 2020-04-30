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
            //echo "vegitable sub catogory";
            break;
        case 'getOneItem':
            getOneItemController($inputData);
            break;
        case 'getAllBuyerRequests':
            getAllBuyerRequestsController($inputData);
            break;
        case 'searchBuyerRequest':
            searchBuyerRequestsController($inputData);
            break; 
        case 'getMyFarmerRequests':
            getMyFarmerRequestsController($inputData);
            break;
        case 'getOneFarmerRequest':
            getOneFarmerRequestController($inputData);
            break;
        case 'getAllFarmerRequests':
            getAllFarmerRequestsController($inputData);
            break;
        case 'getBuyerRequestData':
            getBuyerRequestDataController($inputData);
            break;
       
        default:
            echo 'Invalid request 002';
    }
}


