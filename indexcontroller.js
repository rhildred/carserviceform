angular.module("myApp", []).controller("myCtrl", function ($scope, $http) {
  $scope.model = {};  
  $scope.model.service = atts.service;
  $scope.model.services = [];
    $scope.addService = function(){
      if($scope.addservice && $scope.addservice != ""){
        $scope.model.services.push({"name":$scope.addservice});
        $scope.servicemessage="";        
      }else{
        $scope.servicemessage="please enter an extra service before clicking";
      }
      $scope.addservice = "";
    }
    $scope.submitForm = function(){
      //alert(JSON.stringify($scope.model));
      $http.post("/slim/api/appointment", $scope.model).then(
        function(data){
          alert(JSON.stringify(data.data));

        }, function(err){
          alert(JSON.stringify(err));
        });
    }
  });
