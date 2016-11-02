<?php 

if(!isset($data['currentList']))
{
	$data['currentList']=0;
}
$ListBox='<select id="txtSearchListDP" name="mylist" style="width:120px;" onchange="this.form.submit()">';
$ListBox.='<option value="0">All</option>';
$listData	=	'{';
for($i=0; $i<=count($data['myLists']); $i++){
	
	if( $i != count($data['myLists']) ) {
		if( isset($data['currentList']) && $data['currentList'] == $data['myLists'][$i]['id'] ) {
			$selected	=	'selected="selected"';
		} else {
			$selected	=	'';
		}
	}
		
	if($i == count($data['myLists'])){
		$listData .= "}";
	} else if($i == 0) {
		$ListBox.='<option '.$selected.' value="'.$data['myLists'][$i]['id'].'">'.$data['myLists'][$i]['name'].'</option>';
		$listData .= "'".$data['myLists'][$i]['id']."':'".$data['myLists'][$i]['name']."'";
	} else {
		$ListBox.='<option '.$selected.' value="'.$data['myLists'][$i]['id'].'">'.$data['myLists'][$i]['name'].'</option>';
		$listData .= ",'".$data['myLists'][$i]['id']."':'".$data['myLists'][$i]['name']."'";
	}
}
$ListBox.='</select>';
?>
<script type="text/javascript">
function updateOtherShowStatus( field, status, url ) 
{
	window.location.href="<?php echo Yii::app()->params->base_path;?>muser/changeShowStatus/field/"+field+"/status/"+status+"/url/othersTodo/mylist/<?php echo $data['currentList'];?>";  
}
</script>

<div class="title">##_MOBILE_USER_OTHERS_TODO_LIST_## <label class="red"><?php if( isset(Yii::app()->session['otherTodoCount']) ){echo "(".Yii::app()->session['otherTodoCount'].")";} ?></label></div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

<div class="topOptionsBg">
	<div class="searchBox">
		<?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/othersTodo','post',array('id' => 'myTodo','name' => 'myTODOSearch')) ?>
            <?php echo $ListBox;?>
        <?php echo CHtml::endForm(); ?>
    </div>
	<div class="topOptions checkbox1">
    	<input type="checkbox" <?php if( $data['user']['otherOpenStatus'] == 1 ) {?>onchange="updateOtherShowStatus('otherOpenStatus', 0, 'otherTodoItem/moreflag/<?php echo $data['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateOtherShowStatus('otherOpenStatus', 1, 'otherTodoItem/moreflag/<?php echo $data['moreflag'];?>')"<?php }?> id="otherOpen" name="otherOpen" /><span>Open</span>
        
        <input type="checkbox" <?php if( $data['user']['otherDoneStatus'] == 3 ) {?>onchange="updateOtherShowStatus('otherDoneStatus', 0, 'otherTodoItem/moreflag/<?php echo $data['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateOtherShowStatus('otherDoneStatus', 3, 'otherTodoItem/moreflag/<?php echo $data['moreflag'];?>')"<?php }?> id="otherDone" name="otherDone" /><span>Done</span>
        
        <input type="checkbox" <?php if( $data['user']['otherCloseStatus'] == 4 ) {?>onchange="updateOtherShowStatus('otherCloseStatus', 0, 'otherTodoItem/moreflag/<?php echo $data['moreflag'];?>')" checked="checked" <?php } else {?> onchange="updateOtherShowStatus('otherCloseStatus', 4, 'otherTodoItem/moreflag/<?php echo $data['moreflag'];?>')"<?php }?> id="otherClose" name="otherClose" /><span>Close</span>
        
	</div>
    <div class="clear"></div>
</div>


<?php
if(count($data['items']) > 0){
	?> <ul class="listView todoList"> <?php
	foreach($data['items'] as $row){ ?>
	
		 <?php
			if($row['status'] == 1) {
				$value	=	'Open';
			} else if($row['status'] == 2) {
				$value	=	'QA';
			} else if($row['status'] == 3) {
				$value	=	'Done';
			} else {
				$value	=	'Close';
			}
			
			$generalObj=new General();
			$dueDate=$generalObj->pastdue($row['dueDate'],$row['myTimeZone']);
			?>
		<li onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>muser/itemDescription/id/<?php echo $row['id_encrypt'];?>'">
			<div class="arrow">
				<p><?php echo $row['listName']; ?> [<b><?php echo $value;?></b>] - <?php echo $row['title']; ?></p>
				<p>By <?php echo $row['assignedByFname'] .' '. $row['assignedByLname']; ?> ##_MOBILE_USER_TODO_LISTS_DUE_DATE_## : <span style="color:<?php echo $dueDate['class'];?>;"><?php echo $dueDate['value']; ?>&nbsp;</span></p>
			</div>
		</li>
	<?php
	}
	?> </ul> <?php
} else { ?>
<div class="nodata"> ##_MOBILE_USER_TODO_LISTS_NO_TODO_##</div>
<?php
}?>

<?php 
if(!empty($data['pagination']) && $data['pagination']->getItemCount()  > $data['pagination']->getLimit()){?>
 
<div class="pagination" align="left">
    <?php   
     $extraPara="&mylist=".$data['currentList'];
	
    $this->widget('application.extensions.MobilePager',
         array('cssFile'=>true,
                'pages' => $data['pagination'],
				'extraPara'=>$extraPara,
                'id'=>'link_pager',
    ));
	?> 
</div> 
<?php } ?>
<div class="clear"></div>