angular.module("myApp", []).controller("myCtrl", function ($scope) {
  $scope.model = {};  
  $scope.model.service = atts.service;
  $scope.model.services = [];
    $scope.addService = function(){
      $scope.model.services.push({"name":$scope.addservice});
      $scope.addservice = "";
    }
    $scope.submitForm = function(){
      alert(JSON.stringify($scope.model));
    }
  });
