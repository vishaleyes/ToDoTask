<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.cleditor.min.js"></script>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>   

<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/apiModules">Module</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <a href="javascript:history.go(-1);">Functions</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?></h1>
<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/addApiFunction','post',array('id' => 'functionForm','name' => 'functionForm')) ?>
        <div class="content-box func-para">
            <div class="field-area">
                <div><label>Module<span class="star">*</span></label></div>
                <div>
                    <select name="moduleId" id="moduleId"  class="select-box">
                    <?php 
					foreach($modules as $modules){ 
					?>
                        <option <?php if(isset($result['moduleId']) && $modules['id']==$result['moduleId']) {?> selected="selected" <?php } ?> value="<?php echo $modules['id']; ?>"><?php echo $modules['label']; ?></option> 
                    <?php
					}?>
                    </select>					
                    <span id="fullnameerror"></span>
                </div>
            </div>
            <div class="field-area">
                <div><label>Function Name<span class="star">*</span></label></div>
                <div>
                    <input  type="text" name="function_name" id="function_name" <?php if(isset($result['function_name'])){ ?> value="<?php echo $result['function_name']; ?>" <?php } ?> class="textbox width147" />							
                    <span id="fullnameerror"></span>
                </div>
            </div>
            <div class="field-area">
                <div><label>Function Description <span class="star">*</span> </label></div>
                <div>
                	
                	<!--<textarea width=800 height=200 class="ckeditor" toolbar=Basic name='fn_description'><?php if(isset($result['fn_description'])){ echo $result['fn_description']; } ?>  </textarea>-->
                    <?php

					if(!isset($result['fn_description'])){ 
						$result['fn_description']	=	'';
					}
									
					$this->widget('application.extensions.cleditor.ECLEditor', array(
					'name'=>'fn_description',
					'value'=>$result['fn_description'],
					));
					
                   ?>
                    <span id="emailerror"  ></span>
                </div>
            </div>
            <div class="field-area">
                <div><label>Published<span class="star">*</span></label></div>
                
                <div>
                    <input type="radio" name="published" id="published" value="1" <?php if(isset($result['published']) && $result['published']==1){ ?>  checked="checked" <?php }else{ ?>checked="checked" <?php } ?>/>Publish	
                    <input type="radio" name="published" <?php if(isset($result['published']) && $result['published']==0){ ?> checked="checked" <?php } ?> id="published" value="0"/>Unpublish	<br /><br />					
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