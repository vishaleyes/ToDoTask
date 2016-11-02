<div class="middle-section">
    <div id="content-outer">
        <div class="wrapper">
            <div class="api">
                
                <!-- Path Navigation -->
                
                <div id="breadcrumbs">
                    <div class="breadcrumb">
                        <a href="<?php echo Yii::app()->params->base_path; ?>apidoc">Home</a> &rarr; <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/api">API</a> &rarr; <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/method/id/<?php echo $method;?>">Method</a>	&rarr; Field Values
                    </div> 
                </div>
                
                <!-- Container -->
                
                <div class="api-container">
                    <h1 id="title">FIELD VALUES</h1>
                    <div id="content-inner">
                    <?php 
					foreach($tables_types as $key => $item)
					{
					?>
                            <div id="content-main">
                            
                                <div id="panel-top">
                                   <h2><?php echo $key;?> Types</h2>
                 				</div>	
                                
                                <div>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="api-list">
                                       <tr>
                                            <td width="25%"><b>Type Code</b></td>
                                            <td><b>Description</b></td>
                                       </tr>
                                       <?php 
										foreach($item as $item)
										{
										?>
                                       	<tr>
                                        	<td class="func-name"><p><b><?php echo $item['id']?></b></p></td>
                                            <?php if(isset($item['name']) && $item['name']!=''){ ?>
                                            	<td><p><?php echo $item['name']?></p></td>
                                            <?php }else{ ?>
                                            	<td><p><?php echo $item['label']?></p></td>
                                            <?php } ?> 
                                        </tr>
                                        <?php } ?>                      
                                    </table>		 
                                </div>
                                
                            </div>
                     <?php } ?> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>