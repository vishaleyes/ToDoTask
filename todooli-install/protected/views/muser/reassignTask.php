<script type="text/javascript">
var $j = jQuery.noConflict();
var csrfTokenVal = '<?php echo Yii::app()->request->csrfToken;?>';
var basePath	=	'<?php echo Yii::app()->params->base_path;?>';
function chkIsUser(id,value)
{
	if(id==1)
	{
		$j("#txtNewUser").html('<input type="text" class="textbox" id="value" name="value" />');
		$j("#txtFromNetwork").html('');
	}
	else
	{
		$j.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->params->base_path;?>user/getMyNetworkDropdown',
			data: {YII_CSRF_TOKEN:csrfTokenVal,assignTo:value},
			cache: false,
			success: function(data)
			{	
				$j("#txtNewUser").html('');
				$j("#txtFromNetwork").html(data);
			}
		});
	}
}

</script>



<div class="title">##_REASSIGN_TASK_TODO_##</div>
<div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
<?php endif; ?>
<div class="clear"></div>
</div>
<div class="field-area">
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/addTodo/edit/true','post',array('id' => 'reassignForm','name' => 'reassignForm')) ?>
    <input type="hidden" value="<?php echo $id;?>" name="id" />
    <input type="hidden" name="action" value="reassign" />
    <div class="field">
   	 	<div class="checkbox1">
     		<input type="radio" name="assignerType" <?php if($last_todoassign=='0'){?> checked="checked"<?php }?>  id="radionNewUser" onchange="chkIsUser('1','0')" value="new" />
     		<span>##_REASSIGN_TASK_NEW_USER_##</span>
     	</div> <span id="newUserError"></span>
        <div class="clear"></div>
   		<div id="txtNewUser">
        	<input type="text" class="textbox" id="userlist" name="value" />
        </div>
        <div class="clear"></div>
    </div>
    <div class="field">
    	<div class="checkbox1">
    		<input type="radio" name="assignerType" id="radioFromNetwork" <?php if($last_todoassign!='0'){?> checked="checked"<?php }?> onchange="chkIsUser('2','<?php echo $last_todoassign; ?>')" value="exist" />
       		<span>##_REASSIGN_TASK_FROM_NTEWORK_##</span>
        </div>
    	<div class="clear"></div>
   		<div id="txtFromNetwork" class="selectWrap">
        </div>
    	<div class="clear"></div>
    </div>
    <div class="fieldBtn">
    	<input type="submit" class="btn" name="submit" value="##_BTN_SUBMIT_##" />
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<script type="text/javascript">
 $j(document).ready(function(){
 	var last_assign="<?php echo $last_todoassign; ?>";
	if(last_assign!=0)
	{
		chkIsUser('2','<?php echo $last_todoassign; ?>');
	}
	
 })
</script>