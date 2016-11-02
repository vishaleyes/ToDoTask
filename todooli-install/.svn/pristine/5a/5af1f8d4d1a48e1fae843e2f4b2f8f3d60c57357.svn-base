<div class="title"><?php echo $data['name']; ?></div>

<ul class="listView">
    <li class="noHover">
    	<p><b>##_MOBILE_USER_LIST_DESC_CREATED_BY_##:</b> <?php echo $data['assignedByFname'].' '.$data['assignedByLname']; ?></p>
        <p><b>##_MOBILE_USER_LIST_DESC_DESC_##:</b> <?php echo $data['description']; ?></p>
        <p>
        	<b>##_MOBILE_USER_LIST_DESC_STATUS_##:</b> 
			<?php
			if($data['status'] == 0) {
				echo 'Open';
			} else if($data['status'] == 1) {
				echo 'Archive';
			} else {
				echo 'Deleted';
			}
			?>
        </p>
       
        <p><b>##_MOBILE_USER_LIST_DESC_CREATED_AT_##:</b> <?php echo $data['time']; ?></p>
        <p>
            <button class="btn fancybox-close btn_ok" onclick="javascript:history.go(-1);" >##_BTN_OK_##</button>&nbsp;&nbsp;
            <?php if($data['createdBy']==Yii::app()->session['loginId'] && $data['name'] != 'Self'){?>
            <a style="text-decoration:none;" class="btn" href="<?php echo Yii::app()->params->base_path."muser/removeList/id/".$data['id'];?>">##_BTN_DELETE_##</a>
            <?php } ?>
        </p>
    </li>
</ul>



<div class="clear"></div>
<div class="title">##_MOBILE_USER_LIST_DESC_MEMBERS_##: </div>

<ul class="listView">
	<?php 
		if(count($listMembers) > 0) { 	 
			$iteration	=	0;
			foreach($listMembers as $row) { ?> 
                <li>
                    <p><b>##_MOBILE_USER_LIST_DESC_NAME_##:</b> <?php echo $row['firstName'].' '.$row['lastName'];?></p>
                    <p><b>##_MOBILE_USER_LIST_DESC_EMAIL_##:</b> <?php echo $row['loginId']; ?></p>
                    <p><b>##_MOBILE_USER_LIST_DESC_SINCE_## :</b> <?php echo $row['createdAt']; ?></p>
                    <p><b>##_MOBILE_USER_LIST_DESC_STATUS_##:</b> <?php if($row['status']==0){ 
									echo "Inactive";
								}elseif($row['status']==1){
									echo "Active";
								}else{
									echo "Block";
								}?>
                    </p>
                </li>
			<?php
    		$iteration++;
    		}		
    	} else { ?>
            <li class="nodata">##_MOBILE_USER_LIST_DESC_NO_MEMBERS_##</li>
    	<?php
    }?>			
</ul>


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
<?php
}
?>
<div class="clear"></div>  
