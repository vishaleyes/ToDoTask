<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery_003.js"></script>
<script type="text/javascript">
$j	=	jQuery.noConflict();
	$j('#slideshow').cycle({
		timeout: 6000,
		fx:'fade',
		pause:0,
		pager:'#pager'
	});
</script> 
    <div id="slideshow">
        <div class="cycle">
            <div class="slide1">
                <p>##_INDEX_PAGE_DESC_1_##</p>
                <p>##_INDEX_PAGE_DESC_2_##<br /> ##_INDEX_PAGE_DESC_3_##</p>
            </div> 
        </div> 
                     
        <div class="cycle">
            <div class="slide2"><p>##_INDEX_PAGE_DESC_4_##</p></div> 
        </div>         
    </div>
    <div class="clear"></div>
    <div class="tagline">##_INDEX_PAGE_LOCATION_## <a href="<?php echo Yii::app()->params->base_path;?>msite/ourApps">##_INDEX_PAGE_CHECK_APPS_##</a> </div>
    
    <div class="title">##_MOBILE_USER_LOGIN_##</div>
    <div class="msg" style=" margin:10px auto;">  
    <?php if(Yii::app()->user->hasFlash('success')): ?>								   
       <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
       <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
                
        <table width="100%" cellspacing="0" cellpadding="2" border="0" align="left" class="messageBoxTable" >
            <tbody>
                <tr>
                    <td class="errormsg"> 
                    
                    <?php echo Yii::app()->user->getFlash('error'); ?></td>
                   
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
                       
    <div class="field-area">
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'msite/login','post',array('id' => 'loginform','name' => 'loginform')) ?>
        <div class="field">
            <label style="margin:5px 10px 0 0;">##_MOBILE_USER_LOGIN_EMAIL_PHONE_##</label>
            <input type="text" style="height:30px;" maxlength="256" <?php if(isset($loginid)){ ?> value="<?php echo $loginid;?>" <?php }else{ ?> <?php if(isset($_COOKIE['email_login'])&& $_COOKIE['email_login']!= ''){ ?>value="<?Php  $_COOKIE['email_login'];?>" <?php } } ?>  name="email_login" class="textbox" />
        </div>
        <div class="field">
            <label style="margin:5px 10px 0 0;">##_MOBILE_USER_LOGIN_PASSWORD_##</label>
            <input type="password" style="height:30px;" maxlength="20" <?php if(isset($loginid)){ ?> value="<?php echo $loginid;?>" <?php }else{ ?> <?php if(isset($_COOKIE['password_login'])&&$_COOKIE['password_login']!= ''){ ?>value="<?php  Yii::app()->request->cookies['password_login'];?>" <?php } } ?>  name="password_login" class="textbox" />
    
        </div>
        <div class="option">
            <input type="checkbox" checked="checked" name="remenber" value="1" /> ##_MOBILE_USER_LOGIN_REMEMBER_##
        </div>
        <div>
            <input type="submit" name="submit_login" value="##_BTN_LOGIN_##" class="btn" /> <a href="<?php echo Yii::app()->params->base_path;?>msite/support" class="forgot-link">##_MOBILE_USER_LOGIN_ACCESS_##</a>
        </div>            
    <?php echo CHtml::endForm();?> 
    </div>
    <div class="clear"></div> 
    <div class="content">