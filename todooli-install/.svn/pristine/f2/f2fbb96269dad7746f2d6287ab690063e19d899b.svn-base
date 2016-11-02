<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/smoothscroll.js"></script>
<script type="text/javascript">
$j(document).ready(function() {
	$j(".reassign").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',	
		'type'	 : 'iframe',		
		'width' : 400,
 		'height' : 200
	});
	$j("#editItem").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400
	});
	
	
	$j('#commentDiv').load("<?php echo Yii::app()->params->base_path;?>user/getComments/id/<?php echo $data['id'];?>");
	$j('#history').load("<?php echo Yii::app()->params->base_path;?>user/getItemHistory/id/<?php echo $data['id'];?>");
	$j('#submit').click(function() {
		comment	=	$j('#commentText').val();
		if( comment == '' ) {
			$j('#commentError').addClass('false').html('Comment is required.');
			return false;
		}
		$j("#submit").attr("disabled","disabled");
		var postData	=	$j("#comments").serialize();
		$j.ajax({
			type: "POST",
			url: '<?php echo Yii::app()->params->base_path; ?>user/addComments' ,
			data: postData,
			success: function(response) {
				var obj	=	$j.parseJSON(response);
				
				if( obj.status == 0 ){
					$j('#commentDiv').load("<?php echo Yii::app()->params->base_path;?>user/getComments/id/<?php echo $data['id'];?>");
					$j('#history').load("<?php echo Yii::app()->params->base_path;?>user/getItemHistory/id/<?php echo $data['id'];?>");
					document.getElementById("commentText").value = "";
					$j("#attachment").val('');
					$j('#attachmentNotice').html('');	
					$j("#submit").attr("disabled",false);
				} else {
					
					$j("#update-message").removeClass().addClass('errormsg');
					$j("#update-message").html(obj.message);
					$j("#update-message").fadeIn();
					$j("#submit").attr("disabled",false);
					setTimeout(function() {
						$j('#update-message').fadeOut();
					}, 10000 );
					
				}
			}
			
		});
	});
	
	$j('.status').click(function(){
		smoothScroll('mainWrapper');
		$j('#update-message').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
		
		var details	=	$j(this).attr('lang'),
			status	=	details.split('*');
			id	=	<?php echo $data['id'];?>;
			
		$j.ajax({
			url: '<?php echo Yii::app()->params->base_path;?>user/changeItemStatus/id/'+id+'/stat/'+status[0],
			cache: false,
			success: function(data)
			{
				var obj	=	$j.parseJSON(data);
				if(trim(data)=='logout')
				{
					$j('#mainContainer').html('');
					window.location=BASHPATH;
					return false;
				}
				if(obj.status == 0){
					$j('#mainContainer')
					.load('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/'+id+'/flag/'+status[1], function() {
						$j("#update-message").removeClass().addClass('msg_success');
						$j("#update-message").html('Status updated successfully');
						$j("#update-message").fadeIn();
						setTimeout(function() {
							$j('#update-message').fadeOut();
						}, 10000 );
					});
				}
			}
		});
	});
	
	$j('.closeIcon').click(function(){
		
	var details	=	$j(this).attr('lang'),
	id	=	details.split('*');
	value	=	$j(this).attr('rel');
	
	jConfirm('##_ASSIGNED_BY_ME_AJAX_CLOSE_TODO_##', 'Confirmation dialog', function(res){
		if(res == true){
			$j.ajax({
				url: '<?php echo Yii::app()->params->base_path;?>user/changeItemStatus/id/'+id[0]+'/stat/'+value,
				success: function(response){
					var obj	=	$j.parseJSON(response);
					if( obj.status == 0 ) {
						if( id[1] == 'close' ) {
							$j('#mainContainer')
							.load('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/'+id[0], function() {
								$j("#update-message").removeClass().addClass('msg_success');
								$j("#update-message").html('Status updated successfully');
								$j("#update-message").fadeIn();
								setTimeout(function() {
									$j('#update-message').fadeOut();
								}, 10000 );
							});
						}
					}
				}
			});
		}
	});
});
	
	$j('.remindAgain').click(function(){
		var data	=	$j(this).attr('lang');
		var details	=	data.split('*');
						
		jConfirm('Send reminder again?', 'Confirmation dialog', function(res){
			if(res == true){
				$j.ajax({
					url: '<?php echo Yii::app()->params->base_path;?>'+details[1]+'/itemId/'+details[0],
					data: 'json',
					success: function(response){
						var obj	=	$j.parseJSON(response);
						if(obj.status == 0) {
							$j("#update-message").removeClass().addClass('msg_success');
							$j("#update-message").html(obj.message);
							$j("#update-message").fadeIn();
							setTimeout(function() 
							{
								$j('#update-message').fadeOut();
							}, 10000 );
						}
					}
				});
			}
		});
	});
	

});
</script>
<script type="text/javascript">
function forceDownload(url) {
	  var ifrm = document.getElementById('frame1');
    ifrm.src = url;
}
function cancel( flag, url ) {
	if( flag == 0 ) {
		window.location.href	=	'<?php echo Yii::app()->params->base_path;?>user';
	} else {
		smoothScroll('mainContainer');
		$j('#mainContainer').load('<?php echo Yii::app()->params->base_path;?>user/'+url+'/moreflag/1');
	}
}
function addAttachFiles() {
	
	var base_path = '<?php echo Yii::app()->params->base_path;?>';
	var action = base_path +'user/attachment';
	$j('#attachmentNotice').html('<img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Uploading...');
	$j.ajaxFileUpload
	(
		{
			url:action,
			secureuri:false,
			fileElementId:'attachmentFile',
			dataType: 'json',
			data: {id:$j("#id").val(),YII_CSRF_TOKEN:csrfTokenVal},
			success: function (data, status)
			{
				$j("#attachment").val(data);
				$j('#attachmentNotice').html(data);	
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	);
}

</script>
<script type="text/javascript">
var $j = jQuery.noConflict();
var csrfTokenVal = '<?php echo Yii::app()->request->csrfToken;?>';
var basePath	=	'<?php echo Yii::app()->params->base_path;?>';

function queryTodoItem(){
	
	comment	=	$j('#commentText').val();
	if( comment == '' ) {
		$j('#commentError').addClass('false').html('Comment is required.');
		return false;
	}
	
	$j("#submit").attr("disabled","disabled");
	$j("#assignback").attr("disabled","disabled");
	
	var postData	=	$j("#comments").serialize();
	
	$j.ajax({
		url: basePath+'user/assignBack',
		data: postData,
		type: 'POST',
		success: function(response){
			var obj = parent.$j.parseJSON(response);
		
			if( obj.status == 0 ){
				
				$j('#mainContainer')
				.load('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $data['id'];?>', function() {
					$j("#update-message").removeClass().addClass('msg_success');
					$j("#update-message").html(obj.message);
					$j("#update-message").fadeIn();
					
				});
						
				setTimeout(function() {
				parent.$j('#update-message').fadeOut();
			}, 2000);
				
			} else {
				
				$j("#update-message").removeClass().addClass('errormsg');
				$j("#update-message").html(obj.message);
				$j("#update-message").fadeIn();
				$j("#submit").attr("disabled",false);
				$j("#assignback").attr("disabled",false);
			}
			
		}
	});
}
function setUrl(myurl) {
	smoothScroll('mainWrapper');
	$j('#update-message').removeClass();
	$j('#mainContainer').html('<div class="menuLoader"><img src="'+imgPath+'/spinner-small.gif" border="0" /> Loading...</div>').show();
	$j.ajax ({
		url: myurl,
		data: csrfToken,
		success: function(response)
		{
			if(trim(response)=='LOGOUT')
			{
				window.location=BASHPATH;
				return false;
			}
			<?php if(isset($_GET['from']) && $_GET['from'] == 'home') { ?>
			$j('#mainWrapper').html(response);
			<?php } else  { ?>
			$j('#mainContainer').html(response);
			<?php } ?>
			//inner tab menu
			$j('#update-message').html('');
			//close inner tab menu
			return false;
		}
	});
}
</script>
<iframe id="frame1" style="display:none"></iframe>
<div class="RightSide">
	<?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <div>
        <div id="update-message"></div>
        <div class="clear"></div>
        <ul class="titleList">
        	<li><label>##_DESCRIPTION_TITLE_##:</label>
                <span>
					<?php 
					echo $data['title'];
			?>                
                </span><p class="clear"></p>
            </li>
        	<li><label>##_DESCRIPTION_TODO_LIST_##:</label>
                <span><?php echo $data['listName']['name']; ?></span><p class="clear"></p>
            </li>
            <li><label>##_DESCRIPTION_DESC_##:</label>
            <span><?php
					echo $data['description'];
			 ?>
             </span><p class="clear"></p></li>
            
            <li><label>##_DESCRIPTION_ATTACH_##:</label>
            <span>
            <?php
            if(!isset($data['attachmentFile']) || $data['attachmentFile']== ''){
                echo 'No attachment';
            } else {
            ?>
            <a href="javascript:forceDownload('<?php echo Yii::app()->params->base_path;?>upload/getAttach/dir/<?php echo $data['attachmentDir'];?>/fileName/<?php echo $data['attachmentFile'];?>')" ><?php echo $data['attachmentFile'];?></a>
           
            <?php
            }?>
            </span><p class="clear"></p>
            </li>
            
            <li><label>##_DESCRIPTION_ASSIGN_BY_##:</label>
            <span>
            <?php 
            if($data['assignedBy'] == 0 || $data['assignedBy'] == Yii::app()->session['loginId']){
                echo 'me';
            } else {
                if(isset($data['assignedByEmail']) && $data['assignedByEmail'] != ''){
                    echo $data['assignedByFname']. ' ' . $data['assignedByLname'].' ['.$data['assignedByEmail'].']';
                }else{
                    echo $data['assignedByFname']. ' ' . $data['assignedByLname'];
                }
            }?>
            </span><p class="clear"></p>
            </li>
            
            <li><label>##_DESCRIPTION_ASSIGN_TO_##:</label>
            <span>
            <?php
            if($data['assignTo'] == Yii::app()->session['loginId']){
                echo 'me';
            } else {
                if(isset($data['assignedToEmail']) && $data['assignedToEmail'] != ''){
                    echo $data['assignedToFname']. ' ' . $data['assignedToLname'].' ['.$data['assignedToEmail'].']';
                }else{
                    echo $data['assignedToFname']. ' ' . $data['assignedToLname'];
                }
            }
			$generalObj=new General();
			$dueDate=$generalObj->pastdue($data['dueDate'],$data['myTimeZone']);
			
			?>
            </span><p class="clear"></p>
            </li>
            
            <li><label>##_DESCRIPTION_DUE_DATE_##:</label>
            <span style="color:<?php echo $dueDate['class'];?>;"><?php echo $dueDate['value']; ?></span><p class="clear"></p></li>
            
            <li><label>##_DESCRIPTION_STATUS_##:</label>
            <span>
            	<?php
				if($data['status'] == 1) {
					$value	=	'Open';
				} else if($data['status'] == 2) {
					$value	=	'QA';
				} else if($data['status'] == 3) {
					$value	=	'Done';
				} else {
					$value	=	'Close';
				}
				?>
                <?php
				
				if($data['assignTo'] == Yii::app()->session['loginId'] && $data['status'] != 4){
					if( $data['status'] == 1 ){ ?>
						<input type="checkbox" class="status" lang="3*<?php echo $data['flag'];?>" value="##_BTN_DONE_##" id="done" />
					<?php
					} 
					else if( $data['status'] == 3) { 
					?>
                    	<input type="checkbox" checked="checked" class="status" lang="1*<?php echo $data['flag'];?>" value="##_BTN_OPEN_##" id="open" />
					<?php
					}?>
				
				<?php
				} ?>
				<?php
				if($data['assignedBy'] == Yii::app()->session['loginId']) {
					
					if( $data['status'] == 1){ ?>
						<input type="checkbox" class="status" lang="3*<?php echo $data['flag'];?>" value="##_BTN_DONE_##" id="done" />
					
					<?php 
					 }
					if( $data['status'] == 4 || $data['status'] == 3 ){ ?>
						<input type="checkbox" checked="checked"  class="status" lang="1*<?php echo $data['flag'];?>" value="##_BTN_OPEN_##" id="open" />
					<?php 
					}
					
				}
                ?>
                <?php echo $value;?>
            </span><p class="clear"></p></li>
            
        </ul>
        <div class="clear"></div>
    </div>
   	<div> 
        <div class="floatLeft">
             <?php echo CHtml::beginForm('','post',array('id' => 'comments','name' => 'comments','enctype'=>'multipart/form-data')) ?>
            <div id="newCommentsDiv">
                <h5>##_DESCRIPTION_ADD_COMMENT_##<span id="commentError"></span></h5>
                <div class="field">
                   <input type="hidden" value="<?php echo $data['id'];?>" name="id" />
                    <input type="hidden" value="<?php echo $data['id'];?>" name="itemId" />
                    <input type="hidden" value="<?php echo $data['listId'];?>" name="listId" />
                    <input type="hidden" value="<?php echo Yii::app()->session['userId'];?>" name="userId" />
                    <textarea name="comments" id="commentText" class="textarea width318" ></textarea>
                </div>
                <input type="file" onchange="addAttachFiles()"  name="attachmentFile" id="attachmentFile" /><span id="attachmentNotice">&nbsp;</span>
                <input type="hidden" name="attachment" id="attachment" value="" />
                <div class="fieldBtn">
                    <input type="button" name="submit" id="submit" class="btn" value="##_BTN_SUBMIT_##" />
                    <?php
                        if($data['assignTo'] == Yii::app()->session['loginId'] && $data['status'] != 3 && $data['status'] != 4){ ?>
                     <a href="<?php echo Yii::app()->params->base_path;?>user/reassignTask/id/<?php echo $data['id'];?>/from/description" id="reassign" class="reassign"title="Reassign"><input type="button" class="btn" value="##_BTN_REASSIGN_##" id="assign" /></a>
					
                    <?php if($data['status'] == 1 && $data['assignedBy'] != 0 ) { ?>
                        <a  lang="<?php echo $data['id'];?>" onclick="queryTodoItem()" title="Assign back">
                            <input type="button"  class="btn" value="##_BTN_ASSIGN_BACK_##" id="assignback" />
                        </a>
                    
                    <?php } } ?>
                     <?php
                        if($data['assignedBy'] == Yii::app()->session['loginId'] && $data['status']!=4 ){ ?>
                     <a href="<?php echo Yii::app()->params->base_path;?>user/reassignTask/id/<?php echo $data['id'];?>/from/description" id="reassign" class="reassign" title="Reassign"><input type="button" class="btn" value="##_BTN_REASSIGN_##" id="assign" /></a>
                      
                      <a href="javascript:;" class="remindAgain" lang="<?php echo $data['id'] . '*user/remindAgain';?>" title="##_ASSIGNED_BY_ME_AJAX_EMAIL_##"><input type="button" class="btn" value="##_REMIND_ME_##"  id="reminder"/></a>
                    <?php } ?>
                    
                    <?php if($data ['status'] != 4 && isset(Yii::app()->session['loginId']) && Yii::app()->session['loginId']==$data['creater']){?>
					 <a href="javascript:;" class="closeIcon" rel="4" lang="<?php echo $data['id'].'*close';?>" id="delete_<?php echo $data['id'];?>" title="##_ASSIGNED_BY_ME_AJAX_DELETE_##"><input type="button" class="btn" value="##_BTN_DELETE_##" id="assign" /></a><?php } ?>
                    
                    <a id="back" href="javascript:;" onclick="cancel('<?php if(isset($data['flag']) && $data['flag'] != '') {echo $data['flag']; }?>', '<?php if(isset($data['url']) && $data['url'] != '') { echo $data['url'];}?>')" ><input type="button" name="back" value="##_BTN_BACK_##" class="btn"  /></a>
                </div>
                
            </div>
            <?php echo CHtml::endForm(); ?>
        </div>
        <div id="history"></div>
        <div class="clear"></div>
    </div>
    <div id="commentDiv"></div>
</div>