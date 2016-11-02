<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/changePassword','post',array('id' => 'frm_change_password','name' => 'frm_change_password')) ?>
	<input type="hidden" id="user_id" name="user_id" value="<?php echo Yii::app()->session['userId']; ?>" />
	<div class="title">##_MOBILE_USER_CHANGE_PASSWORD_##</div>

	<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
	<div class="clear"></div>
    <?php endif; ?>
    
	<div><span id="passwordreseterror"></span></div>
	<div class="field-area">
		<div class="field"><label>##_MOBILE_USER_CHANGE_OLD_PASSWORD_##</label>
			<input type="password" name="oldpassword" id="old_password" value="<?php echo isset($_POST['oldpassword'])?$_POST['oldpassword']:'';?>" class="textbox" />
		</div>
		<div class="field"><label>##_MOBILE_USER_CHANGE_NEW_PASSWORD_##</label>
			<input type="password" name="newpassword" id="new_password" value="<?php echo isset($_POST['newpassword'])?$_POST['newpassword']:'';?>" class="textbox" />
		</div>
		<div class="field"><label>##_MOBILE_USER_CHANGE_CONFIRM_PASSWORD_##</label>
			<input type="password" name="confirmpassword" id="c_password"  value="<?php echo isset($_POST['confirmpassword'])?$_POST['confirmpassword']:'';?>" class="textbox" />
		</div>
		<div align="left">
			<input type="submit" id="btn_change_password"  name="btn_change_password" value="##_BTN_SUBMIT_##" class="btn" />
			<input type="button" value="##_BTN_CANCEL_##" class="btn" onclick="javascript:history.go(-1);" />
		</div>               
	</div>
	<div class="clear"></div> 
<?php echo CHtml::endForm();?>
