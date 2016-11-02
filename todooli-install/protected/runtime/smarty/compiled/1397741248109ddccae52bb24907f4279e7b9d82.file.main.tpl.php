<?php /* Smarty version Smarty-3.1.7, created on 2012-01-31 11:34:47
         compiled from "D:\xampp\htdocs\todooliapp\themes\basic\views\layouts\main.tpl" */ ?>
<?php /*%%SmartyHeaderCode:312174f2778956dc8d0-89104044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1397741248109ddccae52bb24907f4279e7b9d82' => 
    array (
      0 => 'D:\\xampp\\htdocs\\todooliapp\\themes\\basic\\views\\layouts\\main.tpl',
      1 => 1327989885,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '312174f2778956dc8d0-89104044',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f27789588e55',
  'variables' => 
  array (
    'Yii' => 0,
    'generalError' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f27789588e55')) {function content_4f27789588e55($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<title></title>
<script src="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var BASHPATH='<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
';

var $j = jQuery.noConflict();

function changeBG()
 {
	if($j("#password").val()=='')
	{
		$j("#password").css('background','#ffffff url(public/images/##_PASSWORD_IMAGE_##) left center');
		$j("#password").css('background-repeat','no-repeat');
	}
 }
</script>

<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/css/registration.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/css/jquery.fancybox-1.3.1.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/js/jquery.fancybox-1.3.1.js"></script>
<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/images/logo/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/images/logo/apple-touch-icon.png" />

</head>
<body class="body">
 <!-- Remove select and replace -->
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/js/jquery-ui-1.8.13.custom.min.js"></script>
    <!-- Header Part -->
  <?php if (isset($_smarty_tpl->tpl_vars['generalError']->value)){?>
    	<div class="error-area">
        <a href="" class="error-close"></a>
        This employer has not setup profile. Please contact us if you need help.
		
    <?php }?>
    <script type="text/ecmascript">
	if (navigator.cookieEnabled == 0) {
	   document.write("<div class='error-area'><a href='' class='error-close'></a>You need to enable cookies for this site to load properly!</div>");
	}
	</script>
       <div class="main-wrapper">
        <div class="topHeader" style="margin:0px auto;">
            <div class="main-header">
                <div class="wrapper">
                <div class="topbar">
                    <div class="logo">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/images/logo/##_SITENAME_NO_CAPS_##-254.png" alt="##_LOGO_ALTER_##" border="0" /></a>
                      
                    </div>
                            <div class="login">
                                <form name="loginorm" id="loginform" action="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/login" method="post">
                                  <div class="field">
                                    <table border="0">
                                        <tr>
                                            <td style="color:#ffffff;">
                                                <b>##_HOME_EMAIL_OR_PHONE_##:</b>
                                            </td>
                                            <td>
                                                <div class="textbox-wrapper">
                                                    <input tabindex="1" type="text" id="tt_email_login" name="email_login" class="textbox width130" <?php if (($_COOKIE['email_login'])!=''){?> value="<?php echo $_COOKIE['email_login'];?>
" <?php }?> />		
                                                </div>
                                            </td>
                                            <td style="color:#ffffff;">
                                                <b>##_HOME_PASSWORD_##:</b>
                                            </td>
                                            <td>
                                                <div class="textbox-wrapper" id="mypasswordheader">
                                                    <input tabindex="2"  name="password_login" id="password_login"   type="password" class="textbox width130" <?php if (($_COOKIE['password_login'])!=''){?>   value="<?php echo $_COOKIE['password_login'];?>
" <?php }?> />
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
                                                <div align="left" style="margin-top:-3px;"><b><a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/help" tabindex="5" style="color:#ffffff;">##_HOME_I_CANT_ACCESS_ACCOUNT_##</a></b></div>
                                            </td>
                                        </tr>
                                    </table>
                                  </div>	
                                </form>
                        
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                </div>	
                </div>
            </div>
            <div class="clear"></div>
        </div>
  
  	<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

  <!-- Footer Part content-->

<div class="footer footer-bottom">
    <div class="wrapper">
        <div align="center"><img src="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/images/footer-seprater.png" width="95%" alt="" border="0" /></div>
         <div>
        <div class="site-info">
            <p>##_HOME_FJN@2012_## <a href="http://finditnear.com">##_HOME_FJN_COM_##</a> &nbsp;|&nbsp;&nbsp;<a href="javascript:;" id="openlang">##_HOME_LANGUAGE_##</a></p>
        </div>
        <div class="floatRight">
            <ul id="footer-nav">
           
                <li><a href=" <?php echo $_smarty_tpl->tpl_vars['Yii']->value->params->base_path;?>
">##_HOME_HOME_##</a></li>
                <li><a href=" <?php echo $_smarty_tpl->tpl_vars['Yii']->value->params->base_path;?>
user&view=about">##_HOME_ABOUT_##</a></li>
                <li><a href=" <?php echo $_smarty_tpl->tpl_vars['Yii']->value->params->base_path;?>
user/mobile">##_HOME_MOBILE_##</a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/privacy">##_HOME_PRIVACY_##</a></li>
                <?php if (isset($_SESSION['seekerId'])){?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
tos/seeker/1" class="tosLink">##_HOME_T&C_## </a></li>	
                <?php }elseif(isset($_SESSION['employerId'])){?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
tos/employer/1" class="tosLink">##_HOME_T&C_## </a></li>
                <?php }else{ ?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
tos">##_HOME_T&C_## </a></li>
                <?php }?>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/contactus">##_HOME_CONTACT_US_##</a></li>
            </ul>
        </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
</div>
<ul id="languagelist">
 <li class="selected en"><a lang="en" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/prefferedLanguage/eng"><?php if (isset($_SESSION['prefferd_language'])&&$_SESSION['prefferd_language']=='eng'){?><strong>English</strong><?php }else{ ?><span>English</span><?php }?></a></li>
 <li class="es"><a lang="es" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/prefferedLanguage/spn"><?php if (isset($_SESSION['prefferd_language'])&&$_SESSION['prefferd_language']=='spn'){?><strong>Espanol</strong><?php }else{ ?><span>Espanol</span><?php }?></a></li>
  <li class="es"><a lang="es" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/prefferedLanguage/fr"><?php if (isset($_SESSION['prefferd_language'])&&$_SESSION['prefferd_language']=='fr'){?><strong>French</strong><?php }else{ ?><span>French</span><?php }?></a></li>
   <li class="es"><a lang="es" href="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
user/prefferedLanguage/prtg"><?php if (isset($_SESSION['prefferd_language'])&&$_SESSION['prefferd_language']=='prtg'){?><strong>Portuguese</strong><?php }else{ ?><span>Portuguese</span><?php }?></a></li>
 </ul>

<script src="languages/eng/global.js" type="text/javascript"></script>	
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['Yii']->value->theme->baseUrl;?>
/js/language_popup.js"></script>	

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

<?php }} ?>