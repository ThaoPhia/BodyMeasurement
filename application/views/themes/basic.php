<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="Phia Thao">
    <!-- Meta Description -->
    <meta name="description" content="Keep track of body measurements">
    <!-- Meta Keyword -->
    <meta name="keywords" content="body measurement, tracker, weight, fat, muscle, bmi">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Body Measurement</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
    <!-- ==== CSS === -->
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/linearicons.css">
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/nice-select.css">							
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/animate.min.css">
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/jquery-ui.css">			
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/owl.carousel.css">
    <link rel="stylesheet" href="<?=base_url()?>_assets/css/main.css">
    
    <!-- ==== JavaScript === -->
    <script src="<?=base_url()?>_assets/js/vendor/jquery-2.2.4.min.js"></script> 		
    <script src="<?=base_url()?>_assets/js/easing.min.js"></script>			
    <script src="<?=base_url()?>_assets/js/hoverIntent.js"></script>
    <script src="<?=base_url()?>_assets/js/superfish.min.js"></script>	
    <script src="<?=base_url()?>_assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="<?=base_url()?>_assets/js/jquery.magnific-popup.min.js"></script>	
    <script src="<?=base_url()?>_assets/js/jquery-ui.js"></script>			
    <script src="<?=base_url()?>_assets/js/owl.carousel.min.js"></script>						
    <script src="<?=base_url()?>_assets/js/jquery.nice-select.min.js"></script>	 	
    <script src="<?=base_url()?>_assets/js/main.js"></script> 
    
<?php   if(!empty($css)){
            foreach($css as $file){
                echo "\n\t\t"; ?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
            } 
            echo "\n\t";
        }
        if(!empty($js)){
            foreach($js as $file){
                echo "\n\t\t"; ?><script src="<?php echo $file; ?>"></script><?php
            } 
            echo "\n\t"; 
        } ?>
</head>
<body>	 
     <div> 
        <?php echo $output;?> 
    </div>	
</body>
</html>