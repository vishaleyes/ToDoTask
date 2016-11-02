<div class="middle-section">
    <div id="content-outer">
        <div class="wrapper">
            <div class="api">
                
                <!-- Path Navigation -->
                
                <div id="breadcrumbs">
                    <div class="breadcrumb">
                        <a href="<?php echo Yii::app()->params->base_path; ?>apidoc">Home</a> &rarr; <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/api">API</a> &rarr; <a href="<?php echo Yii::app()->params->base_path; ?>apidoc/method/id/<?php echo $method;?>">Method</a>	&rarr; Error Codes
                    </div> 
                </div>
                
                <!-- Container -->
                
                <div class="api-container">
                    <h1 id="title">ERROR CODES</h1>
                    <div id="content-inner">
                        <div id="content-main">
                        
                            <div>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="api-list">
                                   <tr>
                                        <td width="25%"><b>Error code</b></td>
                                        <td><b>Description</b></td>
                                   </tr>
                                   <?php 
									foreach($error as $key => $value)
									{
									?>
                                    <tr>
                                        <td class="func-name"><p><b><?php echo $key;?></b></p></td>
                                        <td><p><?php echo $value;?></p> </td>
                                    </tr>
                                   <?php } ?>                       
                                </table>		 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>