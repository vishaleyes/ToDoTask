<script type="text/javascript" src="<?php echo Yii::app()->params->base_url;?>js/jquery.cleditor.min.js"></script>
<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?> 
<h1><a href="<?php echo Yii::app()->params->base_path;?>admin/apiFunctions">Functions</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <a href="<?php echo Yii::app()->params->base_path;?>admin/functionParametes/&fn_id=<?php echo $fun_ref_id; ?>">Parameters</a> <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> <?php echo $title;?></h1>
                   

<div class="content-box func-para">
	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/addFunctionParameter/fn_id/'.$fun_ref_id,'post',array('id' => 'parameterForm','name' => 'parameterForm')) ?>
    	<div class="func-para">
            <div class="signup-form">
                <div class="field-area">
                    <div><label>Function<span class="star">*</span></label></div>
                    <div>
                        <select name="fn_id" id="fn_id"  class="select-box">
                         <?php 
						foreach($functions as $functions){ 
						?>
                            <option <?php if(isset($fun_ref_id) && $functions['id']==$fun_ref_id) {?> selected="selected" <?php } ?> value="<?php echo $functions['id']; ?>"><?php echo $functions['function_name']; ?></option> 
                        <?php
						}?>
                        </select>					
                        <span id="fullnameerror"></span>
                    </div>
                </div>
                <div class="field-area">
                    <div><label>Function Parameter Name<span class="star">*</span></label></div>
                    <div>
                        <input  type="text" name="fnParamName" id="fnParamName" value="<?php echo $result['fnParamName']; ?>" class="textbox width147" />							
                        <span id="fullnameerror"></span>
                    </div>
                </div>
                <div class="field-area">
                    <div><label>Function Parameter Description<span class="star">*</span> </label></div>
                    <div>
                    	<?php
						if(!isset($result['fnParamDescription'])){ 
							$result['fnParamDescription']	=	'';
						}
										
						$this->widget('application.extensions.cleditor.ECLEditor', array(
						'name'=>'fnParamDescription',
						'value'=>$result['fnParamDescription'],
						));
						?>
						
                        <span id="emailerror"></span>
                    </div>
                </div>
                <div class="field-area">
                    <div><label>Function Parameter Type<span class="star">*</span></label></div>
                    <div>
                        <input type="radio" name="ParamType"  id="ParamType1" value="1" <?php if(isset($result['ParamType']) && $result['ParamType']==1){ ?>  checked="checked" <?php }else{ ?>checked="checked" <?php } ?>/>Required
                        <input type="radio" name="ParamType" <?php if(isset($result['ParamType']) && $result['ParamType']==0){ ?> checked="checked" <?php } ?>  id="ParamType" value="0"/>Optional							
                        <span id="fullnameerror"></span>
                    </div>
                </div>
                                
                <div class="field-area">
                    <div><label>Example<span class="star">*</span> </label></div>
                    <div>
                        <textarea name="example" id="example" class="textarea"><?php if(isset($result['example'])){ echo $result['example']; } ?> </textarea>
                        <span id="emailerror"></span>
                    </div>
                </div>
                
                <div class="field-area">
                    <div><label>UI Validation Rules<span class="star">*</span> </label></div>
                    <div>
                        <textarea name="uiValidationRule" id="uiValidationRule" class="textarea"><?php if(isset($result['uiValidationRule'])){ echo $result['uiValidationRule']; } ?> </textarea>
                        <span id="emailerror"  ></span>
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
        </div>
        <input type="hidden" <?php if(isset($result['id'])){ ?> value="<?php echo $result['id']; ?>" <?php } ?> name="id"/>
    <?php echo CHtml::endForm();?>
</div>