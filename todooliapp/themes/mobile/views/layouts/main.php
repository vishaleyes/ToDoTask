<?php
if(!class_exists('Yii'))
{
	header("location:http://www.findjobsnear.com");
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<title>##_MOBILE_USER_MAIN_HOME_TITLE_##
</title>
<meta name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>

<script src="<?php echo Yii::app()->params->base_url;?>js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="application/javascript">
var BASHPATH='<?php echo Yii::app()->params->base_url; ?>';
var $j = jQuery.noConflict();
$j(document).ready(function(){
	var msgBox	=	$j('#msgbox');
	msgBox.click(function(){
		msgBox.fadeOut();
	});
});
</script>
<script src="<?php echo Yii::app()->params->base_path_language;?>languages/<?php echo Yii::app()->session['prefferd_language'];?>/global.js" type="text/javascript"></script>	

 <?php 
 if(isset(Yii::app()->session['homePage']) && Yii::app()->session['homePage']==1 && !isset(Yii::app()->session['userId'])){?>
	<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/iphonenav.css" />
    <?php 
 } else
    { ?>
	<link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/iphonenav.css" />
    <?php
    }
	?>
<meta property="og:image" content="<?php echo Yii::app()->params->base_url;?>images/todooliapp/logo/todooliapp-square.png" />
<link rel="image_src" href="<?php echo Yii::app()->params->base_url;?>images/todooliapp/logo/todooliapp-square.png" />
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/favicon.ico" />
<link rel="apple-touch-icon" href="<?php echo Yii::app()->params->base_url; ?>images/logo/apple-touch-icon.png" />
</head>
<body style="overflow-y:scroll;">
<div class="header">
    <h1>
    <?php 
	$url=parse_url($_SERVER['QUERY_STRING']);
	if(!isset($url['path']))
	{
		$url['path']='';
	}
	?>
        <a href="<?php echo Yii::app()->params->base_path; ?>msite/index">
        	 <?php 
			 if(isset(Yii::app()->session['homePage']) && Yii::app()->session['homePage']==1 && !isset(Yii::app()->session['userId'])){?>
				<img src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo_m.png" alt="" border="0" />
                <span class="gray">##_MOBILE_LOGO_DESC_##</span>
				<?php 
			 } else
			 { ?>
				<img src="<?php echo Yii::app()->params->base_url; ?>images/logo/logo_m.png" alt="" border="0" />
                <span class="gray">##_MOBILE_LOGO_DESC_##</span>
			<?php
			}
			?>
        </a>
    </h1>
    <h2>
     <?php  if(isset(Yii::app()->session['userId']) && Yii::app()->session['userId']!=''){?>
     	<input type="button" class="btn floatRight" value="Add TODO" onclick="window.location.href='<?php echo Yii::app()->params->base_path; ?>muser/AddTodo'" />
     <?php } else {?>
     	 <h2 class="topContact"><a href="<?php echo Yii::app()->params->base_path; ?>msite/contactUs">##_MOBILE_USER_HEADER_CONTACT_US_##</a></h2>
     <?php }?>
		
    </h2>
 <div style="clear:both;"></div>
 </div>
 <?php 
 if(isset(Yii::app()->session['userId'])){?>
 <div align="center" class="main">
    <div class="content">
 	<div class="welcome">
        <div class="welcome-text">
            <label>##_MOBILE_USER_HEADER_HI_## <?php echo Yii::app()->session['fullname']; ?></label>
        </div>
        <div class="logout-btn">
            <label>
                <?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/logout','post',array('name' => 'logout')) ?>
                	<a href="#" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>muser/logout';">Logout</a>
                <?php echo CHtml::endForm();?>
            </label>
        </div>
        <div class="clear"></div>
	</div>
	<?php
     }
    	echo $content; ?>
    <?php
 
if(isset(Yii::app()->session['loginIdType'])){
		?>
          <?php
			$helperObj=new Helper();
			echo $helperObj->displayMobileBreadCrumb(); 		 
			?>
           <div class="list-wrapper">
              <ul class="list">
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/myTodo">##_MOBILE_USER_MAIN_HOME_##<span>&nbsp;</span></a></li>
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/mytodo">##_MOBILE_USER_MAIN_MY_TODO_## <label class="red"><?php if( isset(Yii::app()->session['myTodoCount']) ){echo "(".Yii::app()->session['myTodoCount'].")";} ?></label></a></li>
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/AssignedByMe">##_MOBILE_USER_MAIN_ASSIGN_ME_## <label class="green"><?php if( isset(Yii::app()->session['byTodoCount']) ){echo "(".Yii::app()->session['byTodoCount'].")";} ?></label></a></li>
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/OthersTodo">##_MOBILE_USER_MAIN_OTHERS_TODO_## <label class="red"><?php if( isset(Yii::app()->session['otherTodoCount']) ){echo "(".Yii::app()->session['otherTodoCount'].")";} ?></label></a></li>
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/reminders">##_MOBILE_USER_MAIN_REMINDERS_## <label class="red"><?php if(isset(Yii::app()->session['reminders']) && Yii::app()->session['reminders']){echo "(".$data['reminders'].")";} ?></label></a></li>
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/invites">##_MOBILE_USER_MAIN_INVITATION_## <label class="red"><?php if(isset(Yii::app()->session['invites']) && Yii::app()->session['invites']){echo "(".Yii::app()->session['invites'].")";} ?></label></a></li>
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/myLists">##_MOBILE_USER_MAIN_MY_LISTS_##<span>&nbsp;</span></a></li>
                <li><a href="<?php  echo Yii::app()->params->base_path;?>muser/settingsTab">##_MOBILE_USER_MAIN_MY_PROFILE_##<span>&nbsp;</span></a></li>
                 <!--<li><a href="<?php echo Yii::app()->params->base_path;?>muser/GetMyLists">##_MOBILE_USER_MAIN_MY_LISTS_##<span>&nbsp;</span></a></li>
               <li><a href="<?php echo Yii::app()->params->base_path;?>muser/todoTabs">##_MOBILE_USER_MAIN_TODO_ITEMS_##<span>&nbsp;</span></a></li>-->
                <li><a href="<?php echo Yii::app()->params->base_path;?>muser/myNetwork">##_MOBILE_USER_MAIN_MY_NETWORK_##<span>&nbsp;</span></a></li>
                 <!--<li><a href="<?php echo Yii::app()->params->base_path;?>muser/invites">##_MOBILE_USER_MAIN_INVITE_##<span>&nbsp;</span></a></li>
               <li><a href="<?php echo Yii::app()->params->base_path;?>muser/reminders">##_MOBILE_USER_MAIN_REMINDERS_##<span>&nbsp;</span></a></li>-->
               <!-- <li><a href="<?php echo Yii::app()->params->base_path;?>muser/itemAjax">##_MOBILE_USER_TODO_ITEM_COUNT_##<span>&nbsp;</span></a></li>-->
        		<!--<li><a href="<?php echo Yii::app()->params->base_path; ?>muser/AddLinkedin">##_MOBILE_USER_MAIN_LINKEDIN_##<span>&nbsp;</span></a></li>
              <li><a href="<?php echo Yii::app()->params->base_path; ?>muser/AddFacebook">##_MOBILE_USER_MAIN_FACEBOOK_##<span>&nbsp;</span></a></li>
        		<li><a href="<?php echo Yii::app()->params->base_path; ?>muser/AddTwitter">##_MOBILE_USER_MAIN_TWITTER_##<span>&nbsp;</span></a></li>-->
              </ul>
           </div>    
           <div class="footer-nav-bg" align="left">
                 <div class="footerlinks">
                        <a href="<?php  echo Yii::app()->params->base_path;?>muser">##_MOBILE_USER_MAIN_HOME_##</a><span>|</span><a href="#">##_MOBILE_USER_MAIN_TOP_PAGE_##</a><span>|</span><a href="<?php  echo Yii::app()->params->base_path;?>msite/tos">##_MOBILE_USER_MAIN_TERM_##</a><span>|</span><a href="<?php  echo Yii::app()->params->base_path;?>msite/privacy">##_MOBILE_USER_MAIN_PRIVACY_##</a><span>|</span><a href="<?php  echo Yii::app()->params->base_path;?>msite/about">##_MOBILE_USER_MAIN_ABOUT_##</a><span>|</span><?php  if(isset(Yii::app()->session['userId']) && Yii::app()->session['userId']!=''){?>
     	<a href="<?php echo Yii::app()->params->base_path; ?>msite/contactUs">##_MOBILE_USER_HEADER_CONTACT_US_##</a><?php }?>
	            </div>
           </div>	   
          <div id="footer" class="footer">
            	<label>##_MOBILE_USER_MAIN_FOOTER_NAME_##</label>
       		</div>
        </div>
    </div>	
	<?php
}else{
	
?>
<?php if($url['path']==''){ ?>

<?php }else{
?>  
<div class="notlogin-text">##_MOBILE_USER_MAIN_CLICK_HERE_## <a href="<?Php echo Yii::app()->params->base_path;?>msite/Register">##_MOBILE_USER_MAIN_REGISTER_##</a> | <a href="<?Php echo Yii::app()->params->base_path;?>msite/index">##_BTN_LOGIN_##</a> </div>  
<div class="list-wrapper">
     <ul class="list">
        <li><a href="<?Php echo Yii::app()->params->base_path;?>msite/index">##_MOBILE_USER_MAIN_HOME_##<span>&nbsp;</span></a></li>
        <!--<li><a href="<?php echo Yii::app()->params->base_path; ?>mfinditnear">##_MOBILE_USER_MAIN_FINDITNEAR_##</a></li>
        <li><a href="<?php echo Yii::app()->params->base_path; ?>mjobsmo">##_MOBILE_USER_MAIN_JOBSMO_##</a></li>
        <li><a href="<?php echo Yii::app()->params->base_path; ?>mbridgecall">##_MOBILE_USER_MAIN_BRIDGE_##</a></li>
        <li><a href="<?php echo Yii::app()->params->base_path; ?>mshareudid">##_MOBILE_USER_MAIN_UDID_##</a></li>-->
        <li><a href="<?php echo Yii::app()->params->base_path; ?>msite/ourApps">##_MOBILE_USER_MAIN_OUR_APPS_##</a></li>
        <li><a href="<?php echo Yii::app()->params->base_path; ?>msite/privacy">##_MOBILE_USER_MAIN_PRIVACY_##<span>&nbsp;</span></a></li>
        <li><a href="<?Php echo Yii::app()->params->base_path;?>msite/about">##_MOBILE_USER_MAIN_ABOUT_US_##<span>&nbsp;</span></a></li>		
    </ul>
</div>	
<?php
}?>
       <div id="footer" class="footer">
            <label>##_MOBILE_USER_MAIN_FOOTER_NAME_##</label>
       </div>

          
    </body>
    </html>
<?php } ?>