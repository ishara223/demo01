
app.controller("viewItemsCtrl", function($scope, $state, $rootScope, $http){
    $scope.itemName = '';
    $scope.items = {};
    $scope.showItemInfo = false;
    $scope.getItems = function (){
        var inputData = {
            requestType: '0',
            operation: 'getItems',
            /*category:categoryId,
            subCategory:subCategoryId*/
        };
        $http({
            method: 'post',
            url: 'app/php/services/requestHandler.php',
            data: inputData,
            //headers: {'Content-Type': 'multipart/form-data'}
        }).then(function successCallBack(response){
            $scope.items = response.data;
                //$scope.kamal = angular.fromJson($scope.user);  
            $scope.itemName = $scope.items[0].name;
        })
    }

    $scope.getItem = function(itemId){
        //$scope.createBuyerRequest = true;
        //$scope.createFrmerRequestForm = false;
        //$scope.editFarmerRequestForm = true;
        var inputData = {
            requestType: '0',
            operation: 'getOneItem',
            itemId:itemId
        };
        $http({
            method: 'post',
            url: 'app/php/services/requestHandler.php',
            data: inputData,
            //headers: {'Content-Type': 'multipart/form-data'}
        }).then(function successCallBack(response){
            $scope.itemInfo = response.data[0];
            $scope.showItemInfo = true;  
        })
    }
});