<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Todooli - to get things done</title>
<script src="<?php echo Yii::app()->params->base_url; ?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
var BASHPATH='<?php echo Yii::app()->params->base_url; ?>';
var $j = jQuery.noConflict();
var csrfToken	=	'<?php echo Yii::app()->request->csrfTokenName;?>'+'='+'<?php echo Yii::app()->request->csrfToken;?>';
var csrfTokenVal = '<?php echo Yii::app()->request->csrfToken;?>';
function confirmBox() {
	if(confirm("Are sure want to clear db?")) {
		return true;
	}
	return false;
}

function changeBG()
 {
	if($j("#password").val()=='')
	{
		$j("#password").css('background','#ffffff url(../images/##_PASSWORD_IMAGE_##) left center');
		$j("#password").css('background-repeat','no-repeat');
	}
 }
</script>
 	
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/registration.css" />
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/todooliapp/logo/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />
<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp-admin.css" />

<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/admin-style.css"  />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery-ui-1.8.13.custom.min.js"></script>
</head>
<body class="body">
<script type="text/ecmascript">
	if (navigator.cookieEnabled == 0) {
	   document.write("<div class='error-area'><a href='' class='error-close'></a>You need to enable cookies for this site to load properly!</div>");
	}
</script>
<div class="main-wrapper">
  	<div class="header"  id="header">
        <div class="navigation">
            <div class="leftNavigation">
				<?php 
				if(isset(Yii::app()->session['adminUser'])){ ?>
                  <ul id="nav">
                  <li <?php if(Yii::app()->session['current'] == 'statistics'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/statistics"; ?>">Statistics</a>
                    </li>
                    <li <?php if(Yii::app()->session['current'] == 'users'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/users"; ?>">Users</a>
                    </li>
                    <li <?php if(Yii::app()->session['current'] == 'lists'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/lists"; ?>">TODO Lists</a>
                    </li>
                    <li <?php if(Yii::app()->session['current'] == 'items'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/items"; ?>">TODO Items</a>
                    </li>
                   
                     <li <?php if(Yii::app()->session['current'] == 'settings'){?>class="current"<?php }?>>
                  <a href="<?php echo Yii::app()->params->base_path."admin/myProfile"; ?>">My Settings</a>
                  <ul>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/myProfile"; ?>">My Profile</a></li>
                    <li><a href="<?php echo Yii::app()->params->base_path."admin/changePassword"; ?>">Change Password</a></li>
                  </ul>
                </li>
                    <li <?php if(Yii::app()->session['current'] == 'apiFunctions'){?>class="current"<?php }?>>
                        <a href="<?php echo Yii::app()->params->base_path."admin/apiFunctions"; ?>">API</a>
                        <ul>
                            <li>
                                <a href="<?php echo Yii::app()->params->base_path."admin/apiFunctions"; ?>">API Functions</a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::app()->params->base_path."admin/apiModules"; ?>">API Modules</a>
                            </li>
                            <li>
                                <a href="<?php echo Yii::app()->params->base_path."admin/cleanDB"; ?>" onclick="return confirmBox();">CleanDB</a>
                            </li>
                        </ul>
                    </li>
                  </ul>
                <?php } ?>
			</div>
            <div class="rightNavigation">
            	<div class="login">
                	 <?php 
					 if( isset(Yii::app()->session['adminUser']) ) {
						 echo CHtml::beginForm(Yii::app()->params->base_path.'admin/logout','post',array('id' => 'frm','name' => 'frm')) ?>
                        <div class="field username">Welcome <?php echo Yii::app()->session['fullName']?></div>
                        <div class="field">
                          <div>
                            <input type="submit" value="Logout" class="btn" name="submit">
                          </div>
                        </div>
                    <?php 
					echo CHtml::endForm();
					 } ?>
                </div>
            </div>
            <div class="clear"></div>
		</div>
    	<?php /*?><div class="wrapper mojone-wrapper">
		  <?php if(isset(Yii::app()->session['adminUser'])){ ?>
            <div class="logo"> <a href="<?php echo Yii::app()->params->base_path;?>admin/index"><img border="0" alt="##_SITENAME_##.com" src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" /></a> </div>
          <?php }else{ ?> 
            <div class="logo"> <a href="<?php echo Yii::app()->params->base_path;?>admin"><img border="0" alt="##_SITENAME_##.com" src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo.png" /></a> </div>
          <?php } ?>
            
            <div class="clear"></div>
    	</div><?php */?>
  	</div>
 
	<div class="middle">
        <div class="wrapper" style="margin:0px auto;">
            <div align="center"> 
            <?php if(Yii::app()->user->hasFlash('success')): ?>								   
            <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
            <div class="clear"></div>
            <?php endif; ?>
            <?php if(Yii::app()->user->hasFlash('error')): ?>
            <div id="msgbox" class="errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>     
            <?php endif; ?>
            </div>
            <div style="padding:10px 0px;">
                <?php echo $content; ?>
            </div>
            <!-- Footer Part content-->
            
         </div>
        <div class="clear"></div>
    </div>
    <div class="footer-bottom">
    <div id="post-footer"><div class="site-info">Todooli � 2012 <a href="http://todooli.com" target="_new">Todooli</a></div></div>
    </div>

</div>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_path_language; ?>languages/eng/global.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/language_popup.js"></script>

</body>
</html>
