<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function() {
	
});

function selectNetworkUser(id)
{
	parent.$j("#userlist").val($j("#"+id).attr('lang'));
	parent.$j.fancybox.close();		
}

</script>

<div class="text width700">
	<h1 align="center">##_MOBILE_USER_NET_USER_LIST_##</h1>
    <div class="searchArea innerSearch marT20 floatLeft">
        <form id="jobSearch" name="jobSearch" action="<?php echo Yii::app()->params->base_path;?>muser/myNetworkUser" method="post">
            <label class="label floatLeft">##_MOBILE_USER_NET_USER_##</label>
            <input type="text" class="textbox floatLeft height27" name="networkUserSearch" id="networkUserSearch" />
            <input type="button" name="searchBtn" class="searchBtn" value="" />
        </form>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="listing width700">
        <tr>
            <th width="20%">##_MOBILE_USER_NET_USER_F_NAME_##</th>
            <th width="20%">##_MOBILE_USER_NET_USER_L_NAME_##</th>
           
            <th width="30%">##_MOBILE_USER_NET_USER_EMAIL_##</th>
            <th width="10%" class="lastcolumn">&nbsp;</th>
        </tr>
        <?php 
    	 if($networks['pagination']->getItemCount() > 0){
             foreach($networks['networks'] as $row){
				
			 ?> 
            <tr>
                <td><?php  echo $row['user']['firstName'];?></td>
                <td><?php echo $row['user']['lastName']; ?></td>
               
                <td><?php echo $row['user']['loginId']; ?></td>
                <td class="lastcolumn">
                    <a href="" lang="<?php echo $row['user']['loginId']; ?>" id="myNetwork_<?php echo $row['networkId']; ?>" onclick="selectNetworkUser('myNetwork_<?php echo $row['networkId']; ?>')" >##_MOBILE_USER_NET_USER_SELECT_##</a>
                </td>
            </tr>
        	<?php
            }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn">
                	##_MOBILE_USER_NET_USER_NO_NETWORK_##
				</td>
			</tr>
		<?php
		}?>
        </table>
</div>  <?php
        if(!empty($networks['pagination']) && $networks['pagination']->getItemCount()  > $networks['pagination']->getLimit()){?>
            <div class="pagination">
            <?php
            $this->widget('application.extensions.WebPager', 
                            array('cssFile'=>true,
                                     'pages' => $networks['pagination'],
                                     'id'=>'link_pager',
            ));
            ?>
            </div>
            <?php
		}
        ?>
    
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
