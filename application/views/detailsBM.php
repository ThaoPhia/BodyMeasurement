<div class="form-group">  
    <input type="hidden" name="patient_id" value="<?=$patientId?>" />
    <select id="year" name="year" class="form-control" style="max-width: 150px;"> 
        <option value="2018">Year 2018</option>
    </select> 
</div>

<!-- Show chart --> 
<div id="loading-area" style="text-align:center;">
    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
    <span class="sr-only">Loading...</span>
</div> 
<center id="status"></center> 
<div id="chart_div" style="max-width: 900px; height: 500px;"></div>

<script>
$(document).ready(function(){ 
    var dataAry = []; 
    google.charts.load('current', {'packages':['corechart']});
    //google.charts.setOnLoadCallback(drawVisualization);

    /**
     *  drawVisualization()
     */
    function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable(dataAry);

        var options = {
          title : 'Body Measurement Chart',
          vAxis: {title: 'Number'},
          hAxis: {title: 'Date Time'},
          seriesType: 'bars' 
        }; 
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

    /**
     *  initDraw()
     */
    function initDraw(){       
        $("#status").html('');
        $.ajax({  
            type: "GET",  
            url: "<?=base_url()?>account/call/get-bm-chart-data",  
            data: {patient_id:$("input[name=patient_id]").val(), year: $("#year").val()},  
            dataType: "json",  
            success: function(response){       
                if(response.length > 0){
                    //Populate chart data 
                    dataAry=[
                        ['Month', 'Weight',  'Fat %',     'Muscle %',    'BMI',   'Resting Kcal', 'Visceral Fat', 'Body Age']
                    ];
                    var bmObj=null;
                    for(var i=0; i<response.length; i++){
                        bmObj=response[i];  
                        dataAry[i+1]=[bmObj.date_created, parseFloat(bmObj.weight), 
                            parseFloat(bmObj.fat), parseFloat(bmObj.muscle), 
                            parseFloat(bmObj.bmi), parseFloat(bmObj.resting_kcal), 
                            parseFloat(bmObj.visceral_fat),parseFloat(bmObj.body_age)];  
                    } 
                    $("#loading-area").fadeOut(500, function(){//Hide loading icon  
                        google.charts.setOnLoadCallback(drawVisualization);
                        $("#chart_div").fadeIn(1000);
                    });  
                }else{ 
                    $("#loading-area").fadeOut(500);//Hide loading icon 
                    setTimeout(function() {
                        $("#status").html('No measurements found!');
                    }, 500); 
                }
            }   
	}).error(function (xhr, ajaxOptions, thrownError) {
            var errorMsg = "Status: " + xhr.status + "\n Error: " + thrownError;
            //errorMsg += "\n " + xhr.responseText; 
            alert(errorMsg);
        });
    }
    
    initDraw(); 
    //Year trigger 
    $("#year").change(function(){
        $("#chart_div").hide();
        $("#loading-area").fadeIn();
         
        initDraw();   
    }); 
});      
</script>