<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Todooli Inc., - Share UDID for testing</title>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/css/bridgecall.css" type="text/css" />
<link rel="shortcut icon" href="<?php echo Yii::app()->params->base_url; ?>images/img/bridgecall/favicon.ico" />
</head>

<body>

<div id="facebookPost">
	<a title="Share on Facebook" href='http://www.facebook.com/sharer/sharer.php' onClick="popShareWin(626,436,'http://www.facebook.com/sharer/sharer.php?u=%%URL%%');return false;"></a>
</div>

<div id="twitterPost">
	<a title="Tweet this page" href='http://twitter.com/share' onClick="popShareWin(550,450,'https://twitter.com/intent/tweet?url=%%URL%%');return false;"></a>
</div>

<div id="stumblePost">
	<a title="Stumble this!" href='http://www.stumbleupon.com/submit' onClick="popShareWin(750,550,'http://www.stumbleupon.com/submit?url=%%URL%%');return false;"></a>
</div>

<div class="gradient">
	<div class="topbar">
    	<div class="wrapper">
        	<div class="logo">
				<a href="<?php echo Yii::app()->params->base_path; ?>site"><img src="<?php echo Yii::app()->params->base_url; ?>images/img/logo.png" alt="" border="0" /><span>&nbsp;&nbsp;##_MOBILE_BRIDGECALL_TITLE_##</span></a>
            </div>
        </div>
    </div>
    <div id="page_seperator"></div>
    
    <div class="wrapper">
    	<div class="banner">
        	<div class="banner-text">
            	<h2>##_MOBILE_BRIDGECALL_SHARE_UDID_##</h2>
                <p>##_MOBILE_SHAREUDID_DESC_##</p>
                <div class="download"><a href="http://itunes.apple.com/us/app/shareudid/id527833698?ls=1&mt=8"><img src="<?php echo Yii::app()->params->base_url; ?>images/img/bridgecall/iosappstorebutton.png" alt="" border="0" /><span>##_MOBILE_BRIDGECALL_DOWNLOAD_##</span></a>  </div>
            </div>
        	<div class="banner-img"><img src="<?php echo Yii::app()->params->base_url; ?>images/img/shareudid/iphone.png" alt="" border="0" /></div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div id="page_seperator"></div>
    
    <div id="nav">
    	<ul class="tabs page">
   		    <li><a href="<?php echo Yii::app()->params->base_path; ?>shareudid">##_MOBILE_BRIDGECALL_HOME_##</a></li>
			<li><a href="<?php echo Yii::app()->params->base_path; ?>shareudid/screenshot" class="current">##_MOBILE_BRIDGECALL_SCREENSHOT_##</a></li>
		</ul>
		<div class="clear"></div>
	</div>
    <div class="container" id="bottom_content">
    	<div class="wrapper">
        	<div class="content">
                <div class="box">
                	<img src="<?php echo Yii::app()->params->base_url; ?>images/img/shareudid/screen1.jpg" alt="" border="0" />
                    <p>##_MOBILE_SHAREUDID_DESC_10_##</p>
                </div>
                <div class="clear"></div>
			</div>
        </div>
    </div>
	<div class="clear"></div>
    
    <div class="footer-bg">
        <div class="footer">
            <div class="wrapper">
                <ul>
                    <li>
                         <h3>##_MOBILE_BRIDGECALL_COMPANY_##</h3>
                         <ul>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>site">##_MOBILE_BRIDGECALL_HOME_##</a></li>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>finditnear">##_MOBILE_BRIDGECALL_FINDITNEAR_##</a></li>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>jobsmo">##_MOBILE_BRIDGECALL_JOBSMO_##</a></li>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>bridgecall">##_MOBILE_BRIDGECALL_LOGO_##</a></li>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>shareudid">##_MOBILE_BRIDGECALL_SHARE_UDID_##</a></li>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>site/privacy">##_MOBILE_BRIDGECALL_PRIVACY_##</a></li>
                             <li><a href="<?php echo Yii::app()->params->base_path; ?>site/about">##_MOBILE_BRIDGECALL_ABOUT_US_##</a></li>
                         </ul>
                         <ul>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>                    
                    </li>
                    <li>
                         <h3>##_MOBILE_BRIDGECALL_CONATCT_##</h3>
                        <ul>
                            <li>##_CON_ADD_USA_1_##</li>
                            <li>##_CON_ADD_USA_2_##, ##_CON_ADD_USA_3_##</li>
                            <li></li>
                            <li>##_CON_ADD_USA_4_##</li>
                            <li><a href="mailto:info@todooli.com">##_CON_ADD_EMAIL_SEND_##</a></li>
                        </ul>
                        <ul>    
                            <li></li>
                            <li></li>
                        </ul>                       
                    </li>
                    <li>
                        <ul>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                        </ul>                       
                        <a href="<?php echo Yii::app()->params->base_path; ?>site"><img src="<?php echo Yii::app()->params->base_url; ?>images/img/logo.png" alt="Todooli" border="0" /></a>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
</body>
</html>
