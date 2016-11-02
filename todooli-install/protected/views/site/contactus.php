<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/contactus.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js"></script>
<script type="text/javascript">
var bas_path = "<?php echo Yii::app()->params->base_path; ?>";
</script>


<div class="wrapper-big">
    <div class="logo-wrap1">
        <a href="<?php echo Yii::app()->params->base_path;?>user/index"><img src="<?php echo Yii::app()->params->base_url;?>images/logo/logo.png" alt="" border="0" /></a>
    </div>
    <div class="right-text">
    	<div>
			<?php if(Yii::app()->user->hasFlash('success')): ?>
                <div class="error-msg-area">
                    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
                </div>
            <?php endif; ?>
            <?php if(Yii::app()->user->hasFlash('error')): ?>
                <div class="error-msg-area">
                    <div class="errormsg"><?php echo Yii::app()->user->getFlash('error'); ?></div>
                </div>
            <?php endif; ?>
            <div class="clear"></div>    
        </div>
        <div class="floatLeft">
        <h2>##_CONTACT_HEADER_##</h2>
			<?php echo CHtml::beginForm(Yii::app()->params->base_path.'site/contactus','post',array('id' => 'contactusform','name' => 'contactusform','onsubmit' => 'return validateAll();')) ?>
                <div>
                    <div class="field">
                        <label>##_CONTACT_NAME_##<span>*</span><span id="nameerror"></span></label>
                        <input type="text" name="name" id="name" class="textbox" value="<?php echo $name; ?>" onkeyup="validateName()" onblur="validateName();" onfocus="this.style.color='black';" />
                    </div>
                    <div class="clear"></div>
                    
                    <div class="field">
                        <label>##_CONTACT_EMAIL_##<span>*</span> <span id="emailerror"></span></label>
                            <input type="text" maxlength="256" name="email" id="email" class="textbox" value="<?php echo $email; ?>"  onkeyup="validateEmail()" onblur="validateEmail()" onfocus="this.style.color='black';" />
                    </div>
                    <div class="clear"></div>
                    
                    <div class="field">
                        <label>##_CONTACT_COMMENT_##<span>*</span> <span id="commenterror"></span></label>
                        <textarea  name="comment" id="comment"  onkeyup="validateComment()"  cols="40" class="textarea" rows="5" onfocus="this.style.color='black';" ><?php echo $comment; ?></textarea>
                    </div>  
                    <div class="clear"></div>
                    
                    <div class="field">
                        <label>##_CAPTCHA_##<span>*</span></label>
                        <div class="captcha1">
                            <?php $this->widget('CCaptcha');
							 ?>
                            <div class="clear"></div>
                            <?php echo Chtml::textField('verifyCode',''); ?>
                        </div>
                        <div class="clear"></div>
                    </div> 
                    <div class="clear"></div>
                    
                    <div class="fieldBtn">
                        <input type="submit"  name="FormSubmit" id="FormSubmit" class="btn"  value="##_BTN_SUBMIT_##" />
                    </div>
                </div>
            <?php echo CHtml::endForm(); ?> 
        </div>
        <div class="colRight">
            <div class="addressLocation">
                <h2>##_CONTACT_LOCATION_##</h2>
                <div class="field">
                    <label>##_CON_ADD_USA_##</label>
                    <p>##_CON_ADD_USA_HEAD_##<br />
                    	##_CON_ADD_USA_1_##<br />
                       ##_CON_ADD_USA_2_##<br /> ##_CON_ADD_USA_3_##<br />
                       <b>##_CON_ADD_NO_##:</b>##_CON_ADD_USA_4_##<br />
                       <b>##_CON_ADD_EMAIL_##</b> <a href="mailto:info@todooli.com">##_CON_ADD_EMAIL_SEND_##</a><br /><br />
                    </p>
                </div>
                <div class="field">
                    <label>##_CON_ADD_INDIA_##</label>
                    <p>##_CON_ADD_INDIA_1_##<br />
                    ##_CON_ADD_INDIA_2_##<br />
                    ##_CON_ADD_INDIA_3_##<br />
                    ##_CON_ADD_INDIA_4_##<br /> ##_CON_ADD_INDIA_5_##<br />
                    <b>##_CON_ADD_NO_##:</b>##_CON_ADD_INDIA_6_## <br />
                    <b>##_CON_ADD_EMAIL_##</b> <a href="mailto:info@todooli.com">##_CON_ADD_EMAIL_SEND_##</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div> 
    <div class="clear"></div>             
</div>
<script type="text/javascript">
$j(document).ready(function () {
	if( $j('.errormsg').html() != '' ) {
		setTimeout(function() {
			$j('.errormsg').fadeOut();
		}, 10000 );
	}
});
</script>