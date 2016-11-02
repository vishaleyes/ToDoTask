<?php
$container="items";
$url=Yii::app()->params->base_path.'user/myTodoItem';
if(isset($_GET['from']) && $_GET['from']='description')
{
	$url=Yii::app()->params->base_path.'user/itemDescription/id/'.$id;
	$container="mainContainer";
}
?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
</script>
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
function reassignTask(){
	var postData	=	$j('#reassignForm').serialize();
	$j.ajax({
		url: basePath+'user/addToDoItem/edit/true/popUp/true',
		data: postData,
		type: 'POST',
		success: function(response){
			var obj = parent.$j.parseJSON(response);
			if(obj.status == 0) {
				console.log(obj);
				parent.$j("#update-message").removeClass().addClass('msg_success');
				parent.$j("#update-message").html(obj.message);
				parent.$j("#update-message").fadeIn();
				parent.loadBoxContent('<?php echo $url;?>','<?php echo $container;?>');
				
				parent.$j.fancybox.close();
				
			} else {
				$j('#newUserError').removeClass().addClass('false').html(obj.message)
			
			}
		}
	});
}
</script>
<div>
    <div id="update-message"></div>
    <div class="clear"></div>
    <h2>##_REASSIGN_TASK_TODO_##</h2>
    <?php echo CHtml::beginForm('','post',array('id' => 'reassignForm','name' => 'reassignForm')) ?>
    <input type="hidden" value="<?php echo $id;?>" name="id" />
    <input type="hidden" name="action" value="reassign" />
    <div class="field">
   	 	<div class="checkbox1">
     		<input type="radio" name="assignerType" checked="checked" id="radionNewUser" onclick="chkIsUser('1','0')" value="new" />
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
    		<input type="radio" name="assignerType" id="radioFromNetwork" onclick="chkIsUser('2','<?php echo $last_todoassign; ?>')" value="exist" />
       		<span>##_REASSIGN_TASK_FROM_NTEWORK_##</span>
        </div>
    	<div class="clear"></div>
   		<div id="txtFromNetwork" class="selectWrap">
        </div>
    	<div class="clear"></div>
    </div>
    <div class="fieldBtn">
    	<input type="button" class="btn" name="submit" value="##_BTN_SUBMIT_##" onclick="reassignTask()" />
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
<script type="text/javascript">
 $j(document).ready(function(){
 	var last_assign="<?php echo $last_todoassign; ?>";
	if(last_assign!=0)
	{
		$j("#radioFromNetwork").trigger("click");
	}
	
 })
</script>