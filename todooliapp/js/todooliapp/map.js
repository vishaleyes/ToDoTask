function gmapLoad()
{
	if(isLocation)
			initialize();
		else
		{
			$j('#map_canvas').css("height","auto");
			$j('#map_canvas').css("padding","0px 5px 0px 5px");
			$j('#map_canvas').css("border","solid 1px #f7c9c9");
			$j('#map_canvas').css("background","#FEECEC");
			$j('#map_canvas').css("text-align","left").html(msg['_MAP_NULL_MESSAGE_']);
		}
}
  function initialize() {
	
		zoomlevel=5;
	if($j("#location_value_seeker input[type='hidden']").length<=2)
	{
		zoomlevel=11;
	}
   	var latlng = new google.maps.LatLng(lat, lng);
   	var initLocLat,initLocLng;
   	var marker,marker1;
    var myOptions = {
      zoom: zoomlevel,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);

    var infowindow = new google.maps.InfoWindow();

    var bounds = new google.maps.LatLngBounds();
  
	//display radius in map for all location of seeker 
  	var countAll = 0;
	var loc_value = new Array();
	
	$j("#location_value_seeker input[type='hidden']").each(function(i,value){
	
		loc_value = $j(this).val().split('*');
		initLocLat=loc_value[0];
		initLocLng=loc_value[1];
		var latlangval = new google.maps.LatLng(loc_value[0], loc_value[1]);
		bounds.extend(latlangval);
		var circle = new google.maps.Circle({
			center: latlangval,
		  radius: parseInt(Math.ceil(loc_value[2] * 1609.344)),    // 10 miles in metres
		  fillColor: '#B3D4DE'
		});
		circle.setMap(map);
		marker1 = new google.maps.Marker({
	        position: new google.maps.LatLng(loc_value[0],loc_value[1]),
	        map: map,
			icon:base_path+'images/map-icon/location.png'
	      });
	      
		var myOptions = getInfoBoxContent(loc_value[3]+"<br>You will get alerts in "+ loc_value[2] +" miles around");
			
		var ib = new InfoBox(myOptions);

		google.maps.event.addListener(marker1, "mouseover", function (e) {
			ib.open(map, this);
		});
		google.maps.event.addListener(marker1, 'mouseout', function(e) {
			ib.close(map, this);
	    });	
		countAll++;	
	});
	
	var count = 0;
  	count = $j("#location_value input[type='hidden']").length;
	
	//var location = new Array(count);
	var location_value = new Array();
	$j("#location_value input[type='hidden']").each(function(i,value){
		location_value = $j(this).val().split('*');
        var point = new google.maps.LatLng(location_value[3],location_value[4]);
        bounds.extend(point);
	  	marker = new google.maps.Marker({
	        position: point,
	        map: map,
	        icon:new google.maps.MarkerImage(base_path+'images/map-icon/job.png')
	      }); 
		if(location_value[5]==1)
		{    
	  		popupHtml=location_value[1]+"<br>"+location_value[0]+"<br>Hire Request For "+location_value[2];	    
		}
		else if(location_value[5]==2 || location_value[5]==3)
		{
			popupHtml=location_value[0]+"<br>"+location_value[5]+" jobs at this location."+location_value[2];
		}
		else
		{
			popupHtml=location_value[0]+"<br> More than 3 jobs at this location."+location_value[2];
		}
	  	var myOptions = getInfoBoxContent(popupHtml);

		var ib = new InfoBox(myOptions);

		google.maps.event.addListener(marker, "mouseover", function (e) {
			ib.open(map, this);
		});
		google.maps.event.addListener(marker, 'mouseout', function(e) {
			ib.close(map, this);
	    });
	});
	var count = 0;
  	count = $j("#occupationicon input[type='hidden']").length;
	var occupation = new Array(count);
	var occupation_value = new Array();
	for(i=0 ; i<count ; i++)
		occupation[i] = new Array(3);
	$j("#occupationicon input[type='hidden']").each(function(i,value){
		occupation_value = $j(this).val().split(',');
		
		occupation[i][0] = occupation_value[0];
		});
	if(countAll <= 1)
	{
		var latlng = new google.maps.LatLng(initLocLat, initLocLng);
		map.setOptions({
			zoom: 8,
		    center: latlng
		});
	}	
	else
	{	
			map.setZoom(map.fitBounds(bounds));
	} 
  }
  