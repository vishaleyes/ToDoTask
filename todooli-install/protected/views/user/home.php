

 <!-- Remove select and replace -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jquery.jeditable.js" ></script>
<!-- Dialog Popup Js -->
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/j.min.Dialog.js" ></script>		
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/jDialog.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/smoothscroll.js"></script>
<script type="text/javascript">
$j(document).ready(function(){
	
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/leftview','leftview');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/inviteAjax','inviteAjaxBox');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/remindersAjax','reminderAjaxBox');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/listAjax<?php if(isset($_GET['list'])){ echo '/list/'.$_GET['list'];}?>','listAjaxBox');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/itemAjax<?php if(isset($_GET['list'])){ echo '/list/'.$_GET['list'];}?>','itemAjaxBox');
	
	 
	//change password popup
	$j("#change_password").fancybox(
	{	
		'titlePosition'	 : 'inside',
		'transitionIn'	 : 'none',
		'transitionOut'	 : 'none',		
		'width' : 600,
 		'height' : 400	
	});
	
	var firatFlagCounter=0;
	var openTodo=0;
	var closeTodo=0;
	var resolveTodo=0;
	var invites=0;
	var list=0;
	var todoStatus=0;
	var currentPage=0;
	var extraPara="";
	var assignBySearch='';
	var assignToSearch='';
	 window.assignBySearch='';
	 window.assignToSearch='';
	window.list=<?php echo isset($_GET['list'])?$_GET['list']:0;?>;
	//window.todoStatus=0;
	window.currentPage=0;
	window.extraPara="&<?php echo isset($_GET['keyword'])?'keyword='.$_GET['keyword'].'&':'';?>";
	window.firatFlagCounter=0;
	reloadHomeByListFirst();
	var autoRefreshMain=setInterval(function()
	{
		window.firatFlagCounter=window.firatFlagCounter+1;
		$j.ajax({			
			type: 'POST',
			url: "<?php echo Yii::app()->params->base_path;?>user/GetUpdatedCount",
			data: {YII_CSRF_TOKEN:csrfTokenVal},
			cache: false,
			success: function(data)
			{
				if(data=="logout")
				{
					window.location.href = '<?php echo Yii::app()->params->base_path;?>';
					return false;	
				}
				var data = $j.parseJSON(data);
				
					if(window.firatFlagCounter>2)
					{
						if(window.openTodo!=data.open || window.closeTodo!=data.close || window.resolveTodo!=data.resolved)
						{
							if( window.currentPage == 1 ) {
								loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/myTodoItem/moreflag/1/currentList/'+window.list,'mainContainer');
							} else if( window.currentPage == 2 ) {
								loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/assignedByMeTodoItem/moreflag/1/currentList/'+window.list,'mainContainer');
							} else if( window.currentPage == 3 ) {
								loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/otherTodoItem/moreflag/1/currentList/'+window.list,'mainContainer');
							} else {
								loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/myTodoItem','items');
								loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/assignedByMeTodoItem','assignedByMeTodoItem');
							}
						}
						if(window.invites!=data.invite)
						{			
							loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/inviteAjax','inviteAjaxBox');
						}
					}
					window.openTodo=data.open;	
					window.closeTodo=data.close;
					window.resolveTodo=data.resolved;
					window.invites=data.invite;
				
			}
		});
	},10000);
});

