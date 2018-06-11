<div style="max-width: 350px; margin:auto;">
    <?=$error?'<p class="error">'. $error .'</p>':''?>
    <form class="form-area" id="myForm" action="<?= base_url()?>" method="post"  > 	
        <div class="form-group"> 
            <input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" 
                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" 
                   class="mb-20 form-control" required="" type="email">

            <input name="password" placeholder="Enter Password" onfocus="this.placeholder = ''" 
                   onblur="this.placeholder = 'Enter Password'" class="mb-20 form-control" required="" type="password"> 
        </div> 
        <div style="text-align: center;">
            <div class="alert-msg" style="text-align: left;"></div>
            <input type="submit" class="genric-btn primary circle" value="Log Me In"> 										
        </div> 
    </form>	
</div>