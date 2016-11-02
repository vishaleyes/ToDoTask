<?php
$is_live = true;  // for live dfault
if(isset($_SERVER['SERVER_NAME'])) {
	if($_SERVER['SERVER_NAME'] == "localhost") {
		$is_live = false;  //false is for local		
	}
}

if( $is_live ) {
	define('WEB_HOST_NAME','http://todooli.com');
	define('DB_SERVER_USERNAME', 'todooli');
	define('DB_SERVER_PASSWORD', 'tod373*');	
	define('DB_DATABASE', 'todooli');
	define('DB_SERVER', 'localhost');
	define('SITE_NAME','project/');
} else {
	define('WEB_HOST_NAME','http://localhost');
	define('DB_SERVER_USERNAME', 'root');
	define('DB_SERVER_PASSWORD', '');
	define('DB_DATABASE', 'pms');
	define('DB_SERVER', 'localhost');
	define('SITE_NAME','/jobtaxi/todooli-install/html/project/');
}
 
 $baseUrl=WEB_HOST_NAME;	

 define('BASE_PATH',WEB_HOST_NAME.'/'.SITE_NAME);
define("PAGE_LIMIT",10);



function Pagination($totalPage,$page,$counter,$id=NULL)
{
	
	if($totalPage>1)
	{
			if($page%10==1)
			{
				$counter = $page;
			}
			if($page>10)
			{
				$counter = $page-5;
			}
			if($totalPage==1){
						echo '<div class="previous-off"><img src="images/prev-btn-d.png"></div>';
					}else {
						if($page == 1){
							echo '<div class="first"><img src="images/first-d.png"></div>';
							echo '<div class="first"><img src="images/prev-btn-d.png"></div>';
						}else{
							echo '<div class="first"><a href="?id='.$id.'&page=1"><img src="images/first.png"></a></div>';
							echo '<div class="previous"><a href="?id='.$id.'"&page='.($page-1).'"><img src="images/prev-btn.png"></a></div>';
						}
					}
					$i=0;
					while($totalPage >= $counter){
						if($page == $counter){
							echo '<div class="active">'.$counter.'</div>';
						}else {
							echo '<div><a href="?id='.$id.'&page='.$counter.'">'.$counter.'</a></div>';
						}
						$counter = $counter + 1;
						if($i==10)
						{
							break;
						}
					$i++;}
					
					$counter = $counter - 1;
					if($page == $totalPage){
						echo '<div class="last">&nbsp;<img src="images/next-btn-d.png"></div>';
						echo '<div class="last"><img src="images/last-d.png"></div>';
					}else{
						echo '<div class="next"><a href="?id='.$id.'&page='.($page+1).'"><img src="images/next-btn.png"></a></div>';
						echo '<div class="last"><a href="?id='.$id.'&page='.$totalPage.'"><img src="images/last.png"></a></div>';
					}
	}
}
?>