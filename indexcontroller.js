angular.module("myApp", []).controller("myCtrl", function ($scope) {
    $scope.service = atts.service;
    $scope.calculate = function(){
      if($scope.score >= 55){
        $scope.message = "you passed!"
      }else{
        $scope.message = "you failed";
      }
    }
  });
