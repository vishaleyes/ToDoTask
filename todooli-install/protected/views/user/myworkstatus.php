<div class="mainContainer">
<?php
$flashChart = Yii::createComponent('application.extensions.yiiopenflashchart.EOFC2');
$flashChart->begin();
$flashChart->setData(array(1,2,2,3,5,6,1,9,6,4,5,6,7,8,0,8,2,2,1,9));
$flashChart->renderData('line');
$flashChart->render(300, 200);

//echo '<pre>';print_r($flashChart);exit;
?>

    <div class="content" id="mainContainer">
       <div class="RightSide">	
        
            <ul class="todoList">
                
                <li>
                    <span>##_MY_WORK_TODO_LIST_##:</span>
                    <div id="searchListDP" class="floatLeft">
                    <?php 
					
							//print_r($extraPara['mylist']);
							$ListBox='<select id="txtSearchListDP" name="txtSearchListDP" style="width:120px;" onchange="reloadHomeByList()">';
							$ListBox.='<option value="0">All</option>';
							for($i=0; $i<count($mylist); $i++)
							{
								
								$ListBox.='<option>'.$mylist[$i]['name'].'</option>';
							}
							$ListBox.='</select>';
							?>
                     <?php echo $ListBox; ?>       
                    </div>
                    	<!--<select id="txtSearchStatusDP" style="width:120px;" name="txtSearchStatusDP" >
                 			<option value="0">All</option>  
                 			<option value="1">today</option>  
                 			<option value="3">This week</option>  
                 			<option value="4">This Month</option>
                            <option value="4">This Year</option>
                         </select>-->
               <input type="button" name="go" class="btn" value="##_GO_##" onchange="reloadHomeByList()"/>
                </li>
                            
                <li>
                    <span>##_MY_WORK_PENDING_TODO_##:</span>
                </li>
            </ul>
       	</div>
		<div class="RightSide">
            	<ul class="todoList">
                
                <li>
                    <span>##_MY_WORK_DONE_TODO_##:</span>
               </li>
            </ul>
       	</div>

    </div>
<div class="clear"></div>
</div>