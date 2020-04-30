app.config(function($stateProvider, $urlRouterProvider){
    $urlRouterProvider.otherwise('/viewItems');
        $stateProvider
        .state('viewItems',{
            url:'/viewItems',
            controller:'viewItemsCtrl',
            templateUrl:'views/viewItems.html'
    })
        
});