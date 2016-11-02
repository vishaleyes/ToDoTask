<iframe id="frame1" style="display:none"></iframe>
<div class="RightSide">
	<?php if(Yii::app()->user->hasFlash('success')): ?>                                
        <div id="msgbox" class="clearmsg"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
    <?php if(Yii::app()->user->hasFlash('error')): ?>
        <div id="msgbox" class="clearmsg errormsg"> <?php echo Yii::app()->user->getFlash('error'); ?></div>
        <div class="clear"></div>
    <?php endif; ?>
	<div><h2>##_MORE_HISTORY_TODO_##</h2></div> 
    <div align="right">
    	<a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/itemDescription/id/<?php echo $itemId;?>');" class="btn" >##_NETWORK_DETAIL_BACK_##</a>
    </div>
    <div>
        <div id="update-message"></div>
 		<div>
        	<table class="listing historyView" cellpadding="0" cellspacing="0">
				<?php $i = 0; foreach($history[1] as $row) {  
                $general = new General();
                $time = $general->rel_time($row['createdAt']);
                ?>
                <tr><td class="noBorderLeft"><?php echo $time .' &nbsp;&nbsp; <b>' .$row['action'].'</b> by <b>'.$row['firstName'] . '&nbsp;' . $row['lastName']; ?></b></td></tr>
                <?php $i++; } ?>
        	</table>
        </div>
		<div class="clear"></div>
        <?php
        if(!empty($history[0]) && $history[0]->getItemCount()  > $history[0]->getLimit()){?>
            <div class="pagination">
                <?php
                $this->widget('application.extensions.WebPager', 
                                array('cssFile'=>true,
                                         'pages' => $history[0],
                                         'id'=>'link_pager',
                )); ?>
            </div>
			<?php
		} ?>
	</div>
	<script type="text/javascript">
        $j(document).ready(function(){
            $j('#link_pager a').each(function(){
                $j(this).click(function(ev){
                    ev.preventDefault();
                    $j.get(this.href,{ajax:true},function(html){
                        $j('#mainContainer').html(html);
                    });
                });
            });
        });
    </script>
</div>