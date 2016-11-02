<?php /* Smarty version Smarty-3.1.7, created on 2012-01-31 11:36:29
         compiled from "D:\xampp\htdocs\todooliapp\protected\views\user\about.tpl" */ ?>
<?php /*%%SmartyHeaderCode:214334f2784e5c506a4-54153952%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e648d65195f1de2e76608ef161e7a5b6ad9595b' => 
    array (
      0 => 'D:\\xampp\\htdocs\\todooliapp\\protected\\views\\user\\about.tpl',
      1 => 1327848631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214334f2784e5c506a4-54153952',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ajax' => 0,
    'messageStack' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_4f2784e5cb898',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2784e5cb898')) {function content_4f2784e5cb898($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['ajax']->value==1){?>

<div class="content-box" >
    <div class="content-box-header">
        <h3 style="cursor: s-resize;">##_ABOUT_HEADER_##</h3>
    </div> 
    <div class="middle">
    	<div class="field-area">
        	##_ABOUT_DESCRIPTION_##
        </div>
    </div>

<?php }else{ ?>
    <div class="middle">
        <div class="error-msg-area">
            <?php if ($_smarty_tpl->tpl_vars['messageStack']->value->size>0){?>		   
                    <div class="" id="msgbox"><?php echo $_smarty_tpl->tpl_vars['messageStack']->value->output();?>
</div>		  
           <?php }?>    
        </div>  
            <div class="bg-pattern">
                <div class="wrapper">
                <div class="about-content">
                    <h2>##_ABOUT_HEADER_##</h2>
                        ##_ABOUT_DESCRIPTION_##
                </div>              
                </div>
            </div>
    </div>
<?php }?>
<?php }} ?>