<div class="title">##_MOBILE_USER_INVITES_LIST_## <label class="red"><?php if(isset(Yii::app()->session['invites']) && Yii::app()->session['invites']){echo "(".Yii::app()->session['invites'].")";} ?></label>
</div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>
<div class="add-link" align="left"><a href="<?php echo Yii::app()->params->base_path;?>muser/AddInvite">##_MOBILE_USER_INVITES_CLICK_ADD_##</a></div>


<?php if(count($data) > 0) { 
?> <ul class="listView todoList"> <?php
		for($i=0;$i<count($data);$i++){ ?>
		<li onclick="window.location.href='<?php echo Yii::app()->params->base_path;?>muser/viewMoreInvite/id/<?php echo $data[$i]['id_encrypt'];?>'">
			<div class="arrow">
				<p><?php echo $data[$i]['listName']; ?> - <?php echo $data[$i]['senderFirstName']. ' ' . $data[$i]['senderLastName']; ?></p>
				<p><?php
						if($data[$i]['status'] == 2){ ?>
						<a href="<?php echo Yii::app()->params->base_path;?>muser/changeStatus/id/<?php echo $data[$i]['id_encrypt'];?>/status/1">##_MOBILE_USER_INVITES_ACCEPT_##</a> | 
						<?php
						} ?>
						
							<a href="<?php echo Yii::app()->params->base_path.'muser/deleteConfirm/deleteId/'.$data[$i]['id_encrypt'].'/functionname/deleteInvite/itemname/record';?>">##_MOBILE_USER_INVITES_DELETE_##</a>
						</p>
			</div>
		</li>
	<?php
	}
	?> </ul> <?php
} else { ?>
	<div class="nodata"> ##_MOBILE_USER_INVITES_NO_LIST_##</div>
<?php
}?>

<?php 
 if(!empty($pagination) && $pagination->getItemCount()  > $pagination->getLimit()){?>
 
<div class="pagination" align="left">
    <?php   
        $this->widget('application.extensions.MobilePager',
					 array('cssFile'=>true,
							'pages' => $pagination,
							'id'=>'link_pager',
			));
?> 
</div> 
<?php } ?>
<div class="clear"></div>
  