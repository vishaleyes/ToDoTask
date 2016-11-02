<?php
if(!class_exists('Yii'))
{
	header("location:http://www.todooliapp.com");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<meta property="og:title" content="todooliapp" /> 
<meta property="og:description" content="todooliapp is an hourly job search site" /> 
<meta property="og:image" content="<?php echo Yii::app()->params->base_url;?>images/todooliapp/logo/todooliapp-square.png" />
<link rel="image_src" href="<?php echo Yii::app()->params->base_url;?>images/todooliapp/logo/todooliapp-square.png" />

<title>##_SITENAME_##</title>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var BASHPATH='<?php echo Yii::app()->params->base_url; ?>';

var $j = jQuery.noConflict();
var csrfToken	=	'<?php echo Yii::app()->request->csrfTokenName;?>'+'='+'<?php echo Yii::app()->request->csrfToken;?>';

function changeBG()
 {
	if($j("#password").val()=='')
	{
		$j("#password").css('background','#ffffff url(<?php echo Yii::app()->params->base_url;?>images/##_PASSWORD_IMAGE_##) left center');
		$j("#password").css('background-repeat','no-repeat');
	}
 }
</script>
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/##_SITENAME_NO_CAPS_##/##_SITENAME_NO_CAPS_##.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/jquery.fancybox-1.3.1.css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/##_SITENAME_NO_CAPS_##/logo/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />

</head>
<body class="body">
 <!-- Remove select and replace -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-ui-1.8.13.custom.min.js"></script>
<!-- Header Part -->
<script type="text/javascript">
if (navigator.cookieEnabled == 0) {
   document.write("<div class='error-area'><a href='' class='error-close'></a>You need to enable cookies for this site to load properly!</div>");
}
</script>
   
<div class="main-wrapper">
    <div class="topHeader" style="margin:0px auto;">
        <div class="mojone-wrapper">
        <div class="main-header">
            <div class="fjn-wrapper">
            <div class="topbar">
                <div class="logo">
                    <a href="<?php echo Yii::app()->params->base_url; ?>"><img src="<?php echo Yii::app()->params->base_url; ?>images/##_SITENAME_NO_CAPS_##/logo/##_SITENAME_NO_CAPS_##-254.png" alt="##_LOGO_ALTER_##" border="0" /></a>
                    <?php
                    if(isset(Yii::app()->session['accountType'])){
                        if(Yii::app()->session['accountType'] == 1){ ?>
                            <div class="login-side">##_SEEKER_VIEW_MORE_EMPLOYER_##</div>
                        <?php
                        }else{?>
                            <div class="login-side">##_EMAIL_TMP_SIGNUP_SEEKER_ADMIN_SEEKER_##</div>
                        <?php
                        }
                    }
                    ?>
                </div>
                
                <?php
                //if(isset(Yii::app()->session['userId']) && Yii::app()->session['userId'] != ''){ 
                if(!Yii::app()->user->isGuest){ ?>
                    <div class="login1">
                        <div class="field username">
                           ##_HOME_WELCOME_## <?php echo Yii::app()->session['fullname']; ?>
                        </div>
                        <div class="field">
                            <div><input type="submit" name="submit_logout" onclick="window.location='<?php echo Yii::app()->params->base_path;?>user/logout';" class="btn" value="Logout" /></div>
                        </div>
                    </div>            	   
                <?php
                }else{
                    if(isset(Yii::app()->session['loginflag']) && Yii::app()->session['loginflag']!=1){ ?>
                         
                        <div class="login">
                        <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/login','post',array('id' => 'loginform','name' => 'loginorm',)) ?>
                              <div class="field">
                                <table border="0">
                                    <tr>
                                        <td style="color:#ffffff;">
                                            <b>##_HOME_EMAIL_OR_PHONE_##:</b>
                                        </td>
                                        <td>
                                            <div class="textbox-wrapper">
                                                <input tabindex="1" type="text" id="tt_email_login" name="email_login" class="textbox width130" <?php if(isset($_COOKIE['email_login']) && $_COOKIE['email_login']!='') { ?>  value="<?php echo $_COOKIE['email_login'];?>" <?php } ?> />		
                                            </div>
                                        </td>
                                        <td style="color:#ffffff;">
                                            <b>##_HOME_PASSWORD_##:</b>
                                        </td>
                                        <td>
                                            <div class="textbox-wrapper" id="mypasswordheader">
                                                <input tabindex="2"  name="password_login" id="password_login"   type="password" class="textbox width130" <?php if(isset($_COOKIE['password_login']) && $_COOKIE['password_login']!='') { ?>  value="<?php echo $_COOKIE['password_login'];?>" <?php } ?> />
                                            </div>	
                                        </td>
                                        <td>
                                            <div class="field">
                                                <div><input tabindex="3" type="submit" name="submit_login" class="btn" value="##_LOGIN_SIGNIN_BUTTON_##" /></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                                                                <td>&nbsp;</td>
                                        <td style="color:#ffffff;">
                                            <div align="left" style="margin-top:-3px;" >
                                                <input tabindex="4" type="checkbox" checked="checked" name="remenber" value="1" /> <b>##_HOME_REMEMBER_IT_##</b>
                                            </div>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td colspan="2" style="color:#ffffff;">
                                            <div align="left" style="margin-top:-3px;"><b><a href="<?php echo Yii::app()->params->base_path; ?>user/help" tabindex="5" style="color:#ffffff;">##_HOME_I_CANT_ACCESS_ACCOUNT_##</a></b></div>
                                        </td>
                                    </tr>
                                </table>
                              </div>	
                            <?php echo CHtml::endForm(); ?>                       
                            <div class="clear"></div>
                        </div>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            <div class="clear"></div>
            </div>	
            </div>
        </div>
        <div class="clear"></div>
    </div>
        
<?php echo $content; ?>
<!-- Footer Part content-->

<div class="footer footer-bottom">
<div class="fjn-wrapper">
    <div class="footer-seprater"></div>
    <div>
        <div class="site-info">
            <p>##_HOME_FJN@2012_## <a href="http://finditnear.com">##_HOME_FJN_COM_##</a> &nbsp;|&nbsp;&nbsp;<a href="javascript:;" id="openlang">##_HOME_LANGUAGE_##</a></p>
        </div>
        <div class="floatRight">
            <ul id="footer-nav">
           
                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/index">##_HOME_HOME_##</a></li>
                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/about">##_HOME_ABOUT_##</a></li>
                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/sms">##_HOME_SMS_##</a></li>
                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/mobile">##_HOME_MOBILE_##</a></li> 
				<?php if(!isset(Yii::app()->session['seekerId']) && !isset(Yii::app()->session['employerId'])){  ?>
	                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/support">##_MOBILE_USER_FOOTER_HELP_##</a></li>
                <?php } ?>
                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/privacy">##_HOME_PRIVACY_##</a></li>
                <?php if(isset(Yii::app()->session['seekerId']) && Yii::app()->session['seekerId']!=''){  ?>
                <li><a href="<?php echo Yii::app()->params->base_path; ?>tos/seeker/1" class="tosLink">##_HOME_T&C_## </a></li>	
                <?php } else if(isset(Yii::app()->session['employerId']) && Yii::app()->session['employerId']!=''){  ?>
                <li><a href="<?php echo Yii::app()->params->base_path; ?>tos/employer/1" class="tosLink">##_HOME_T&C_## </a></li>
                <?php }else {?>
                <li><a href="<?php echo Yii::app()->params->base_url; ?>tos/index">##_HOME_T&C_## </a></li>
                <?php }?>
                <li><a href="<?php echo Yii::app()->params->base_url; ?>user/contactus">##_HOME_CONTACT_US_##</a></li>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
<div id="post-footer">&nbsp;</div>
</div>
</div>
<ul id="languagelist">
    <li class="selected en"><a lang="en" href="<?php echo Yii::app()->params->base_path;?>user/prefferedLanguage/lang/eng"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='eng'){  ?><strong>English</strong><?php }else { ?><span>English</span><?php } ?></a></li>
    <li class="es"><a lang="es" href="<?php echo Yii::app()->params->base_path;?>user/prefferedLanguage/lang/spn"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='spn'){  ?><strong>Espanol</strong><?php }else { ?><span>Espanol</span><?php } ?></a></li>
    <li class="es"><a lang="es" href="<?php echo Yii::app()->params->base_path;?>user/prefferedLanguage/lang/fr"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='fr'){  ?><strong>French</strong><?php }else { ?><span>French</span><?php } ?></a></li>
    <li class="es"><a lang="es" href="<?php echo Yii::app()->params->base_path;?>user/prefferedLanguage/lang/prtg"><?php if(isset(Yii::app()->session['prefferd_language']) && Yii::app()->session['prefferd_language']=='prtg'){  ?><strong>Portuguese</strong><?php }else { ?><span>Portuguese</span><?php } ?></a></li>
</ul>

<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language'];?>/global.js" type="text/javascript"></script>	
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/language_popup.js"></script>	

<script type="text/javascript">
$j(document).ready(function(){
	$j(".tosLink").fancybox({
		 'transitionIn' : 'none',
		 'transitionOut' : 'none',
		 'type' : 'iframe'
	 });
});	 
</script>
</body>
</html>