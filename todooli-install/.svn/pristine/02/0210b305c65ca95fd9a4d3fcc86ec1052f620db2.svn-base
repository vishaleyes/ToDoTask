<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/'.$data['functionname'],'post',array('id' => 'deleteConfirm','name' => 'deleteConfirm')) ?>
<div class="field-area">
	<div class="field confirmation"><label>##_MOBILE_USER_DELETE_ACCOUNT_CONFIRM_## <?php echo $data['itemname'];?> ? </label>
	<input type="hidden" name="reason" id="deleteId" value="<?php echo $data['reason'];?>" class="textbox" />
	<?php
    if(isset($data['txtother'])){?>
    	<input type="hidden" name="txtother" id="txtother" value="<?php echo $data['txtother'];?>" class="textbox" />
    <?php
    }?>
    <div style="clear:both;"></div>
	<div align="left" style="margin-top:10px;">
		<input type="submit" name="" value="##_BTN_YES_##" class="btn" style="margin-right:20px;" /> <input type="button"  onclick="javascript: history.go(-1)" value="##_BTN_NO_##" class="btn" />
	</div>               
</div>
<?php echo CHtml::endForm();?>
<div class="clear"></div>  
