
<div class="title">##_ASSIGN_BACK_##</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>

<div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
<div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
<div class="clear"></div>
<?php endif; ?>
<div class="field-area">
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/assignBack','post',array('id' => 'queryTodo','name' => 'queryTodo')) ?>
<input type="hidden" value="<?php echo $data;?>" name="id" />
<div class="field">
    <div id="txtNewUser"><label>##_ASSIGN_BACK_COMMENT_##<span id="commentError"></span></label>
        <textarea name="comments" id="commentText" class="textarea width318" ></textarea>
    </div>
    <div class="clear"></div>
</div>
<div class="fieldBtn">
    <input type="submit" class="btn" name="querySubmit" value="##_BTN_SUBMIT_##"  />
</div>
<?php echo CHtml::endForm(); ?>
</div>