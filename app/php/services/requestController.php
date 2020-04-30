<?php
include "../connection.php";
include "dataAccessController.php";

function getSubCategoryController($inputData){
    $connection  = connect();
    /*$username = $inputData-> username;*/
    $category = $inputData-> category;
    $query = "SELECT * FROM `sub_categories` WHERE category_id = $category";
    $response = getData($connection, $query);
    /*$responseString = json_decode($response,true);
    $username = $inputData->operation;
    $JSONData = new stdClass();
    $JSONData->totalMarks = $username;
    echo json_encode($JSONData);*/
    
    echo $response;
    //echo "Image Is Empty";
}
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

function getAllBuyerRequestsController($inputData){
    $connection  = connect();
    $category = $inputData-> category;
    //$query = "SELECT * FROM `buyer_request` INNER JOIN `sub_categories` ON `buyer_request.sub_category_id`= `sub_categories.sub_category_id` WHERE sub_category_id = $subCategory ";
    $query = "SELECT * FROM `buyer_request` WHERE catagory_id = $category ";
    $response = getData($connection, $query);
    echo $response;
}

function searchBuyerRequestsController($inputData){
    $connection  = connect();
    $keyword = $inputData-> keyword;
    //$query = "SELECT * FROM `buyer_request` INNER JOIN `sub_categories` ON `buyer_request.sub_category_id`= `sub_categories.sub_category_id` WHERE sub_category_id = $subCategory ";
    $query = "SELECT * FROM `buyer_request` WHERE item_name LIKE '%$keyword%';";
    $response = getData($connection, $query);
    echo $response;
}

function getMyFarmerRequestsController($inputData){
    $connection  = connect();
    $userId = $inputData-> userId;
    //$query = "SELECT * FROM `buyer_request` INNER JOIN `sub_categories` ON `buyer_request.sub_category_id`= `sub_categories.sub_category_id` WHERE sub_category_id = $subCategory ";
    $query = "SELECT * FROM `farmer_request` WHERE buyer_id = $userId ";
    $response = getData($connection, $query);
    echo $response;

}

function getAllFarmerRequestsController($inputData){
    $connection  = connect();
    //$userId = $inputData-> userId;
    //$query = "SELECT * FROM `buyer_request` INNER JOIN `sub_categories` ON `buyer_request.sub_category_id`= `sub_categories.sub_category_id` WHERE sub_category_id = $subCategory ";
    $query = "SELECT * FROM `farmer_request`";
    $response = getData($connection, $query);
    echo $response;

}

function getOneFarmerRequestController($inputData){
    $connection  = connect();
    $farmerRequestId = $inputData-> farmerRequestId;
    //$query = "SELECT * FROM `buyer_request` INNER JOIN `sub_categories` ON `buyer_request.sub_category_id`= `sub_categories.sub_category_id` WHERE sub_category_id = $subCategory ";
    $query = "SELECT * FROM `farmer_request` WHERE 	farmer_request_id = $farmerRequestId ";
    $response = getData($connection, $query);
    echo $response;
}

