<div class="title"><?php echo $data['title']; ?></div>
<?php if(Yii::app()->user->hasFlash('success')): ?>								   
    <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
    <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
    <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
    <div class="clear"></div>
<?php endif; ?>

    <ul class="infoList">
        <li>##_MOBILE_USER_DESC_LIST_##:<span><?php echo $data['listName']['name']; ?></span></li>
          <li>##_MOBILE_USER_DESC_TITLE_##:<span><?php echo $data['title']; ?></span></li>
        <li>##_MOBILE_USER_DESC_DESC_##:<span><?php echo $data['description']; ?></span></li>
        <li>##_MOBILE_USER_DESC_ATTACH_##:<span>
                            <?php
                            if(!isset($data['attachmentFile']) || $data['attachmentFile']== ''){
                                echo 'No attachment';
                            } else {
                            ?>
                            <a href="javascript:forceDownload('<?php echo Yii::app()->params->base_path;?>upload/getAttach/dir/<?php echo $data['attachmentDir'];?>/fileName/<?php echo $data['attachmentFile'];?>')" ><?php echo $data['attachmentFile'];?></a>			   
                            <?php
                            }?></span></li>
        <li>##_MOBILE_USER_DESC_ASSIGN_BY_##:
            <span>
                <?php 
                    if($data['assignedBy'] == 0 || $data['assignedBy'] == Yii::app()->session['loginId']){
                        echo 'me';
                    } else {
                        if(isset($data['assignedByEmail']) && $data['assignedByEmail'] != ''){
                            echo $data['assignedByFname']. ' ' . $data['assignedByLname'].' ['.$data['assignedByEmail'].']';
                        }else{
                            echo $data['assignedByFname']. ' ' . $data['assignedByLname'];
                        }
                }?>
            </span></li>
        <li>##_MOBILE_USER_DESC_ASSIGN_TO_##:
            <span>
                <?php
                    if($data['assignTo'] == Yii::app()->session['loginId']){
                        echo 'me';
                    } else {
                        if(isset($data['assignedToEmail']) && $data['assignedToEmail'] != ''){
                            echo $data['assignedToFname']. ' ' . $data['assignedToLname'].' ['.$data['assignedToEmail'].']';
                        }else{
                            echo $data['assignedToFname']. ' ' . $data['assignedToLname'];
                        }
                }
				$generalObj=new General();
				$dueDate=$generalObj->pastdue($data['dueDate'],$data['myTimeZone']);
				
				?>
            </span></li>
        <li>##_MOBILE_USER_DESC_DUE_DATE_##:<span style="color:<?php echo $dueDate['class'];?>;"><?php echo $dueDate['value']; ?></span></li>
        <li>##_DESCRIPTION_STATUS_##:
            <span>
                <?php
                if($data['status'] == 1) {
                    $value	=	'Open';
                } else if($data['status'] == 2) {
                    $value	=	'QA';
                } else if($data['status'] == 3) {
                    $value	=	'Done';
                } else {
                    $value	=	'Close';
                }
                ?>
                <?php
                
                if($data['assignTo'] == Yii::app()->session['loginId'] && $data['status'] != 4){
                    if( $data['status'] == 1 ){ ?>
                        <input type="checkbox" class="btn status" value="##_BTN_DONE_##" id="done" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>muser/changeTodoItemStatus/id/<?php echo $data['id'];?>/stat/3';" />
                    <?php
                    } 
                    else if( $data['status'] == 3 ) { 
                    ?>
                        <input type="checkbox" checked="checked" class="btn status" value="##_BTN_OPEN_##" id="open" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>muser/changeTodoItemStatus/id/<?php echo $data['id'];?>/stat/1';" />
                    <?php
                    }?>
                <?php
                } ?>
                <?php
                if($data['assignedBy'] == Yii::app()->session['loginId']) {
                    
                    if( $data['status'] == 1 ){ ?>
                        <input type="checkbox" class="btn status" value="##_BTN_DONE_##" id="done" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>muser/changeTodoItemStatus/id/<?php echo $data['id'];?>/stat/3';" />
                    <?php 
                     }
                    if( $data['status'] == 4 || $data['status'] == 3 ){ ?>
                        <input type="checkbox" checked="checked"  class="btn status" value="##_BTN_OPEN_##" id="open" onclick="javascript:window.location='<?php echo Yii::app()->params->base_path;?>muser/changeTodoItemStatus/id/<?php echo $data['id'];?>/stat/1';" />
                    <?php 
                    }
                }
                ?>
                <?php echo $value;?>
            </span></li>
    </ul>
