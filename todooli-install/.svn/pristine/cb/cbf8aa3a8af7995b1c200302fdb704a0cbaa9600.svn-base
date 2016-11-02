<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.fancybox-1.3.1.js"></script>

<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function() {
	
	$j("#editToDo").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
	
	$j('#commentDiv').load("<?php echo Yii::app()->params->base_path;?>user/getComments/id/<?php echo $data['id'];?>");
	$j('#submit').click(function() {
		var postData	=	$j("#comments").serialize();
		$j.ajax({
			type: "POST",
			url: '<?php echo Yii::app()->params->base_path; ?>user/addComments' ,
			data: postData,
			success: function(response) {
				if(response == 'success'){
					$j('#commentDiv').load("<?php echo Yii::app()->params->base_path;?>user/getComments/id/<?php echo $data['id'];?>");
					document.getElementById("commentText").value = "";
				}
			}
			
		});
	});
});
function updateTodoList(){
	
	var title =  $j("#todoListtitle").val();
	var desc =  $j("#description").val();
	var listId = $("#listId").val();
	if(title=='')
	{
		$j("#todoListtitlemsg").text("Please enter list name");
		return false;
	}
	else
	{
		var postData	=	$j('#editTodoItem_form').serialize();
		$j.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->params->base_path;?>user/updateToDoList',
			data: "title="+title+"&desc="+desc+"&listId="+listId,
			cache: false,
			success: function(data)
			{
				
				if(data == 1){
					$j("#update-message").removeClass().addClass('msg_success');
					$j("#update-message").html('Your To Do List Successfully Updated.');
					$j("#update-message").fadeIn();
					$j.fancybox.close();
					
				} else {
					$j("#update-message").removeClass().addClass('error-msg');
					$j("#update-message").html('Problem With Update.');
					$j("#update-message").fadeIn();
				}
			}
		});
	}
}
</script>
<div>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
	<h1 class="popupTitle"><?php echo $data['name']; ?></h1>
    <ul class="titleList popupTitleList">
    	<li><label>##_LIST_DESC_CREATED_##:</label>
        <span><?php echo $data['assignedByFname'].' '.$data['assignedByLname']; ?></span><p class="clear"></p></li>
        
		<li><label>##_LIST_DESC_DESC_##:</label>
        <span><?php if($data['description']==''){ echo "No description.";}else { echo $data['description'];} ?></span><p class="clear"></p></li>
        
        <li><label>##_LIST_DESC_STATUS_##:</label>
        <span>
		<?php
		if($data['status'] == 0) {
			echo 'Open';
		} else if($data['status'] == 1) {
			echo 'Archive';
		} else {
			echo 'Deleted';
		}
		?>
        </span><p class="clear"></p>
        </li>
        
        <li><label>##_LIST_DESC_AT_##:</label>
        <span><?php echo $data['time']; ?></span><p class="clear"></p></li>      
	</ul>
    <div class="field"><label>##_LIST_DESC_MEMBER_##:</label></div>
    <table cellpadding="0" cellspacing="0" border="0" class="listing">
    	<tr>
        	<th>##_LIST_DESC_NAME_##</th>
        	<th>##_LIST_DESC_EMAIL_##</th>
        	<th>##_LIST_DESC_SINCE_##</th>
        	<th class="lastcolumn">##_LIST_DESC_STATUS_##</th>
        </tr>
        <?php 
		if(count($listMembers) > 0) { 
		foreach($listMembers as $row) { ?>
        <tr>
        	<td><?php echo $row['firstName'].' '.$row['lastName'];?></td>
        	<td><?php echo $row['loginId']; ?></td>
        	<td><?php echo $row['time']; ?></td>
        	<td class="lastcolumn">
			<?php if($row['status']==0){ 
            			echo "##_LIST_DESC_INACTIVE_##";
			}elseif($row['status']==1){
				     echo "##_LIST_DESC_ACTIVE_##";
			}else{
				echo "##_LIST_DESC_BLOCK_##";
			}?>
			
		<?php }  ?>
            </td>
        </tr>
       <?php }else {  ?>
       		<tr>
            	<td colspan="4" class="lastcolumn">##_LIST_DESC_NO_MEMBER_##</td>
            </tr>
       <?php } ?>
    </table>
     <?php
	if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
		<div class="pagination">
			<?php
            $this->widget('application.extensions.WebPager', 
                            array('cssFile'=>true,
                                     'pages' => $pagination,
                                     'id'=>'link_pager',
            ));
            ?> 
		</div> 
	<?php } ?>
</div>