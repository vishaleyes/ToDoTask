<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>##_MOBILE_FINDITNEAR_DESC_##</title>
<link rel="shortcut icon" href="<?Php echo Yii::app()->params->base_url;?>images/img/favicon.ico" />
<link rel="stylesheet" href="<?Php echo Yii::app()->params->base_url;?>css/css/topbar.css" type="text/css" />
<link rel="stylesheet" href="<?Php echo Yii::app()->params->base_url;?>css/css/iphone.css" type="text/css" />
<link rel="stylesheet" href="<?Php echo Yii::app()->params->base_url;?>css/css/iphonenav.css" type="text/css" />

<script src="<?Php echo Yii::app()->params->base_url;?>js/js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">	 
	function hideBar()
	{
		$('.top-bar').css('display','none');
		$('#finditnear').css('height','100%');
	}
</script>
</head>

<body class="whiteBg">

<div class="top-bar">
    <div class="header">
        <h1>
        	<a href="<?Php echo Yii::app()->params->base_path;?>msite/index"><img src="<?Php echo Yii::app()->params->base_url;?>images/img/logo_m.png" alt="" border="0" /><span>&nbsp;&nbsp;##_MOBILE_LOGO_DESC_##</span></a>
        </h1>
        <h2><a href="mailto:info@todooli.com">##_CONTACT_HEADER_##</a></h2>
        <a href="javascript:;" onClick="hideBar()" class="close"><img src="<?Php echo Yii::app()->params->base_url;?>images/img/close.png" alt="" border="0" /></a>
    </div>
</div>
<div class="clear"></div>

<iframe id="finditnear" name="finditnear" src="http://finditnear.com/" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%" scrolling="auto"></iframe> 
</body>
</html>
