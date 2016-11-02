<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
</script>
<script type="text/javascript">
var $j = jQuery.noConflict();
var csrfTokenVal = '<?php echo Yii::app()->request->csrfToken;?>';
var basePath	=	'<?php echo Yii::app()->params->base_path;?>';

function queryTodoItem(){
	var postData	=	$j('#queryTodo').serialize(),
		comment	=	$j('#commentText').val();
	
	if( comment == '' ) {
		$j('#commentError').addClass('false').html('Comment is required.');
		return false;
	}
	
	$j.ajax({
		url: basePath+'user/assignBack',
		data: postData,
		type: 'POST',
		success: function(response){
			var obj = parent.$j.parseJSON(response);
			if(obj.status == 0) {
				parent.$j("#update-message").removeClass().addClass('msg_success');
				parent.$j("#update-message").html(obj.message);
				parent.$j("#update-message").fadeIn();
				parent.$j.fancybox.close();
				
			} else {
				parent.$j("#update-message").removeClass().addClass('error-msg');
				parent.$j("#update-message").html(obj.message);
				parent.$j("#update-message").fadeIn();
				parent.$j.fancybox.close();
			}
			setTimeout(function() {
				parent.$j('#update-message').fadeOut();
			}, 100 );
		}
	});
}
</script>
<h2>##_ASSIGN_BACK_##</h2>
<?php echo CHtml::beginForm('','post',array('id' => 'queryTodo','name' => 'queryTodo')) ?>
<input type="hidden" value="<?php echo $data;?>" name="id" />
<div class="field">
    <div id="txtNewUser"><label>##_ASSIGN_BACK_COMMENT_##<span id="commentError"></span></label>
        <textarea name="comments" id="commentText" class="textarea width318" ></textarea>
    </div>
    <div class="clear"></div>
</div>
<div class="fieldBtn">
    <input type="button" class="btn" name="querySubmit" value="##_BTN_SUBMIT_##" onclick="queryTodoItem()" />
</div>
<?php echo CHtml::endForm(); ?>