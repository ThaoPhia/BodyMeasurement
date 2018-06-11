<div ng-app="appResultList" ng-controller="ctlResultList" >
    <div id="loading-area" style="text-align:center;">
        <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
    </div>
    <div class="result-list" style="max-width: 500px;" ng-repeat="p in patients" >
        <div class="rl-row">
            <span class="options">
                 <a href="#" class="dummyLink"><i class="fa fa-pencil"></i></a>
                  <a href="#" class="dummyLink"><i class="fa fa-trash"></i></a>
            </span>
            {{p.full_name}}, {{p.gender}}, {{p.age}}
        </div> 
    </div>
    <center>{{status}}</center>
</div>




<script> 
    (function(angular) {
        'use strict';
        
        var app = angular.module('appResultList', ['ngMessages']); 
        //Controller
        app.controller('ctlResultList', function($scope, $http, $timeout){ 
            //Variables
            $scope.patients=null;
            
            //Call to server to get patients 
            $http({
                method : "POST",
                url : "call/get-patients", 
                data: {aid: <?= user("id")?>},  //Assign account ID here
                headers : {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function mySuccess(response) { 
                $("#loading-area").show();
                if(response.data.length > 0){
                    //console.log(response.data[0].full_name);
                    $scope.patients=response.data; 
                    $timeout(function() { 
                        $("#loading-area").fadeOut(500, function(){//Hide loading icon 
                            $(".result-list").fadeIn(2000); //Show result
                        });   
                    }, 100);
                }else{
                    $("#loading-area").fadeOut(500);     //Hide loading icon  
                    $timeout(function() { 
                        $scope.status='No patients found!';   
                    }, 700);                    
                }
            }, function myError(response) {
                console.log("Error...");
                console.log(response);
                $scope.loadingIcon = true; //Hide loading icon
            }); 
        });
    })(window.angular); 
</script>