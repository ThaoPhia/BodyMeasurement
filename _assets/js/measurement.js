 function setMBSearchFilter(){
    var account_id=$("input[name=account_id]").val();
    var patient_id=$("select[name=patient_id]").val();
    var weight=$("input[name=weight]").val();
    var fat=$("input[name=fat]").val();
    var muscle=$("input[name=muscle]").val();
    var bmi=$("input[name=bmi]").val();
    var resting_kcal=$("input[name=resting_kcal]").val();
    var visceral_fat=$("input[name=visceral_fat]").val();
    var body_fat=$("input[name=body_fat]").val();  
    var data={account_id: account_id, patient_id: patient_id, weight: weight,   
        fat: fat, muscle: muscle, bmi: bmi, resting_kcal: resting_kcal, 
        visceral_fat: visceral_fat, body_fat: body_fat};
    return data;
}

$(document).ready(function(){ 
    $("#formWrapper").hide();
    $("#formWrapper").fadeIn(2000); 
    $("#viewMoreFilters").click(function(){
        $("#extraFilters").fadeToggle(1000);
    });   


    /* Colorbox resize function */
    var resizeTimer;
    function resizeColorBox(){
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if ($('#cboxOverlay').is(':visible')) {
                $.colorbox.load(true);
            }
        }, 300)
    } 
    // Resize Colorbox when resizing window or changing mobile device orientation
    $(window).resize(resizeColorBox);
    window.addEventListener("orientationchange", resizeColorBox, false); 
    
    $(document).delegate(".deleteConfirm2", "click", function(e){
        var r=confirm("Are you sure you want to delete?");
        if(r){ 
            var mId=$(this).attr("data-value");
            var ele = $(this).parent().parent(); 
             
            $.ajax({  
                type: "GET",  
                url: "call/delete-measurement",  
                data: {id: mId},  
                dataType: "html",  
                success: function(response){       
                    console.log(response);
                    ele.fadeOut(2000, function(){
                        $(this).remove();
                    });
                }   
            }).error(function (xhr, ajaxOptions, thrownError) {
                var errorMsg = "Status: " + xhr.status + "\n Error: " + thrownError;
                //errorMsg += "\n " + xhr.responseText; 
                alert(errorMsg);
            });
        }
    });
});  

(function(angular) {
    'use strict';

    var app = angular.module('appResultList', ['ngMessages']); 
    //Controller
    app.controller('ctlResultList', function($scope, $http, $timeout){ 
        //Variables
        $scope.measurements=null;

        //Functions 
        $scope.getMeasurements= function(){
            $scope.status='';
            //Call to server to get measurements  
            $http({
                method : "POST",
                url : "call/get-measurements", 
                data: setMBSearchFilter(),   
                headers : {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function mySuccess(response) { 
                $("#loading-area").show();
                if(response.data.length > 0){
                    //console.log(response.data[0].full_name);
                    $scope.measurements=response.data; 
                    $timeout(function() { 
                        $("#loading-area").fadeOut(500, function(){//Hide loading icon 
                            $(".result-list").fadeIn(2000); //Show result
                            $(".colorbox").colorbox({iframe:true, width:"80%", height:"80%"});
                        });   
                    }, 100);
                }else{
                    $scope.measurements=[]; 
                    $("#loading-area").fadeOut(500, function(){//Hide loading icon  

                    });  
                    $timeout(function() {
                        $scope.status='No measurements found!';
                    }, 500);
                }
            }, function myError(response) {
                console.log("Error...");
                console.log(response);
                $scope.loadingIcon = true; //Hide loading icon
            });                 
        } 
    });
})(window.angular); 