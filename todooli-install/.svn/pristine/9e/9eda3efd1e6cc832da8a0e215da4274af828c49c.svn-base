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
	<a href="<?php echo Yii::app()->params->base_path;?>admin/apiFunctions">Functions</a> 
    <img src="<?php echo Yii::app()->params->base_url;?>images/path-arrow.png" alt="" border="0" /> Resource
</h1>
	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/apiResource/fn_id/'.$fn_id,'post',array('id' => 'functionForm','name' => 'functionForm')) ?>
        <div class="content-box func-para">
            <div class="field-area">
                <div><label>Resource url<span class="star">*</span></label></div>
                <div>
                    <input  type="text" name="resource_url" id="resource_url" <?php if(isset($data['resource_url'])){ ?> value="<?php echo $data['resource_url'];?>" <?php } ?> class="textbox width147" />							
                    <span id="fullnameerror"></span>
                </div>
            </div>
            
            <div class="field-area">
                <div><label>Authentication<span class="star">*</span></label></div>
                
                <div>
                    <input type="radio" name="authentication" id="authentication" value="1" <?php if(isset($data['authentication']) && $data['authentication']==1){ ?> checked="checked" <?php }else{ ?>checked="checked" <?php } ?>/>Yes	
                    <input type="radio" name="authentication" <?php if(isset($data['authentication']) && $data['authentication']==0){ ?> checked="checked" <?php } ?>  id="authentication1" value="0"/>Unpublish
                    <span id="fullnameerror"></span>
                </div>
            </div>
            
            <div class="field-area">
                <div><label>Response formats<span class="star">*</span></label></div>
                <div>
                <input type="radio" name="response_formats" <?php if(isset($res_fr_selected) && $res_fr_selected==1) {?>  checked="checked" <?php }else{ ?>checked="checked" <?php } ?> id="response_formats" value="1"/><?php echo $res_fr_val[0]; ?>
                <input type="radio" name="response_formats" <?php if(isset($res_fr_selected) && $res_fr_selected==2){ ?> checked="checked" <?php } ?>  id="response_formats" value="2"/><?php echo $res_fr_val[1]; ?>
                <input type="radio" name="response_formats" <?php if(isset($res_fr_selected) && $res_fr_selected==3){ ?> checked="checked" <?php } ?> id="response_formats" value="3"/><?php echo $res_fr_val[2]; ?>
                    <span id="fullnameerror"></span>
                </div>
            </div>
            
            <div class="field-area">
                <div><label>Http methods<span class="star">*</span></label></div>
                <div>
                
                <input type="radio" name="http_methods"  id="http_methods" <?php if(isset($http_mth_selected) && $http_mth_selected==0) {?>  checked="checked" <?php }else{ ?>checked="checked" <?php } ?> value="0"/><?php echo $http_mth_val[0]; ?>
                <input type="radio" name="http_methods"  id="http_methods" <?php if(isset($http_mth_selected) && $http_mth_selected==1){ ?> checked="checked" <?php } ?> value="1"/><?php echo $http_mth_val[1]; ?>
                <input type="radio" name="http_methods"  id="http_methods" <?php if(isset($http_mth_selected) && $http_mth_selected==2){ ?> checked="checked" <?php } ?> value="2"/><?php echo $http_mth_val[2]; ?>
                    <span id="fullnameerror"></span>
                </div>
            </div>
            
            <div class="field-area">
                <div><label>Example <span class="star">*</span> </label></div>
                <div>
                	<?php
					if(!isset($data['example'])){ 
						$data['example']	=	'';
					}
									
					$this->widget('application.extensions.cleditor.ECLEditor', array(
					'name'=>'example',
					'value'=>$data['example'],
					));
					?>
                    <span id="emailerror"  ></span>
                </div>
            </div>
            
             <div class="field-area">
                <div><label>Response Result <span class="star">*</span> </label></div>
                <div>
                	<?php
					if(!isset($data['response'])){ 
						$data['response']	=	'';
					}
									
					$this->widget('application.extensions.cleditor.ECLEditor', array(
					'name'=>'response',
					'value'=>$data['response'],
					));
					?>
					<span id="emailerror"  ></span>
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
            <input type="hidden" <?php if(isset($data['id'])){ ?> value="<?php echo $data['id']; ?>" <?php } ?> name="id"/>
        <?php echo CHtml::endForm();?>