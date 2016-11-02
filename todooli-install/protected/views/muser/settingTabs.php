<div class="title">##_MOBILE_USER_SETTING_TAB_MY_PROFILE_##</div>
<div class="profile">
	<p>
    	<b><?php echo $data['firstName'].' '.$data['lastName'];?></b>
        <?php if( isset($data['loginId']) && $data['loginId'] != '' ) { echo '('.$data['loginId'].')';}?>
    </p>
    <p><b>##_MOBILE_TIMEZONE_##:</b> <?php echo $data['timezone'];?></p>
    <p>
    	<?php
		if( isset($data['linkedinLink']) && $data['linkedinLink'] ) {?>
			<a href="<?php echo $data['linkedinLink'];?>" target="_blank">
            	<img src="<?php echo Yii::app()->params->base_url;?>images/linkedin-icon.png" />
            </a>
		<?php
        }
		if( isset($data['facebookLink']) && $data['facebookLink'] ) {?>
			<a href="<?php echo $data['facebookLink'];?>" target="_blank">
            	<img src="<?php echo Yii::app()->params->base_url;?>images/facebook-icon.png" />
            </a>
		<?php
        }
		if( isset($data['twitterLink']) && $data['twitterLink'] ) {?>
			<a href="<?php echo $data['twitterLink'];?>" target="_blank">
            	<img src="<?php echo Yii::app()->params->base_url;?>images/twitter-icon.png" />
            </a>
		<?php
        }?>
    </p>
</div>
<div class="list-wrapper">
  <ul class="list">
	<li><a href="<?php echo Yii::app()->params->base_path;?>muser/aboutme">##_MOBILE_USER_SETTING_TAB_ABOUT_ME_##<span>&nbsp;</span></a></li>
    <li><a href="<?php echo Yii::app()->params->base_path; ?>muser/AddLinkedin">##_MOBILE_USER_MAIN_LINKEDIN_##<span>&nbsp;</span></a></li>
    <li><a href="<?php echo Yii::app()->params->base_path; ?>muser/AddFacebook">##_MOBILE_USER_MAIN_FACEBOOK_##<span>&nbsp;</span></a></li>
    <li><a href="<?php echo Yii::app()->params->base_path; ?>muser/AddTwitter">##_MOBILE_USER_MAIN_TWITTER_##<span>&nbsp;</span></a></li>
	<li><a href="<?php echo Yii::app()->params->base_path;?>muser/changePassword">##_MOBILE_USER_SETTING_TAB_CHANGE_PASS_##<span>&nbsp;</span></a></li>
    <li><a href="<?php echo Yii::app()->params->base_path;?>muser/setting">##_MOBILE_USER_SETTING_TAB_CLOSE_ACCOUNT_##<span>&nbsp;</span></a></li>
  </ul>
</div>