	<div class="title">##_MOBILE_USER_ABOUT_ME_##</div>
	<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
	
	<?php if(isset($message_prompt) && $message_prompt == '1'){?>
      <div class="field confirmation" id="mybox">
      <label>##_MOBILE_USER_ABOUT_ME_DELETE_EMAIL_## </label>
                <div style="clear:both;"></div>
                <div align="left" style="margin-top:10px;">
                    <input type="submit" name="" value="##_BTN_YES_##" class="btn" onclick="javascript:document.getElementById('deleteyes').value=1;document.getElementById('emailAdd').value='';document.getElementById('frm_edit_profile').submit();" style="margin-right:20px;" /> <input type="button"  value="##_BTN_NO_##" class="btn" onclick="javascript:document.getElementById('mybox').style.display='none';" />
                </div>               
            </div>
	<?php
    }?>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/aboutme','post',array('id' => 'frm_edit_profile','name' => 'frm_edit_profile')) ?>
	<input type="hidden" id="id" name="id" value="<?php echo $data['userData']['id'];?>" />
	<div class="field-area">
		
		<div class="field"><label>##_MOBILE_USER_ABOUT_ME_FULL_NAME_##<span id="fullnameerror"></span></label></div>
		<div class="field">
        	<div class="contactname-textbox">
        		<input type="text" name="fName" id="fName_p" maxlength="18" value="<?php if(isset($data['userData']['firstName'])){ echo $data['userData']['firstName']; } ?>" class="textbox" />
            </div> 
            <div class="contactname-textbox2">
            	<input type="text" name="lName" id="lName_p" maxlength="18" value="<?php if(isset($data['userData']['lastName'])){ echo $data['userData']['lastName']; } ?>" class="textbox" />
            </div>
            <div class="clear"></div>
        </div>
		<div class="field">
			<label>##_MOBILE_USER_ABOUT_ME_EMAIL_## <span id="emailerror"></span></label>
            
			<input type="text" name="email" id="email" readonly="readonly" class="textbox" value="<?php if(isset($data['email'])){ echo $data['email']; } ?>" />
            
			<div id="eml" style="display:none;"></div>
			<div id="emliseditable" style="display:none;"><?php if(isset($loggedin_user[0]['totalVerifiedPhone']) && $loggedin_user[0]['totalVerifiedPhone'] > 0){?>true <?php }else{?>false <?php }?></div>
		</div>
		<div class="field">
        	
        	<label>##_MOBILE_USER_TIMEZONE_##</label>
            <select class="select-box" name="timezone">
			   <?php
				foreach($timezone as $key => $val){
					echo '<optgroup label="'.$key.'">';
					foreach($val as $key => $val){
						if($key==$data['userData']['timezone'])
						{
							echo '<option value='.$key.' selected="selected">'.$val.'</option>';
						}
						else
						{
							echo '<option value='.$key.'>'.$val.'</option>';
						}
					}
					echo '</optgroup>';
				}
				?>
            </select>
        </div>
				
		<div align="left">
			<input type="submit" id="btn_submit"  name="btn_submit" value="##_BTN_SUBMIT_##" class="btn" />  
            <input type="button" value="##_BTN_CANCEL_##" onclick="javascript:history.go(-1);" class="btn" />
		</div>               
	</div>
	<div class="clear"></div>
<?php echo CHtml::endForm();?>