function reloadHomeByList( flag, table )
{
	flag = typeof flag !== 'undefined' ? flag : 0;
	mylist=$j('#txtSearchListDP').val();
	//mylistStatus=$j('#txtSearchStatusDP').val();
	window.list=mylist;
	//window.todoStatus=mylistStatus;
	assignBySearch='';	
	assignToSearch='';
	if(flag==0)
	{
	assignBySearch= document.getElementById('assignBySearch').value;
	if(assignBySearch=='##_HOME_SEARCH_ASSIGN_BY_##')
	{
		assignBySearch='';
	}
	
	assignToSearch= document.getElementById('assignToSearch').value;
	if(assignToSearch=='##_HOME_SEARCH_ASSIGN_To_##')
	{
		assignToSearch='';
	}
	}
	window.assignBySearch=assignBySearch;
	window.assignToSearch=assignToSearch;
	
	
	
	if( typeof table !== 'undefined' ) {
		var container	=	'mainContainer';
		if( table === 1 ) {
			loadBoxContent(base_path+'user/myTodoItem/moreflag/'+flag+'/currentList/'+mylist, container);
		} else if( table === 2 ) {
			loadBoxContent(base_path+'user/assignedByMeTodoItem/moreflag/'+flag+'/currentList/'+mylist,container);
		} else if( table === 3 ) {
			loadBoxContent(base_path+'user/otherTodoItem/moreflag/'+flag+'/currentList/'+mylist, container);
		}
	} else {
		loadBoxContent(base_path+'user/myTodoItem/moreflag/'+flag,'items');
		loadBoxContent(base_path+'user/assignedByMeTodoItem/moreflag/'+flag,'assignedByMeTodoItem');
		loadBoxContent(base_path+'user/otherTodoItem/moreflag/'+flag,'otherTodoItem');
	}
	$j(".listItem").removeClass('activeListItems');
	$j("#list_request_"+mylist).addClass('activeListItems');
	
	//loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/itemAjax<?php if(isset($_GET['list'])){ //echo '/list/'.$_GET['list'];
	}?>','itemAjaxBox');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/itemAjax/list/'+mylist,'itemAjaxBox');
	
	
}

function reloadHomeByListFirst()
{
	//mylist=$j('#txtSearchListDP').val();
	//mylistStatus=$j('#txtSearchStatusDP').val();
	//window.list=mylist;
	//window.todoStatus=mylistStatus;	
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/myTodoItem','items');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/assignedByMeTodoItem','assignedByMeTodoItem');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/otherTodoItem','otherTodoItem');
	loadBoxContent('<?php echo Yii::app()->params->base_path;?>user/itemAjax<?php if(isset($_GET['list'])){ echo '/list/'.$_GET['list'];}?>','itemAjaxBox');
	$j(".listItem").removeClass('activeListItems');
	$j("#list_request_"+window.list).addClass('activeListItems');
}

function loadBoxContent(urlData,boxid)
{
	mylist=0;
	mytodoStatus=0;
	if(window.list!='undefined')
	{
		mylist=window.list;
		//mytodoStatus=window.todoStatus;
	}
	
	var $j = jQuery.noConflict();
		$j.ajax({			
		type: 'POST',
		url: urlData,
		data: csrfToken+'&mytodoStatus='+mytodoStatus+window.extraPara+'&mylist='+mylist+'&assignToSearch='+window.assignToSearch+'&assignBySearch='+window.assignBySearch,
		cache: false,
		success: function(data)
		{
			if(data=="logout")
			{
				window.location.href = '<?php echo Yii::app()->params->base_path;?>';
				return false;	
			}
			$j("#"+boxid).html(data);
			$j('#update-message').removeClass().html('').hide();
		}
		});	
}

</script>
<a href="#verifycodePopup" id="verifycode"></a>
<!-- End Mouse Scroll Finction -->
<div id="update-message"></div>
<!-- Middle Part -->
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
</div>
<div class="clear"></div>

