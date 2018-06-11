<div id="formWrapper" style="max-width: 350px; margin:auto;">
    <?=$error?'<p class="error">'. $error .'</p>':''?>
    <form ng-app="appForm" ng-controller="ctlForm" id="myForm" name="myForm"  class="form-area" action="" method="post"  > 
        <input type="hidden" name="id" value="<?=isset($id)?$id:''?>" />
         <div class="form-group"> 
            Patient: 
            <select ng-model="patient_id" name="patient_id" class="mb-20 form-control" required="">
                <option value="">Select Patient...</option>
        <?php   if(count($patients)>0){
                    foreach($patients as $p){
                        echo '<option value="'.$p->id.'">'.$p->full_name.', '.$p->age.' yrs old</option>';
                    }
                } ?>
            </select>
             Weight:
            <div style="margin-bottom:5px;"> 
                <input type="checkbox" class="switch-button" name="inLbs" ng-model="inLbs" value="1" 
                        data-off-text="Kg" data-on-text="Lbs" >
            </div>
            <div class="mb-20">  
                <input ng-model="weight" name="weight"  placeholder="Enter weight" class="form-control" required="" 
                       type="number" min="0" step=".01" >  
                <div ng-messages="myForm.weight.$error" ng-if='myForm.weight.$dirty' class="f-error" role="alert" ng-cloak>
                        <div ng-message="required">You did not enter a field!</div> 
                </div> 
            </div>
             Fat %:
            <div class="mb-20">
                <input ng-model="fat" name="fat"  placeholder="Enter fat %" class="form-control" required="" 
                       type="number" min="0" step=".01"> 
                <div ng-messages="myForm.fat.$error" ng-if='myForm.fat.$dirty' class="f-error" role="alert" ng-cloak>
                        <div ng-message="required">You did not enter a field!</div> 
                </div> 
            </div>
            Muscle %:
            <div class="mb-20">
                <input ng-model="muscle" name="muscle"  placeholder="Enter muscle %" class="form-control" required="" 
                       type="number" min="0" step=".01"> 
                <div ng-messages="myForm.muscle.$error" ng-if='myForm.muscle.$dirty' class="f-error" role="alert" ng-cloak>
                    <div ng-message="required">You did not enter a field!</div> 
                </div> 
            </div>
            BMI: 
            <div class="mb-20">
                <input ng-model="bmi" name="bmi"  placeholder="Enter BMI" class="form-control" required="" 
                       type="number" step=".01"> 
                <div ng-messages="myForm.bmi.$error" ng-if='myForm.bmi.$dirty' class="f-error" role="alert" ng-cloak>
                    <div ng-message="required">You did not enter a field!</div> 
                </div> 
            </div>
            Resting Kcal: 
            <div class="mb-20">
                <input ng-model="resting_kcal" name="resting_kcal"  placeholder="Enter resting kcal" class="form-control" required="" 
                       type="number"> 
                <div ng-messages="myForm.resting_kcal.$error" ng-if='myForm.resting_kcal.$dirty' class="f-error" role="alert" ng-cloak>
                    <div ng-message="required">You did not enter a field!</div> 
                </div> 
            </div>
            Visceral Fat:
            <div class="mb-20">
                <input ng-model="visceral_fat" name="visceral_fat"  placeholder="Enter visceral fat" class="form-control" required="" 
                       type="number" min="1" max="20" maxlength="3"> 
                <div ng-messages="myForm.visceral_fat.$error" ng-if='myForm.visceral_fat.$dirty' class="f-error" role="alert" ng-cloak>
                    <div ng-message="required">You did not enter a field!</div> 
                    <div ng-message="min">Min value is 1!</div>
                    <div ng-message="max">Max value is 20!</div>
                    <div ng-message="maxlength">Your field is too long!</div>
                </div> 
            </div> 
            Body Age: 
            <div class="mb-20">
                <input ng-model="body_age" name="body_age"  placeholder="Enter body age" class="form-control" required="" 
                       type="number" maxlength="3"> 
                <div ng-messages="myForm.body_age.$error" ng-if='myForm.body_age.$dirty' class="f-error" role="alert" ng-cloak>
                    <div ng-message="required">You did not enter a field!</div> 
                    <div ng-message="maxlength">Your field is too long!</div>
                </div> 
            </div>
              
        </div> 
        <div style="text-align: center;">
            <div class="alert-msg" style="text-align: left;"></div>
            <input type="submit" class="genric-btn primary circle" value="Save"> 
            <input type="button" class="genric-btn primary circle" value="Cancel" 
                   onclick="location.href='<?= base_url()?>account/measurements'">
        </div> 
    </form>	
</div>
 



<script> 
    $(document).ready(function(){ 
        //Switch button
	$(".switch-button[type=checkbox]").bootstrapSwitch();  
        $('.switch-button').on('switchChange.bootstrapSwitch', function (event, state) { 
            var w=$('input[name=weight]').val(); 
            if(w){ 
                //Convert kg to lbs format
                if(state===true){
                    $('input[name=weight]').val(kgToLbs(w));
                }//In kgs format 
                else{
                    $('input[name=weight]').val(lbsTokg(w));
                } 
            }           
        });
    });
    
 
    (function(angular) {
        'use strict';
            
        var app = angular.module('appForm', ['ngMessages']); 
        //Controller
        app.controller('ctlForm', function($scope, $http, $timeout){ 
            $("#formWrapper").hide();
            $("#formWrapper").fadeIn(2000); 
                    
            //Variables
            $scope.inLbs=true;  //Default to lbs
<?php   if(isset($weight)){?>
            $scope.patient_id='<?=$patient_id?>';
            $scope.inLbs=<?=(isset($inLbs) && $inLbs)?'true':'false'?>;
            $scope.weight=<?=$weight?>;
            $scope.fat=<?=$fat?>;
            $scope.muscle=<?=$muscle?>;
            $scope.bmi=<?=$bmi?>;
            $scope.resting_kcal=<?=$resting_kcal?>;
            $scope.visceral_fat=<?=$visceral_fat?>;
            $scope.body_age=<?=$body_age?>; 
<?php   } ?>
        });
    })(window.angular); 
</script>