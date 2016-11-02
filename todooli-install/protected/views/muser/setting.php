<div class="title">##_MOBILE_USER_SETTING_HEADER_##</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
<div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
<div class="clear"></div>
<?php endif; ?>
	<div class="field-area">
    	<div align="left"><label><b>##_MOBILE_USER_SETTING_WHY_CLOSE_##</b></label></div>
        <?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/deleteAccountConfirm','post',array('id' => 'closeAccountForm','name' => 'closeAccountForm')) ?>
        	<input type="hidden" name="functionname" value="closeAccount" />
			<input type="hidden" name="itemname" value="account" />
			<div class="help-option">
				<div>
					<div class="radio-btn"><input type="radio" name="reason" value="##_MOBILE_USER_SETTING_DUPLICATE_##" checked="checked"/></div>
					<div class="reason-name">##_MOBILE_USER_SETTING_DUPLICATE_##</div>
					<div class="clear"></div>
				</div>                   
				<div>
					<div class="radio-btn"><input type="radio" name="reason" value="##_MOBILE_USER_SETTING_MANY_MAILS_##" /></div>
					<div class="reason-name">##_MOBILE_USER_SETTING_MANY_MAILS_##</div>
					<div class="clear"></div>
				</div>
				<div>
					<div class="radio-btn"><input type="radio" name="reason" value="##_MOBILE_USER_SETTING_MEMBERSHIP_##" /></div>
					<div class="reason-name">##_MOBILE_USER_SETTING_MEMBERSHIP_##</div>
					<div class="clear"></div>
				</div>
				<div>
					<div class="radio-btn"><input type="radio" name="reason" value="##_MOBILE_USER_SETTING_ANOTHER_SERVICE_##" /></div>
					<div class="reason-name">##_MOBILE_USER_SETTING_ANOTHER_SERVICE_##</div>
					<div class="clear"></div>
				</div>
				<div>
					<div class="radio-btn"><input type="radio" name="reason" value="##_MOBILE_USER_SETTING_OTHER_##" id="chkOther" /></div>
					<div class="reason-name">##_MOBILE_USER_SETTING_OTHER_##</div>
					<div class="other-box"><input type="text" class="textbox1" id="txtother" name="txtother" /><span id="errorOther"></span></div>
					<div class="clear"></div>
				</div>
				<div class="help-btn">
					
                    <input type="submit" class="btn continue" name="" value="##_BTN_CONTINUE_##" />
					<input type="button" value="##_BTN_CANCEL_##" onclick="javascript:history.go(-1);" class="btn" />
               
			</div>
		<?php echo CHtml::endForm();?>
	</div>