<div class="mainContainer">

    <!-- LeftSide Slide Bar -->
    
    <div class="leftSlidebar">	
        <!-- Slidebar -->
        <div class="sidebar">
            <div class="logo-bg">
                <div class="logo"> 
                    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'user/logout','post',array('id' => 'logout','name' => 'logout')) ?>
                    <div>
                        <label class="username">##_HOME_HEADER_HI_## <b><?php echo Yii::app()->session['fullname']; ?></b></label>
                        <label class="logout"><a href="javascript:;" onClick="document.logout.submit();">##_BTN_LOGOUT_##</a></label>
                    </div>
                  <a href="<?php echo Yii::app()->params->base_path;?>user/index" id="logoImage"><img src="<?php echo Yii::app()->params->base_path; ?>images/logo/logo.png" alt="" border="0" /></a>
            <?php echo CHtml::endForm(); ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="rightBorder">
              
                <div class="box">
                    <div id="leftview"></div>
                </div>
                <div class="clear"></div>
                
                <?php if(count($invites) > 0){ ?>
                <div class="box">
                    <div id="inviteAjaxBox"></div>
                </div>
                <?php } ?>
                <div class="box">
                    <div id="listAjaxBox"></div>
                </div>
                <div class="clear"></div>
                
               
                <div class="clear"></div>
                
                <div class="box">
                    <div id="reminderAjaxBox"></div>
                </div>
                <div class="clear"></div>
                <?php if(count($invites) == 0){ ?>
                
                <div class="box">
                    <div id="inviteAjaxBox"></div>
                </div>
                <?php } ?>
                
                <div class="clear"></div>
                <div class="box">
                    <div id="itemAjaxBox"></div>
                </div>
                <div class="clear"></div>
                
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="content" id="mainContainer">
      <input type="hidden" id="mainPageCheker" value="1" />
       <div class="RightSide">	
        	<?php echo CHtml::beginForm(Yii::app()->params->base_path.'user','post',array('id' => 'serchDPForm','name' => 'serchDPForm')) ?>
            <div class="todoList">
                <span class="floatLeft">##_HOME_TODO_LIST_##:</span>
                <div id="searchListDP">
                    <select id="txtSearchListDP" style="width:120px;" name="txtSearchListDP" onchange="reloadHomeByList()">
                   
                    <?php 
                    $ListBox	=	'<option value="0">All</option>';
                    foreach($myLists as $data){ 
                        $selected="";
                        if(isset($_GET['list']) && $_GET['list']!='' && ($_GET['list']==$data['id']))
                        {
                            $selected.=' selected="selected" ';
                        }
                            $ListBox.='<option '.$selected.'  value="'.$data['id'].'">'.$data['name'].'</option>';
                    }
                    echo $ListBox;
                    ?>
                    </select>
                    <input type="text" name="assignBySearch" style="color:#a0a0a0; width:170px;"   onfocus="if(this.value==this.defaultValue)this.value='';this.style.color='black';" value="##_HOME_SEARCH_ASSIGN_BY_##" onblur="if(this.value==''){this.value=this.defaultValue;this.style.color='#a0a0a0';}" class="textbox" id="assignBySearch" />
                    <input type="text" name="assignToSearch" style="color:#a0a0a0;width:170px;"  onfocus="if(this.value==this.defaultValue)this.value='';this.style.color='black';" value="##_HOME_SEARCH_ASSIGN_To_##" onblur="if(this.value==''){this.value=this.defaultValue;this.style.color='#a0a0a0';}" class="textbox" id="assignToSearch" />
                    <input type="button" class="btn" onclick="reloadHomeByList()" value="Search" />
                </div>
                <!--<select id="txtSearchStatusDP" style="width:120px;" name="txtSearchStatusDP" onchange="reloadHomeByList()">
                    <option value="0">##_HOME_ALL_##</option>  
                    <option value="1">##_HOME_OPEN_##</option>  
                    <option value="3">##_HOME_DONE_##</option>  
                    <option value="4">##_HOME_CLOSE_##</option>       	
                </select>-->            
            </div>
            <div class="clear"></div>

       		
            <?php echo CHtml::endForm(); ?>
            <!-- MY TODO ITEMS DIV -->
      		<div id="items" class="recentBox"></div>
            
            <!-- ASSIGNED BY ME TODO ITEMS DIV -->
            <div id="assignedByMeTodoItem" class="recentBox"></div>
            
            <!-- OTHER TODO ITEMS DIV -->
            <div id="otherTodoItem" class="recentBox"></div>
            
        </div>
       <div class="clear"></div>
    </div>
    
    <div class="clear"></div>
    
</div>
<div class="clear"></div>
