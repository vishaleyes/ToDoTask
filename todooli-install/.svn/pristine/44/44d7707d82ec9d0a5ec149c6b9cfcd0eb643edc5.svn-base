<div id="maincontainer">
<?php
$extraPaginationPara='&keyword='.$ext['keyword'].'&sortType='.$ext['sortType'].'&sortBy='.$ext['sortBy'];
?>
<script type="text/javascript" src="<?php echo Yii::app()->params->base_url; ?>js/slider/jquery.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->params->base_url; ?>css/todooliapp/todooliapp.css" type="text/css" />
<script type="text/javascript">
var $j = jQuery.noConflict();
$j(document).ready(function() {
	
});

function setUrl(myurl)
{	
	var keyword = $j("#networkUserSearch").val();
	var imgPath = "<?php echo Yii::app()->params->base_url;?>";
	$j('#update-message').removeClass();
	$j('#loading').html('<div align="center"><img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" /> Loading...</div>').show();
	$j.ajax ({
			url: myurl+'/keyword/'+keyword,
			data: '',
			success: function(response)
			{
				/*if(trim(response)=='LOGOUT')
				{
					window.location=BASHPATH;
					return false;
				}*/
				
				$j('#maincontainer').html(response);
				$j("#networkUserSearch").val(keyword);
				//inner tab menu
				$j('#update-message').html('');
				//close inner tab menu
				return false;
			}
	});
}

function selectNetworkUser(id)
{
	parent.$j("#userlist").val($j("#"+id).attr('lang'));
	parent.$j.fancybox.close();		
}

</script>
<div class="text width700">
	<h1 align="center">##_NETWORK_MY_LIST_##</h1>
    <div class="searchArea innerSearch marT20 floatLeft">
        <form id="jobSearch" name="jobSearch" action="<?php echo Yii::app()->params->base_path;?>user/myNetworkUser" method="post">
            <label class="label floatLeft">##_NETWORK_MY_USER_##</label>
            <input type="text" class="textbox floatLeft height27" name="networkUserSearch" id="networkUserSearch" />
            <input type="button" name="searchBtn" class="searchBtn" value="" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetworkUser/sortType/<?php echo $ext['sortType'];?>/sortBy/<?php echo $ext['sortBy'];?>/flag/1');" />
        </form>
    </div>
    <table cellpadding="0" cellspacing="0" border="0" class="listing width700">
        <tr>
            <th width="20%"><a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetworkUser/sortType/<?php echo $ext['sortType'];?>/sortBy/firstName/flag/1')" >##_NETWORK_FNAME_##<?php 
                    if($ext['img_name'] != '' && $ext['sortBy'] == 'firstName'){ ?>
        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
        <?php
                    } ?>
        </a></th>
            <th width="20%"><a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetworkUser/sortType/<?php echo $ext['sortType'];?>/sortBy/lastName/flag/1')" >##_NETWORK_LNAME_##<?php 
                    if($ext['img_name'] != '' && $ext['sortBy'] == 'lastName'){ ?>
        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
        <?php
                    } ?>
        </a></th>
           
            <th width="30%"><a href="javascript:;" onclick="setUrl('<?php echo Yii::app()->params->base_path;?>user/myNetworkUser/sortType/<?php echo $ext['sortType'];?>/sortBy/loginId/flag/1')" >##_NET_EMAIL_##<?php 
                    if($ext['img_name'] != '' && $ext['sortBy'] == 'loginId'){ ?>
        <img src="<?php echo Yii::app()->params->base_url;?>images/<?php echo $ext['img_name'];?>" class="sortImage" />
        <?php
                    } ?>
        </a></th>
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
                    <a href="" lang="<?php echo $row['user']['loginId']; ?>" id="myNetwork_<?php echo $row['networkId']; ?>" onclick="selectNetworkUser('myNetwork_<?php echo $row['networkId']; ?>')" >##_NETWORK_SELECT_##</a>
                </td>
            </tr>
        	<?php
            }
		} else { ?>
			<tr>
            	<td colspan="8" class="lastcolumn">
                	##_NET_NO_NETWORK_##
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
                                     'extraPara'=>$extraPaginationPara,
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
</div>