<div class="field-area">
    <div class="links">
        <a href="<?php echo Yii::app()->params->base_path.'muser/getItemHistory/id/'.$data['id_encrypt'].'' ?>"> 
     ##_BTN_HISTORY_##</a>
        <?php  
        if($data['assignedBy'] == Yii::app()->session['loginId']){ ?>
        <a href="<?php echo Yii::app()->params->base_path.'muser/itemDescription/id/'.$data['id_encrypt'];?>/event/email"> | ##_MOBILE_USER_MY_TODO_EMAIL_##</a>
        <a href="<?php echo Yii::app()->params->base_path.'muser/reassignTask/id/'.$data['id_encrypt'];?>" > | ##_BTN_REASSIGN_##</a>
        <?php } ?>
        <?php if($data['assignTo'] == Yii::app()->session['loginId'] && $data['status'] != 4){ ?>  
        <a href="<?php echo Yii::app()->params->base_path.'muser/reassignTask/id/'.$data['id_encrypt'];?>" > | ##_BTN_REASSIGN_##</a>
        <?php if($data['status'] == 1 && $data['assignedBy'] != 0 ) { ?>
        <a href="<?php echo Yii::app()->params->base_path.'muser/assignBack/itemId/'.$data['id_encrypt'];?>" > | ##_BTN_ASSIGN_BACK_##</a>
        <?php } } ?>
    </div>
</div>

<div class="clear"></div>
<div class="field-area">
    <?php echo CHtml::beginForm(Yii::app()->params->base_path.'muser/addComments','post',array('id' => 'comments','name' => 'comments')) ?>
        <input type="hidden" value="<?php echo $data['id_encrypt'];?>" name="itemId" />
        <input type="hidden" value="<?php echo $data['listId'];?>" name="listId" />
        <input type="hidden" value="<?php echo Yii::app()->session['userId'];?>" name="userId" />
        <div class="field">
            <label>##_MOBILE_USER_DESC_ADD_COMMENT_##<span id="commenterror"></span></label>
            <textarea name="comments" id="commentText"  cols="40" class="textarea" rows="5" onfocus="this.style.color='black';"></textarea>
            
        </div> 
        <div>
            <input type="submit" name="FormSubmit" id="FormSubmit" value="##_BTN_SUBMIT_##" class="btn" />
        </div>
    <?php echo CHtml::endForm();?>
</div>
<div align="left">
	 <table cellpadding="0" cellspacing="0" border="0" class="activity-table" width="100%">
		<?php
        if(empty($comments)){?>
			<tr class="even">
				 <td colspan="2"  id="nodata" align="left">##_MOBILE_USER_DESC_NO_COMMENT_##</td>
			</tr>
		<?php
		}else{
			$iteration	=	1;
			foreach($comments as $comments){?>
				<tr <?php if(($iteration % 2) == 0){?>  class="odd" <?php }else{?> class="even" <?php }?> >
					<td>
						<p> 
							<b><?php echo $comments['commentedByFname'].' '.$comments['commentedByLname'];?></b> <?php echo $comments['commentText']; ?>
						</p>
						
						<p class="time"><?php echo $comments['createdAt'];?></p>
					</td>
				</tr>
			<?php
			$iteration++;
            }
		}?>
		
	</table>	
	<div class="clear"></div>
</div>