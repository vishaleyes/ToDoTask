<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.cleditor.min.js"></script>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

<h1>
	<a href="<?php echo Yii::app()->params->base_path;?>admin/apiModules">Modules</a> 
    <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?>
</h1>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/addApiModule','post',array('id' => 'functionForm','name' => 'functionForm')) ?>
    <div class="content-box func-para">
        <div class="field-area">
            <div><label>Module Name<span class="star">*</span></label></div>
            <div>
                <input  type="text" name="label" id="label" <?php if(isset($result['label'])){ ?> value="<?php echo $result['label']; ?>" <?php } ?> class="textbox width147" />							
                <span id="fullnameerror"></span>
            </div>
        </div>
        <div class="field-area">
            <div><label>Module Description <span class="star">*</span> </label></div>
            <div>
            <?php
			if(!isset($result['description'])){ 
				$result['description']	=	'';
			}
							
			$this->widget('application.extensions.cleditor.ECLEditor', array(
			'name'=>'description',
			'value'=>$result['description'],
			));
			?>
            
			<span id="emailerror"></span>
            </div>
        </div>
        <div class="field-area">
            <div><label>Published<span class="star">*</span></label></div>
            <div>
                <input type="radio" name="published" id="published" value="1" <?php if(isset($result['published']) && $result['published']==1){ ?>  checked="checked" <?php }else{ ?>checked="checked" <?php } ?>/>Publish	
                <input type="radio" name="published" <?php if(isset($result['published']) && $result['published']==0){ ?> checked="checked" <?php } ?> id="published" value="0"/>Unpublish
                <span id="fullnameerror"></span>
            </div>
        </div>
            
        <div class="field-area">
            <div class="terms">
                <div>
                    <input type="submit" name="FormSubmit" id="FormSubmit" class="btn"  value="Submit" />
                    <input name="cancel" type="reset" class="btn" value="Cancel" onclick="javascript:history.go(-1)" />
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <input type="hidden" <?php if(isset($result['id'])){ ?> value="<?php echo $result['id']; ?>" <?php } ?> name="id"/>
<?php echo CHtml::endForm();?>