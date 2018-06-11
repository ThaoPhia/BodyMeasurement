<div ng-app="appResultList" ng-controller="ctlResultList" id="formWrapper" style="max-width: 600px; margin:auto;">
    <?=$error?'<p class="error">'. $error .'</p>':''?>
    <form id="myForm" name="myForm"  class="form-area" action="" method="get"  >  
        <input type="hidden" name="account_id" value="<?= user("id")?>" />
         <div class="form-group">  
            <div>  
                 Patient: 
                <select name="patient_id" class="form-control" >
                    <option value="">Select Patient...</option>
            <?php   if(count($patients)>0){
                        foreach($patients as $p){
                            echo '<option value="'.$p->id.'">'.$p->full_name.', '.$p->age.' yrs old</option>';
                        }
                    } ?>
                </select>
            </div>
            <div id="viewMoreFilters"  class="mb-20">+/- More Filters</div> 
            <div id="extraFilters"> 
                <div class="mb-20 search-filter">  
                    Weight (Lbs): 
                    <input name="weight"  class="form-control"  type="number" min="0" step=".01" > 
                </div> 
                <div class="mb-20 search-filter">
                    Fat %:
                    <input name="fat" class="form-control" type="number" min="0" step=".01">  
                </div>
                <div class="mb-20 search-filter">
                    Muscle %:
                    <input name="muscle" class="form-control" type="number" min="0" step=".01">  
                </div>
                 <div class="mb-20 search-filter">
                    BMI:
                    <input name="bmi" class="form-control" type="number" step=".01">  
                </div>
                 <div class="mb-20 search-filter">
                    Resting Kcal:
                    <input name="resting_kcal" class="form-control" type="number">  
                </div>
                 <div class="mb-20 search-filter">
                    Visceral Fat:
                    <input name="visceral_fat" class="form-control" type="number" min="1" max="20" >  
                </div>
                 <div class="mb-20 search-filter">
                    Body Age:
                    <input name="body_fat"  class="form-control" type="number" >  
                </div>
                <div style="clear:both;"></div>
            </div><!-- #extraFilters --> 
            <div style="text-align: center;">
                <div class="alert-msg" style="text-align: left;"></div>
                <input id="btnSearch" type="button" class="genric-btn primary circle" value="Search" ng-click="getMeasurements()"> 										
            </div> 
         </div><!-- .form-group-->
    </form><!-- #myForm --> 

    <!-- Show results here --> 
    <div id="loading-area" style="text-align:center;">
        <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
        <span class="sr-only">Loading...</span>
    </div>
    <div class="result-list" ng-repeat="m in measurements" >
        <div class="rl-row">
            <span class="options">
                <a href="<?= base_url()?>account/editMeasurement/{{m.id}}"><i class="fa fa-pencil"></i></a> 
                <a class='colorbox' href="<?= base_url()?>account/measurementDetails/{{m.patient_id}}" 
                   title="{{m.full_name}} - Body Measurement">
                    <i class="fa fa-bar-chart"></i>
                 </a>
                <i class="fa fa-trash deleteConfirm2" data-value="{{m.id}}"></i> 
            </span>
            {{m.full_name}}, {{m.gender}}, {{m.age}} 
            <span style="float:right;">{{m.date_created}}</span>
        </div> 
    </div>
    <center>{{status}}</center>
</div> 