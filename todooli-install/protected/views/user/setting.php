<!-- Dialog Popup Js -->
<script src="<?php echo Yii::app()->params->base_url; ?>js/j.min.Dialog.js" type="text/javascript"></script>		
<script src="<?php echo Yii::app()->params->base_url; ?>js/jDialog.js" type="text/javascript"></script>	
<script src="<?php echo Yii::app()->params->base_path_language; ?>languages/<?php echo Yii::app()->session['prefferd_language'];?>/global.js" type="text/javascript"></script>	
<script type="text/javascript">	
function removeAccount()
{
	$j('#errorOther').removeClass();
	$j('#errorOther').html('');
	var other=document.getElementById('txtother').value;
	if(document.getElementById('chkOther').checked==true)
	{
		if(document.getElementById('txtother').value=='')
		{
			$j('#errorOther').addClass('false');
			$j('#errorOther').html(msg['_OTHER_REASON_']);
			return false;
		}
		var reg = msg["DESCRIPTION_REG"];
		if(reg.test(other))
		{
			$j('#errorOther').removeClass();
			$j('#errorOther').html('');
		}
		else
		{
			$j('#errorOther').addClass('false');
			$j('#errorOther').html(msg['FIRST_NAME_REG_SPECIAL_CHARACTER']);
			return false;
		}
	}
	
	jConfirm('##_SETTING_DELETE_CONFIRM_##', '##_SETTING_CONFIRMATION_DIALOG_##', function(response) {
		if(response==true)
		{
			$j.ajax({			
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path; ?>user/closeAccount',
			data: $j('#closeAccountForm').serialize(),
			success: function(data)
			{
				if(data=="success")
				{
					window.location.href=BASHPATH;	
				}
				return false;
			}
			});
		}
	});
}
</script>
	
<!-- End Dialog Popup Js -->
<div class="RightSide">
    <h1>##_SETTING_HEADER_##</h1>
    <div>
        <?php echo CHtml::beginForm('#','post',array('id' => 'closeAccountForm','name' => 'closeAccountForm')) ?>
            <div class="">
                <div><label>##_SETTING_WHY_CLOSE_##</label></div>
                
                <!--<input type="hidden" name="id" value="<?php echo Yii::app()->session['userId']; ?>" />-->
                <div class="field">
                    <div class="checkbox1"><input type="radio" name="reason" value="##_SETTING_DUPLICATE_##" checked="checked"/> <span>##_SETTING_DUPLICATE_##</span></div>
                </div>
                <div class="clear"></div>
                
                <div class="field">
                    <div class="checkbox1"><input type="radio" name="reason" value="##_SETTING_MANY_MAILS_##" /> <span>##_SETTING_MANY_MAILS_##</span></div>
                </div>
                <div class="clear"></div>
                
                <div class="field">
                    <div class="checkbox1"><input type="radio" name="reason" value="##_SETTING_MEMBERSHIP_##" /> <span>##_SETTING_MEMBERSHIP_##</span></div>
                </div>
                <div class="clear"></div>
                
                <div class="field">
                    <div class="checkbox1"><input type="radio" name="reason" value="##_SETTING_ANOTHER_SERVICE_##" /> <span>##_SETTING_ANOTHER_SERVICE_##</span></div>
                </div>
                <div class="clear"></div>
                
                <div class="field">
                    <div class="checkbox1"><input type="radio" name="reason" value="##_SETTING_OTHER_##" id="chkOther" /> <span>##_SETTING_OTHER_##</span></div>
                    <div class="clear"></div>
                    <div class="other-box"><input type="text" class="textbox1" id="txtother" name="txtother" /> <span id="errorOther"></span></div>
                </div>
                <div class="clear"></div>
                
                <div class="fieldBtn">
                    <div class="continue-btn">
                        <input type="button" class="btn" name="" onclick="removeAccount()" value="##_BTN_CONTINUE_##" />
                        <input type="button"  onclick="javascript:window.location='<?php echo Yii::app()->params->base_path; ?>user'"  value="##_BTN_CANCEL_##" class="btn" />	
                    </div>
                </div>
            </div>
        <?php echo CHtml::endForm(); ?> 
    </div>
</div>