function checkUsernameDuplicatesController($inputData){
    $connection  = connect();
    $username = $inputData->username;
    $password = $inputData->password;
    $stdPassword = md5($password);
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;
    $query = "SELECT user_name FROM user_details WHERE user_name = '$username'";
    $response = readData($connection, $query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
     //echo $responseString[0]['user_name'];
    // if($responseString[0]['user_name']==0){
    //     // registrationController($inputData);  
    // }else 
    if($responseString[0]['user_name'] == $username){
        $JSONData->duplicateData = true;
    }else if($responseString[0]['user_name'] != $username){
        $JSONData->duplicateData = false;
    }
    $JSONAConfirm = json_encode($JSONData);
    echo $JSONAConfirm;
}

/*Register the User*/
function registrationController($inputData){
    $connection  = connect();
    $username = $inputData->username;
    $password = $inputData->password;
    $stdPassword = md5($password);
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;
    $queryOne = "INSERT INTO user_details(user_name,first_name,last_name) VALUE ('$username','$firstName','$lastName')";
    $responseOne = writeData($connection,$queryOne);
    $JSONData = new stdClass();
    if($responseOne !== 0){
        $queryTwo = "INSERT INTO user_login(user_name,password) VALUE ('$username','$stdPassword')";
        $responseTwo = writeData($connection,$queryTwo);
        if($responseTwo == 1){
            $JSONData->successRegister = true;
        }else if($responseTwo == 0){
            $JSONData->successRegister = false;
        }
    }else{
        $JSONData->successRegister = false;
    }
    
    // if($responseOne !== 0){
    //     $queryTwo = "INSERT INTO user_login(user_name,password) VALUE ('$username','$stdPassword')";
    //     $responseTwo = writeData($connection,$queryTwo);
    //     if($responseTwo == 1){
    //         $JSONData->successRegister = true;
    //     }else if($responseTwo == 0){
    //         $JSONData->successRegister = false;
    //     }
    // }else{
    //     $JSONData->successSaveUserData = false;
    // }
    // if($responseOne === 0){
    //    $JSONData->successRegister = false;
    // }else{
       
    //     if($responseTwo === 0){
    //         $JSONData->successRegister = false;
    //     }else{
    //         //$queryThree = "INSERT INTO episode_one(user_name) VALUE ('$username')";
    //         writeData($connection,$queryThree);
    //         $JSONData->successRegister = true;
    //     }
    // }
    $JSONAConfirm = json_encode($JSONData);
    echo $JSONAConfirm;
}

//createFarmerRequestController
function createFarmerRequestController($inputData){
    //echo "Image Is Empty";
    $connection  = connect();
    $itemName = $inputData->itemName;
    $amount = $inputData->amount;
    $district = $inputData->district;
    $itemDiscription  = $inputData->itemDiscription;
    $buyerId  = $inputData->buyerId;
    $date = $inputData->date;
    /*$username = $inputData->username;
    $password = $inputData->password;
    $stdPassword = md5($password);
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;*/
    $queryOne = "INSERT INTO farmer_request(category_id,buyer_id,sub_category_id,item_name,amount,district,phone_number,item_description,date) VALUE ('1','$buyerId','1','$itemName',' $amount','$district','0770143367','$itemDiscription','$date') ";
    $responseOne = writeData($connection,$queryOne);
    $JSONData = new stdClass();
    if($responseOne !== 0){
        $JSONData->successRegister = true;
    }else{
        $JSONData->successRegister = false;
    }
    $JSONAConfirm = json_encode($JSONData);
    echo $JSONAConfirm;
}
//createbuyerRequestController
function createbuyerRequestController($inputData){
   
    //echo "ht022";
    $connection  = connect();
    $itemName = $inputData->itemName;
    $amount = $inputData->amount;
    $district = $inputData->district;
    $itemDiscription  = $inputData->itemDiscription;
    $buyerId  = $inputData->buyerId;
    $image = $inputData->image;
    $query = "INSERT INTO buyer_request(category_id, user_id, sub_category_name, image_name) VALUES ('$subCategoryId',$userId, '$subCategoryName','$image')";
    //$ext = pathinfo($_FILES['$image']['name'],PATHINFO_EXTENSION);
    //echo $ext;buyer_request
    if(!empty($_FILES{$image})){
        $response = "Image Is not Empty";
        $ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);

        //$inputData = json_decode(file_get_contents("php://input"));
        //$subCategoryName =$_POST['subCategoryName'] ;
        //$subCategoryId =$_POST['categoryId'] ;
        //$userId =$_POST['userId'] ;
        
        //$subCategoryName = $_POST["subCategoryName"];
        //$subCategoryId = $_POST["subCategoryId"];

        $connection  = connect();
        $image = time().'.'.$ext;
        move_uploaded_file($_FILES["image"]["tmp_name"], 'buyerRequestsImages/'.$image);
        $response = "Image uploaded successfully as ".$image;
        //$query = "INSERT INTO sub_categories (category_id, user_id, sub_category_name, image_name) VALUES ('$subCategoryId',$userId, '$subCategoryName','$image')";
        //$response = writeData($connection, $query);
	}else{
		$response = "Image Is Empty";
    }
    /*itemName:$scope.buyerRequestInfo.item_name,
            amount:$scope.buyerRequestInfo.amount,
            district: $scope.buyerRequestInfo.district,
            itemDiscription: $scope.buyerRequestInfo.discription,
            buyerId: $scope.buyerRequestInfo.buyerId,
            image:$scope.buyerRequestInfo.image*/
    /*$username = $inputData->username;
    $password = $inputData->password;
    $stdPassword = md5($password);
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;*/
    /*$queryOne = "INSERT INTO farmer_request(category_id,buyer_id,sub_category_id,item_name,amount,district,phone_number,item_description) VALUE ('1','$buyerId','1','$itemName',' $amount','$district','0770143367','$itemDiscription')";
    $responseOne = writeData($connection,$queryOne);
    $JSONData = new stdClass();
    if($responseOne !== 0){
        $JSONData->successRegister = true;
    }else{
        $JSONData->successRegister = false;
    }
    $JSONAConfirm = json_encode($JSONData);
    echo $JSONAConfirm;*/
}
/*Login the User*/
function loginController($inputData){
    $username = $inputData->username;
    $password = $inputData->password;
    $stdPassword = md5($password);
    $connection = connect();
    $query = "SELECT * FROM user_login ul inner join user_details ud on ul.user_name = ud.user_name WHERE ul.user_name='$username' AND password='$stdPassword'";
    $response = readData($connection, $query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($username === $responseString[0]['user_name'] && $stdPassword === $responseString[0]['password']){
        $milliseconds = round(microtime(true) * 1000);
        $token = $milliseconds . md5($username);

        $selectQuery = "SELECT user_name FROM token_verify WHERE user_name='$username'";
        $selectResponse = readData($connection, $selectQuery);
        $selectResponseString = json_decode($selectResponse ,true);

        if($selectResponseString && $selectResponseString[0]['user_name'] === $username){
            $insertQuery = "UPDATE token_verify SET token='$token' WHERE user_name='$username'";;
            $tokenResponse = writeData($connection, $insertQuery);
            if($tokenResponse === 0){
                $JSONData->token = false;
                $JSONData->username = false;
                $JSONData->userId = false;

            }else{
                $JSONData->token = $token;
                $JSONData->username = $responseString[0]['user_name'];
                $JSONData->userId = $responseString[0]['user_id'];
                $JSONData->role = $responseString[0]['role'];
            }
        }else{
            $insertQuery = "INSERT INTO token_verify(user_name,token) VALUE ('$username','$token')";
            $tokenResponse = writeData($connection, $insertQuery);
            if($tokenResponse === 0){
                $JSONData->token = false;
                $JSONData->username = false;
                $JSONData->userId = false;
            }else{
                $JSONData->token = $token;
                $JSONData->username = $responseString[0]['user_name'];
                $JSONData->userId = $responseString[0]['user_id'];
            }
        }
    }else{
        $JSONData->token = false;
        $JSONData->username = false;
    }
    $JSONArray = json_encode($JSONData);
    echo $JSONArray;
}

/*Change the Password*/
function changePasswordController($inputData){
    $connection = connect();
    $username = $inputData-> username;
    $newPassword = $inputData-> newPassword;
    $conPassword = md5($newPassword);
    $query = "SELECT user_name FROM user_login WHERE user_name='$username'";
    $response = readData($connection, $query);
    $responseString = json_decode($response, true);
    if($username === $responseString[0]['user_name']){
        $queryTwo = "UPDATE user_login SET password='$conPassword' WHERE user_name='$username'";
        $responseTwo = updateData($connection, $queryTwo);
        $JSONData = new stdClass();
        if($responseTwo === 0){
            $JSONData->password = false;
        }else{
            $JSONData->password = true;
        }
        $JSONArray = json_encode($JSONData);
        echo $JSONArray;
    }
}

/*logout the User*/
function logoutController($inputData){
    $token = $inputData->token;
    $connection = connect();
    $query = "DELETE FROM token_verify WHERE token='$token'";
    $response = deleteData($connection, $query);
    $responseString = json_encode($response, true);
    $JSONData = new stdClass();
    if($responseString === 0){
        $JSONData->logout = false;
    }else{
        $JSONData->logout = true;
    }
    $JSONArray = json_encode($JSONData);
    echo $JSONArray;
}

function deleteMyFarmerRequestsController($inputData){
    $farmerRequestId = $inputData->farmerRequestId ;
    $connection = connect();
    $query = "DELETE FROM 	farmer_request WHERE farmer_request_id='$farmerRequestId'";
    $response = deleteData($connection, $query);
    $responseString = json_encode($response, true);
    $JSONData = new stdClass();
    if($responseString === 0){
        $JSONData->deleteFarmerRequest = $response;
    }else{
        $JSONData->deleteFarmerRequest= $response;
    }
    $JSONArray = json_encode($JSONData);
    echo $JSONArray;
}



/*Verify All The Requests Before Do Them*/
function verifyController($inputData){
    $username = $inputData->username;
    $token = $inputData->token;
    $connection = connect();
    $query = "SELECT * FROM token_verify WHERE user_name='$username' AND token='$token'";
    $response = readData($connection, $query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($username === $responseString[0]['user_name'] && $token === $responseString[0]['token']){
        $JSONData->isVerified = 'true';
        return json_encode($JSONData);
    }else{
        $JSONData->isVerified = 'false';
        return json_encode($JSONData);
    }
}

/*Add Marks of Activities*/
function addMarksController($inputData){
    $connection = connect();
    $username = $inputData-> username;
    $totalMarks = $inputData-> totalMarks;
    $activityNo = $inputData-> activity;
    $query = null;
    if($activityNo === 'activity_one'){
        $query = "UPDATE episode_one SET ".$activityNo."='$totalMarks' WHERE user_name='$username'";
    }
    $response = updateData($connection, $query);
    $JSONData = new stdClass();
    if($response === 0){
        $JSONData->totalMarksSuccess = false;
    }else{
        $JSONData->totalMarksSuccess = true;
    }
    $JSONArray = json_encode($JSONData);
    echo $JSONArray;
}

/*Select Marks Of Activities*/
function selectMarksController($inputData){
    $connection  = connect();
    $username = $inputData-> username;
    $query = "SELECT activity_one FROM episodeone WHERE user_name='$username'";
    $response = readData($connection, $query);
    $responseString = json_decode($response,true);
    $JSONData = new stdClass();
    $JSONData->totalMarks = $responseString[0]['activity_one'];
    echo json_encode($JSONData);
}

/**
 * Check whether user details in activity five has already added.
 */
function checkForAvailableDataController($inputData){
    $connection = connect();
    $userId = $inputData->userId;
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;
    $gender = $inputData->gender;
    $device = $inputData->device;
    $ageRange= $inputData->age;
    $nic = $inputData->nic;
    $education = $inputData->education;
    $occupation = $inputData->job;

    $query = "SELECT * FROM user_form_details where user_details_id = '$userId'";
    $response = readData($connection,$query);
    $JSONData = new stdClass();
    if($response != null){
        $JSONData->isAvailable = true;
    }else{
        $JSONData->isAvailable = false;
    }

    echo json_encode($JSONData);
}

function updateUserDetailsController($inputData){
    $connection = connect();
    $userId = $inputData->userId;
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;
    $gender = $inputData->gender;
    $device = $inputData->device;
    $ageRange= $inputData->age;
    $nic = $inputData->nic;
    $education = $inputData->education;
    $occupation = $inputData->job;
    $query = "UPDATE user_feedback SET answer = '$qAnswer' WHERE user_id = '$userId' AND question_id = '$qId'";

    $query = "UPDATE user_form_details SET first_name = '$firstName', 
    last_name = '$lastName', gender = '$gender', equipment = '$device', age_range = '$ageRange', 
    nic = '$nic', education = '$education', occupation = '$occupation' where user_details_id = '$userId'";

    $response = writeData($connection,$query);
    $JSONData = new stdClass();
    if($response != 0){
        $JSONData->isSuccess = true;
    }else if($response == 0){
        $JSONData->isSuccess = false;
    }

    echo json_encode($JSONData);
}

/*Submit User Details*/
function submitUserDetailsController($inputData){
    $connection = connect();
    $userId = $inputData->userId;
    $firstName = $inputData->firstName;
    $lastName = $inputData->lastName;
    $gender = $inputData->gender;
    $device = $inputData->device;
    $ageRange= $inputData->age;
    $nic = $inputData->nic;
    $education = $inputData->education;
    $occupation = $inputData->job;

    $query = "INSERT INTO `user_form_details`( user_details_id, first_name, last_name, gender, equipment, age_range, nic, education, occupation) VALUES 
('$userId','$firstName','$lastName','$gender','$device','$ageRange','$nic','$education','$occupation')";

    $response = writeData($connection,$query);
    $JSONData = new stdClass();
    if($response === 0){
        $JSONData->addingSuccess = false;
    }else{
        $JSONData->addingSuccess = true;
    }
    $JSONArray = json_encode($JSONData);
    echo $JSONArray;
}

/*Submit Feedback*/
function submitFeedbackController($inputData){;
    $connection = connect();
    $userId = $inputData-> userId;
    $questionList = $inputData-> questions;

    $JSONData = new stdClass();
    $JSONData-> success = true;

    foreach ($questionList as $q){
        insertOrUpdateFeedbackController($q, $userId, $connection);
    }

    echo json_encode($JSONData);
}

/*Call from submitFeedbackController Function*/
function insertOrUpdateFeedbackController($q, $userId, $connection){
    $qId =  $q->questionId;
    $qAnswer = $q->value;
    $query = "SELECT * from user_feedback where user_id = '$userId' AND question_id = '$qId'";

    $response = readData($connection, $query);
    $responseString = json_decode($response, true);

    if(count($responseString) > 0) { // already answered
        $query = "UPDATE user_feedback SET answer = '$qAnswer' WHERE user_id = '$userId' AND question_id = '$qId'";

    } else { // add new item
        $query = "INSERT INTO user_feedback (user_id, question_id, answer) VALUES ('$userId', '$qId', '$qAnswer')";
    }

    $response = writeData($connection,$query);
    return $response;
}

function submitEpisodeTwoFeedbackController($inputData){
    $connection = connect();
    $username = $inputData-> username;
    $questionList = $inputData-> questions;
    $JSONData = new stdClass();
    $questionone = $questionList[0]->value;
    $questiontwo = $questionList[1]->value;
    $questionthree = $questionList[2]->value;
    $questionfour = $questionList[3]->value;
    $questionfive = $questionList[4]->value;
    $questionsix = $questionList[5]->value;

    $response = insertOrUpdateEpisodeTwoFeedbackController($questionone,$questiontwo,$questionthree,$questionfour,$questionfive,$questionsix, $username, $connection);
    if($response == 1){
        $JSONData->success = true;
    }
    else if($response == 0){
        $JSONData->success = false;
    }
    echo json_encode($JSONData);
}

/*Call from submitFeedbackController Function*/
function insertOrUpdateEpisodeTwoFeedbackController($questionone,$questiontwo,$questionthree,$questionfour,$questionfive,$questionsix, $username, $connection){
    $connection  = connect();
    $query = "SELECT * from episodetwo_feedback where username = '$username'";
    $response = readData($connection, $query);
    $responseString = json_decode($response, true);
    if(count($responseString) > 0) { // already answered
        $query = "UPDATE episodetwo_feedback SET questionone = '$questionone', questiontwo = '$questiontwo', 
        questionthree = '$questionthree',questionfour = '$questionfour', 
        questionfive = '$questionfive', questionsix ='$questionsix' WHERE username= '$username'";

    } else { // add new item
        $query = "INSERT INTO episodetwo_feedback (username, questionone, questiontwo, questionthree, questionfour, questionfive, questionsix) 
        VALUES ('$username', '$questionone', '$questiontwo','$questionthree','$questionfour','$questionfive','$questionsix')";
    }
    $response = writeData($connection,$query);
    return $response;
}

function saveEpisodeThreeActivityOneMarksController($inputData){
    $connection  = connect();
    $questionMarks = $inputData->marks;
    $username = $inputData->username;
    $query = "SELECT * FROM episodethree WHERE username='$username'";
    $response = writeData($connection,$query);
    if($response == 1){
        //update
        $queryOne = "UPDATE episodethree SET activityonemarks = '$questionMarks' WHERE username = '$username'";
        $response = writeData($connection,$queryOne);
    }else if($response== 0){
        //insert
        $queryOne = "INSERT INTO episodethree(username,activityonemarks) VALUE ('$username','$questionMarks')";
        $response = writeData($connection,$queryOne);
    }
    // $response = writeData($connection,$queryOne);
    $responseString = json_decode($response, true);
}

function saveEpisodeTwoMarksController($inputData){
    $connection  = connect();
    $questionMarks = $inputData->marks;
    $username = $inputData->username;
    $activity = $inputData->activity;
    $query = "SELECT * FROM episodetwo WHERE username='$username'";
    $response = writeData($connection,$query);
    //TODO- After implementing restricting doing activities once it is done select query should be removed and if activity one insertion and if activity two update.

    if($response == 1){
        //update
        if($activity == 2){
            $querytwo = "UPDATE episodetwo SET activitytwomarks = '$questionMarks' WHERE username = '$username'";
        }
        else if($activity == 1){
            //TODO- Remove this part as after disabling watching twice this wont needed
            $querytwo = "UPDATE episodetwo SET activityonemarks = '$questionMarks', activitytwomarks = '0' WHERE username = '$username'";
        }
        $response = writeData($connection,$querytwo);

    }else if($response== 0){
        //insert
        $queryOne = "INSERT INTO episodetwo(username,activityonemarks) VALUE ('$username','$questionMarks')";
        $response = writeData($connection,$queryOne);
    }
    $JSONData = new stdClass();
    if($response == 1){
        $JSONData->success = true;
    }else{
        $JSONData->success = false;
    }
    echo json_encode($JSONData);
}

/**
 * Gets the marks of the activities
 * Returns secondOne true if the first activity is done.
 * So that when a user goes to the episode he can resume from where he left.
 */
function getEpisodeTwoDataController($inputData){
    $connection  = connect();
    $username = $inputData->username;
    $query = "SELECT activityonemarks,activitytwomarks FROM episodetwo WHERE username = '$username' ";
    $response = getData($connection,$query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($response !== null){
        if($responseString[0]['activityonemarks'] > 0 && $responseString[0]['activitytwomarks'] == 0){
            $JSONData->secondOne = true;
        }else{
            $JSONData->secondOne = false;
        }
    }else{
        $JSONData->secondOne = false;
    }
    echo json_encode($JSONData);
}

/**
 * Gets the marks of the episode two activities for 
 * learning objective page
 */
function getEpisodeTwoMarksController($inputData){
    $connection  = connect();
    $username = $inputData->username;
    $query = "SELECT activityonemarks,activitytwomarks FROM episodetwo WHERE username = '$username'";
    $response = getData($connection,$query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($response !== null){
        $JSONData->activityOneMarks = $responseString[0]['activityonemarks'];
        $JSONData->activityTwoMarks = $responseString[0]['activitytwomarks'];
    }else{
        $JSONData->activityOneMarks = 0;
        $JSONData->activityTwoMarks = 0;
    }
    echo json_encode($JSONData);
}

/**
 * Gets the episode three marks 
 * for learning objective page.
 */
function getEpisodeThreeMarksController($inputData){
    $connection  = connect();
    $username = $inputData->username;
    $query = "SELECT activityonemarks FROM episodethree WHERE username = '$username' ";
    $response = getData($connection,$query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($response !== null){
        $JSONData->activityOneMarks = $responseString[0]['activityonemarks'];
    }else{
        $JSONData->activityOneMarks = 0;
    }
    echo json_encode($JSONData);
}

function submitEpisodeThreeFeedbackController ($inputData){
    $connection = connect();
    $username = $inputData-> username;
    $questionList = $inputData-> questions;
    $JSONData = new stdClass();
    $questionone = $questionList[0]->value;
    $questiontwo = $questionList[1]->value;
    $questionthree = $questionList[2]->value;
    $questionfour = $questionList[3]->value;
    $questionfive = $questionList[4]->value;
    $questionsix = $questionList[5]->value;

    $response = insertOrUpdateEpisodeThreeFeedbackController($questionone,$questiontwo,$questionthree,$questionfour,$questionfive,$questionsix, $username, $connection);
    if($response == 1){
        $JSONData->success = true;
    }
    else if($response == 0){
        $JSONData->success = false;
    }
    echo json_encode($JSONData);
}

function insertOrUpdateEpisodeThreeFeedbackController($questionone,$questiontwo,$questionthree,$questionfour,$questionfive,$questionsix, $username, $connection){
    $query = "SELECT * from episodethree_feedback where username = '$username'";
    $response = readData($connection, $query);
    $responseString = json_decode($response, true);

    if(count($responseString) > 0) { // already answered
        $query = "UPDATE episodethree_feedback SET questionone = '$questionone', questiontwo = '$questiontwo', 
        questionthree = '$questionthree',questionfour = '$questionfour', 
        questionfive = '$questionfive', questionsix ='$questionsix' WHERE username= '$username'";

    } else { // add new item
        $query = "INSERT INTO episodethree_feedback (username, questionone, questiontwo, questionthree, questionfour, questionfive, questionsix) 
        VALUES ('$username', '$questionone', '$questiontwo','$questionthree','$questionfour','$questionfive','$questionsix')";
    }
    $response = writeData($connection,$query);
    return $response;
}

function saveEpisodeMarksController($inputData){
    $connection  = connect();
    $questionMarks = $inputData->marks;
    $username = $inputData->username;
    $episode = $inputData->episode;
    $activityName = $inputData->activity;
    $query = "SELECT * FROM `$episode` WHERE username='$username'";
    $response = readData($connection,$query);
    $responseString = json_decode($response, true);
    if(count($responseString)==1){
        $querytwo = "UPDATE $episode SET $activityName = '$questionMarks' WHERE username = '$username'";
    }else if(count($responseString) == 0){
        $querytwo = "INSERT INTO $episode (username,$activityName) VALUE ('$username','$questionMarks')";
    }
    //echo writeData($connection,$querytwo);
    $responseTwo = writeData($connection,$querytwo);
    $JSONData = new stdClass();
    if($responseTwo == 1){
        $JSONData->success = true;
    }else if($responseTwo == 0){
        $JSONData->success = false;
    }
    echo json_encode($JSONData);
}

function getMarks($inputData){
    //echo'step one ok';
    //echo'ss';
    $connection  = connect();
    $username = $inputData->username;
    $episode = $inputData->episode;
    while($episode>0){
        quary($episode,$connection,$username);
        $episode = $episode-1;
    }
    //echo json_encode($JSONData);
   /* $query = "SELECT activityonemarks FROM episodethree WHERE username = '$username' ";
    $response = getData($connection,$query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($response !== null){
        $JSONData->activityOneMarks = $responseString[0]['activityonemarks'];
    }else{
        $JSONData->activityOneMarks = 0;
    }
    echo json_encode($JSONData);*/
}
function quary($episode,$connection,$username){
    switch($episode){
        case 1:
        $query = "SELECT * FROM episodeone WHERE user_name = '$username'";
        //echo 'one set';
        break;
        case 2:
        $query = "SELECT * FROM episodetwo WHERE username = '$username'";
        break;
    }
    //$query = "SELECT * FROM '$episode' WHERE username = '$username' ";
    $response = getData($connection,$query);
    $responseString = json_decode($response, true);
    $JSONData = new stdClass();
    if($response !== null){
        switch($episode){
            case 1:
            $JSONData->activityOneMarks = $response;
            //$JSONData->activityTwoMarks = $responseString[1]['activity_one'];
            echo json_encode($JSONData);
            break;
            case 2:
            $JSONData->episodeTwo = $response;
            //echo json_encode($JSONData);
            break;
        }
        // $JSONData->$episode.activityOneMarks = $response.data;
        /*$JSONData->activityTwoMarks = $responseString[1]['activity_two'];
        $JSONData->activityThreeMarks = $responseString[2]['activity_three'];
        $JSONData->activityFourMarks = $responseString[3]['activity_four'];*/
       
    }else{
        $JSONData->activityOneMarks = 0;
    }
    //echo json_encode($JSONData);
}
