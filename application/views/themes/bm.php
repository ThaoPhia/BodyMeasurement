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
    <header id="header" id="home">
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
                    <a href="<?=base_url()?>"><img src="<?=base_url()?>_assets/img/logo.png" alt="" title="" /></a>			
                    </div>
                    <div class="col-lg-6 col-sm-6 col-8 header-top-right no-padding">
                        <a class="btns" href="tel:#">920.123.4567</a>
                        <a class="btns" href="mailto:#">support@PhiaThao.com</a>		
                        <a class="icons" href="tel:#">
                            <span class="lnr lnr-phone-handset"></span>
                        </a>
                        <a class="icons" href="mailto:#">
                            <span class="lnr lnr-envelope"></span>
                        </a>		
                    </div>
                </div>			  					
            </div>
        </div> <!-- .header-top -->
        <div class="container main-menu">
            <div class="row align-items-center justify-content-between d-flex">
                <nav id="nav-menu-container">
                  <ul class="nav-menu"> 
            <?php if(logged_in()){?>
                    <li class="menu-active"><a href="<?=base_url()?>account">My Account</a></li>  
                    <li class="menu-has-children"><a href="<?=base_url()?>account/patients">Patients</a>
                        <ul>
                            <li><a href="<?=base_url()?>account/addPatient">+ Add</a></li>  				              
                        </ul>
                    </li> 
                    <li class="menu-has-children"><a href="<?=base_url()?>account/measurements">Measurements</a>
                        <ul>
                            <li><a href="<?=base_url()?>account/addMeasurement">+ Add</a></li>  				              
                        </ul>
                    </li>
                    <li><a href="<?=base_url()?>account/logout">Logout</a></li>
            <?php }else{ ?> 
                    <li class="menu-active"><a href="<?=base_url()?>">Home</a></li>  
            <?php } ?> 
                  </ul>
                </nav><!-- #nav-menu-container -->
                <div class="menu-social-icons">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a> 
                </div>	    		
          </div>
      </div><!-- .main-menu -->
    </header><!-- #header -->

    <!-- start banner Area -->
    <section class="banner-area relative about-banner" id="home">	
        <div class="overlay overlay-bg"></div>
        <div class="container">				
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white"><?=$bannerText?></h1>	
                    <p class="text-white link-nav">
                        
                <?php   if($pageUrl && !preg_match("/home/i", $pageUrl)){  
                            echo '<a href="'.base_url().'account/">My Account </a>  
                                <span class="lnr lnr-arrow-right"></span>  
                                <a href="'.base_url()."account/".$pageUrl.'"> '.$pageName.'</a>';
                        } ?>
                    </p>
                </div>	
            </div>
        </div>
    </section>
    <!-- End banner Area --> 

    <!-- Put contents here -->
    <section class="section-gap">
        <div class="container">
            <?php //Output view contents here... ?>
            <?php echo $output;?> 
        </div>	
    </section>
    <!-- End contents --> 
    
    <!-- start footer Area -->		
    <footer class="footer-area section-gap">
        <div class="container"> 
            <div class="row footer-bottom d-flex justify-content-between">
                <p class="col-lg-8 col-sm-12 footer-text m-0"> 
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script>  
                    | Phia Thao
                </p>
                <div class="col-lg-4 col-sm-12 footer-social">
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a> 
                </div>
            </div>
        </div>
    </footer>
    <!-- End footer Area --> 
</body>
</html>