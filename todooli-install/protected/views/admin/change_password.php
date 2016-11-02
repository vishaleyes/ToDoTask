<script type="text/javascript">
    var $j = jQuery.noConflict();
</script>

<script type="text/javascript" >
function validatePassword()
{
	$j('#passworderror').removeClass();
	$j('#passworderror').html('');
	var password=document.getElementById('password').value;
	if(password=='')
	{
		$j('#passworderror').addClass('false');
		$j('#passworderror').html('Please enter password.');
		return false;
	}
	else if(password.length < 6)
	{
		$j('#passworderror').addClass('false');
		$j('#passworderror').html('Password must be greater than 6 character.');
		return false;
	}
	else
	{
		$j('#passworderror').removeClass();
		$j('#passworderror').addClass('true');
		$j('#passworderror').html('Ok');
		return true;
	}
}

function validateoPassword()
{
	$j('#opassworderror').removeClass();
	$j('#opassworderror').html('');
	var password=document.getElementById('opassword').value;
	if(password=='')
	{
		$j('#opassworderror').addClass('false');
		$j('#opassworderror').html('Please enter password.');
		return false;
	}
	else if(password.length < 6)
	{
		$j('#opassworderror').addClass('false');
		$j('#opassworderror').html('Password must be greater than 6 character.');
		return false;
	}
	else
	{
		$j('#opassworderror').removeClass();
		$j('#opassworderror').addClass('true');
		$j('#opassworderror').html('Ok');
		return true;
	}
}

function validateCPassword()
{
	$j('#cpassworderror').removeClass();
	$j('#cpassworderror').html('');
	var cpassword=document.getElementById('cpassword').value;
	var password=document.getElementById('password').value;

	if(password=='')
	{
		$j('#cpassworderror').addClass('false');
		$j('#cpassworderror').html('Please enter confirm paswword.');
		return false;
	}
	else if(password!=cpassword)
	{
		$j('#cpassworderror').addClass('false');
		$j('#cpassworderror').html('Password and confirm paswword not match.');
		return false;
	}
	else
	{
		$j('#cpassworderror').removeClass();
		$j('#cpassworderror').addClass('true');
		$j('#cpassworderror').html('Ok');
		return true;
	}
}
function validateAll()
{
	var flag=0;
	
	if(!validateoPassword())
	{
		return false;
	}
	if(!validatePassword())
	{
		return false;
	}
	if(!validateCPassword())
	{
		return false;
	}
	return true;
}
</script>  


<?php if(Yii::app()->user->hasFlash('success')): ?>                                
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<div class="pageNav">
</div>

<h1>
	 Change Password
</h1>
<div class="container" id="content">        
    <div id="employee">
        <div class="content-box func-para">
        	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'admin/changeAdminPassword','post',array('id' => 'edit_login','name' => 'edit_login','onsubmit' => 'return validateAll();')) ?>
                <table cellpadding="5" cellspacing="5" border="0" class="search-table" width="100%">
                    <?php 
					if(isset($_GET['id']) && $_GET['id'] != '')
					{
					?>
                    <input type="hidden" name="user_id" value="<?php echo $id;?>" >
                    <?php }else { ?>
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                    <?php } ?>
                    <tr>
                        <td align="right">Old Password :</td>
                        <td>
                            <input type="password"  name="opassword" class="textbox" id="opassword" onkeyup="validateoPassword()" />
                            <span id="opassworderror"></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" align="right">New Password :</td>
                        <td width="85%">
                            <input type="password"  name="password" class="textbox" id="password" onkeyup="validatePassword()" />
                            <span id="passworderror"></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">Confirm Password :</td>
                        <td>
                            <input type="password"  name="cpassword" class="textbox" id="cpassword" onkeyup="validateCPassword()" />
                            <span id="cpassworderror"></span>
                        </td>
                    </tr>
                    <?php
                    if(isset($data['loginIdType']) && $data['loginIdType'] == '0'){?>
                        <tr>
                            <td align="right">Send Mail :</td>
                            <td><input type="checkbox" value="1" name="email"/></td>
                        </tr>
                    <?php
                    }?>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="Save" value="Save" class="btn">
                            <input name="cancel" type="reset"  value="Cancel" onclick="javascript:history.go(-1)"  class="btn"/>
                        </td>
                    </tr>
                </table>
            <?php echo CHtml::endForm();?>
        </div>
    </div>
</div>