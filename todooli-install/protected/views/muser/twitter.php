<div class="title">##_MOBILE_USER_TWITTER_LINK_##</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
<div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/updateLink','post',array('id' => 'frm_twitter','name' => 'frm_twitter')) ?>
<div class="field-area">
	<div class="field">
		<label>##_MOBILE_USER_LINKEDIN_LINK_EG_##</label>
		<input type="text" name="link_value" id="link_value" value="<?php echo $data['twitterLink'];?>" class="textbox" />
	<input type="hidden" name="link_name" id="link_name" value="twitterLink" class="textbox" />
	<input type="hidden" name="action" id="action" value="addTwitter" class="textbox" />
	</div>
	<div align="left">
		<input type="submit" name="btnsubmit" value="##_BTN_SUBMIT_##" class="btn" />
		<input type="button" value="##_BTN_CANCEL_##" class="btn" onclick="javascript:history.go(-1);" /> 
	</div>               
</div>
<?php echo CHtml::endForm();?>
<div class="clear"></div>


 