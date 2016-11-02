function initMenu()
{
	$j(document).ready(function() {	
		$j('.navigation').click(function() {
		$j('#update-message').removeClass().addClass('');
		$j('#update-message').html('');
		$arr = $j(this).children('a').attr("lang").split("*");
		if($arr == '')
		{
			$arr = $j(this).children('a').attr("rel").split("*");
		}
		$j('.tabRef').removeClass('current');
		//inner tab menu id
		var innerId=$j(this).children('a').attr('id');
		var parentTab=$j(this).attr('lang');
		if(parentTab!='')
		{
			$j('#'+parentTab).addClass('current');
		}
		else
		{
			$j(this).addClass('current');
		}
		//$j('#update-message').html('<img src="'+imgPath+'/spinner-small.gif" alt="loading" border="0" />').show();
		//alert('<img src="'+imgPath+'spinner-small.gif" alt="loading" border="0" />')
		$j('#maincontainer').load($arr[0],function(response){
			if(trim(response)=='logout')
			{
				$j('#maincontainer').html('');
				window.location=base_path;
				return false;
			}
			//$j('#update-message').html('');
			//inner tab menu
				if(parentTab!='')
				{
					var test='<ul class="tabber">';
					$j('#'+parentTab+' ul').find('li').each(function(){
					id=$j(this).children('a').attr("id");
					test+='<li id="inner'+id+'" onclick=$j("#'+id+'").trigger("click"); >'+$j(this).html()+'</li>';
					});
					test+='</ul>';
					$j(".tabMenu").html(test);
				}
				else
				{
					$j(".tabMenu").html('');					
				}
				$j("#inner"+innerId).addClass('current-tab');
				//close inner tab menu
		});
		
		
	});
	});
}
initMenu();
	

function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function ltrim(stringToTrim) {
	return stringToTrim.replace(/^\s+/,"");
}
function rtrim(stringToTrim) {
	return stringToTrim.replace(/\s+$/,"");
}
function totalPendingHireRequest()
{
	$j.ajax({
		type: "POST",
		url: base_path+"seeker/totalHireRequest",
		data: "",
		cache: false,
		success: function(data)
		{
			
			if(trim(data)=='logout')
			{
				clearInterval(autoRefreshSeeker);
				window.location=base_path;
				return false;
			}
			else if(parseInt(data)>0)
			{				
				var html='<a class="spch-bub-inside" href="javascript:;"><span class="point"></span><em><b>'+data+'</b></em></a>';
				$j('.bubbleAlert').html(html);
			}
		}
	});		
}