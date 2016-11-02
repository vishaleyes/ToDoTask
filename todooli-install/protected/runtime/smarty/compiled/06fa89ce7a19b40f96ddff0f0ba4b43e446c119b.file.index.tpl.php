<?php /* Smarty version Smarty-3.1.7, created on 2012-01-31 11:14:03
         compiled from "D:\xampp\htdocs\todooliapp\protected\views\user\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:301244f277fa366fde3-46485876%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06fa89ce7a19b40f96ddff0f0ba4b43e446c119b' => 
    array (
      0 => 'D:\\xampp\\htdocs\\todooliapp\\protected\\views\\user\\index.tpl',
      1 => 1327986313,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '301244f277fa366fde3-46485876',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f277fa3701fa',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f277fa3701fa')) {function content_4f277fa3701fa($_smarty_tpl) {?>
<div class="middle-section">
    <div class="error-msg-area" style="margin:10px auto; width:960px;">
     
    </div>
    <div class="clear"></div>
    <div class="wrapper mainlogin">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
        	<tr><td>&nbsp;</td></tr>
            <tr>
                <td style="valign:middle; width:56%;">
                    <h6>##_HOME_SLOGAN_##</h6>
                    <div class="option optionEmployer">
                        <div><a href="<<?php ?>?php echo Yii::app()->theme->baseUrl; ?<?php ?>>user/signUpMain/Employer" class="mainbtn">##_EMPLOYER_SIGNUP_BUTTON_##</a></div>
                        
                    </div>
                </td>
                <td style="valign:middle;width:44%;">
                    <div class="signup-box">
                        <div class="signup-box-bg-less">
                            <div class="signup-box-bg-img">
                                <form action="<<?php ?>?php echo Yii::app()->theme->baseUrl; ?<?php ?>>user/signUpMain/Seeker" name="signUpSeeker" id="signUpSeeker" method="post" >
                                    <h5><b>##_HOME_NEW_TO_FJN_## </b>##_HOME_SEEKER_SIGNUP_##</h5>
                                    <div><input  type="text" name="fName" id="fName" class="textbox width159" value="##_HOME_FIRST_NAME_##" onfocus="if(this.value=='##_HOME_FIRST_NAME_##')this.value=''; this.style.color='black';" onblur="if(this.value==''){ this.value = '##_HOME_FIRST_NAME_##'; this.style.color='';}"  />
                           <input type="text" name="lName" id="lName" class="textbox width159" value="##_HOME_LAST_NAME_##"  onfocus="if(this.value=='##_HOME_LAST_NAME_##')this.value=''; this.style.color='black';" onblur="if(this.value==''){ this.value = '##_HOME_LAST_NAME_##'; this.style.color='';}"  />
                        </div>
                                    <div><input type="text"  name="email" id="email" maxlength="256" class="textbox" value="##_HOME_EMAIL_##" onfocus="if(this.value=='##_HOME_EMAIL_##')this.value=''; this.style.color='black';" onblur="if(this.value==''){ this.value = '##_HOME_EMAIL_##'; this.style.color='';}" /></div>
                                    <div><input type="text"  name="phoneNumber" id="phoneNumber" class="textbox" value="##_HOME_PHONE_NUMBER_##" onfocus="if(this.value=='##_HOME_PHONE_NUMBER_##')this.value=''; this.style.color='black';" onblur="if(this.value==''){ this.value = '##_HOME_PHONE_NUMBER_##'; this.style.color='';}" /></div>
                                    <div id="mypassword"><input type="password" maxlength="20" name="password"  id="password" class="textbox"
                                     style="background:#ffffff url(public/images/##_PASSWORD_IMAGE_##) no-repeat left center;" onclick="this.style.background='#ffffff';" onblur="changeBG()" onfocus="this.style.background='#ffffff';this.style.color='black';" /></div>
                                    <div align="right"><input type="submit" class="btn-big signup-btn-big" value="##_HOME_SIGNUP_##" /></div>
                                </form>
                            </div>						
                        </div></div>
                </td>
            </tr>
        </table>
        <div class="clear"></div>                
    </div>
    <div class="clear"></div>
</div><?php }} ?>