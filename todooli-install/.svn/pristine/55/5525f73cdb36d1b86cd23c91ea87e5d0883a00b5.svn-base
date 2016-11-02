    <!doctype html>
    <!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
    <!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
    <!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Todooli mobile apps to get things done</title>
    <link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url;?>images/img/favicon.ico" />
    <link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url;?>images/img/apple-touch-icon.png" />
    <meta name="description" content="todooli, Finditnear, jobsmo, bridgecall, dummys-connection, real time, location">
    <meta name="viewport" content="width=1240">
    <link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->params->base_url;?>css/css/style.css">
   
      <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
    <!--[if IE 9]>
        <link rel="stylesheet" type="text/css" href="css/ie9.css" />
    <![endif]-->
    
    <!--[if lt IE 9]>
        <link rel="stylesheet" type="text/css" href="css/ie.css" />
    <![endif]-->
    
    <!-- end CSS-->
    
    <script type="text/javascript">
    function popShareWin(sWidth,sHeight,url) {
    var C=screen.height,B=screen.width,H=Math.round((B/2)-(sWidth/2)),G=0;
    if(C>sHeight){G=Math.round((C/2)-(sHeight/2))};
    url=url.replace("%%URL%%",encodeURIComponent(window.location.href));
    url=url.replace("%%TITLE%%",encodeURIComponent(document.title));
    window.open(url,'','left='+H+',top='+G+',width='+sWidth+',height='+sHeight+',personalbar=0,toolbar=0,scrollbars=1,resizable=1');
    return false;    
    }
    </script>
    
    <script type="text/javascript">    
        if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/Android/i)) || (navigator.userAgent.match(/MSIE 6/i)))
            {
				location.replace("mobile.html");
			}
            
        if((navigator.userAgent.match(/iPad/i)))
            {
				document.write("<link type=\"text\/css\" rel=\"stylesheet\" media=\"screen\" href=\"css/ipad.css\" charset=\"utf-8\" \/>");
			}
 function signInMenu(myid){ 
	
	if(myid=='intro_bar')
	{
		if(Effect) Effect.BlindUp('intro_bar');
	}
	if(document.getElementById('signin_menu').style.display=="block"){
		hideSigninMenu();
		return false;
	}else{
	document.getElementById('signin_menu').style.display="block";
	document.getElementById('signin').className = "floatLeft signin_opened";
	return false;
	}
}
function hideSigninMenu(){
	document.getElementById('signin_menu').style.display="none";	
	document.getElementById('signin').className = "floatLeft signin_normal";
	}
    </script>
    <script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/js/jcarousellite.js"></script>
    <script type="text/javascript">
        $(function() {
        $(".anyClass").jCarouselLite({
            btnNext: ".next",
            btnPrev: ".prev"
        });
    });
    </script>
    
	<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/eng/global.js" type="text/javascript"></script>
    </head>

            
<body class="<?php if(strtolower($_GET['r'])=="site" || strtolower($_GET['r'])=="site/index") { echo 'body'; } else { echo 'body innerBody'; } ?>" >
<!--<body class="innerBody">-->

        <div id="facebookPost">
            <a title="Share on Facebook" href='http://www.facebook.com/sharer/sharer.php' onClick="popShareWin(626,436,'http://www.facebook.com/sharer/sharer.php?u=%%URL%%');return false;"></a>
        </div>
        
        <div id="twitterPost">
            <a title="Tweet this page" href='http://twitter.com/share' onClick="popShareWin(550,450,'https://twitter.com/intent/tweet?url=%%URL%%');return false;"></a>
        </div>
        
        <div id="stumblePost">
            <a title="Stumble this!" href='http://www.stumbleupon.com/submit' onClick="popShareWin(750,550,'http://www.stumbleupon.com/submit?url=%%URL%%');return false;"></a>
        </div>

    <div id="mainWrapper">
        <!-- header Section -->
        
        <div id="header">
        <?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/login','post',array('id' => 'loginform','name' => 'loginorm',)) ?>
            <div class="logoBar1">
                <div class="not-logged-in">
                    <span class="floatLeft adj_signin">Have an account?</span>
                    <a class="floatLeft signin_normal" id="signin" onClick="g_signin=true;signInMenu();return false;" onMouseUp="g_signin=false;" href="#"><span>Sign In</span><span class="arrow"></span></a>            	
                    <span class="floatLeft adj_signin">Need an account?</span>
                    <a onClick="if($('intro_bar'))
            { Effect.BlindUp('intro_bar'); } " id="signup" href="<?php echo Yii::app()->params->base_path; ?>site/signup" class="floatLeft adj_signin">Sign Up</a> 
        </div>
            </div>
            <div style="display:none; top:25px; right:195px;" id="signin_menu">
				<form onSubmit="loging_using_ajax_home();" method="post" action="javascript:" name="loginhomefrm">
					<div style="display:none;" class="error_class_small padd_5 margin_top_8" id="error_msg_login"></div>
					<div>
                        <label for="email_login">Email or Phone</label>
                        <input type="text" class="textbox" style="width:210px;" id="txt_user_email_home" name="email_login" value="" title="username" tabindex="4">
					</div>
					<div>
                        <label for="password_login">Password</label>
                        <input type="password" class="textbox" style="width:210px;" id="txt_user_pass_home" name="password_login" value="" title="password" tabindex="5">
					</div>
                    <div class="remember btn_cont">
                        <div class="floatLeft"><input type="submit" id="signin_submit" value="Sign In" name="submit_login" tabindex="7" class="btn"></div>
                    	<div class="selectbox1">
                        	<input type="checkbox" id="chkRemember_home" name="chkRemember_home" value="1" tabindex="6"> <span>Remember me</span>
                        </div>
                        <div class="clear"></div>
					</div>
                    <div class="forgot">
                      <div><a id="signup_link_b" href="<?php echo Yii::app()->params->base_path; ?>site/signup">Create new account</a></div>
                      <div><a id="signup_link" href="<?php echo Yii::app()->params->base_path; ?>site/support">I can't access my account</a></div>   
                    </div>
				</form>
			</div>
        <?php echo CHtml::endForm(); ?>
        </div>
        
        <div id="middle" class="middle">
            <div class="wrapper">
                <div id="lodingContent"></div>
                <?php echo $content; ?>
            </div>
        </div>
        
        <!-- Footer Section -->
        
        <div class="footer" id="footer" align="center">
                <div>
                    <ul>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>site">Home</a></li>
                        <li>-</li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>site/privacy">Privacy Policy</a></li>
                        <li>-</li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>site/about">About Us</a></li>
                    	<li>-</li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>site/contactus">contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li><label>Apps :</label></li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>finditnear">Finditnear</a></li>
                        <li>-</li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>jobsmo">Jobsmo</a></li>
                        <li>-</li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>bridgecall">Bridge Call</a></li>
                        <li>-</li>
                        <li><a href="<?php echo Yii::app()->params->base_path; ?>shareudid">Shareudid</a></li>
                    </ul>
                </div>
                <div class="address">
                    <p>1250 Oakmead Parkway #210, Sunnyvale, CA 94085, +14082035641, <a href="mailto:info@todooli.com">info@todooli.com</a></p>
                    <p>&copy;2012 Todooli, Inc.</p>
                </div>
                <div class="clear"></div>
            </div>
	</div>
</body>
</html>

