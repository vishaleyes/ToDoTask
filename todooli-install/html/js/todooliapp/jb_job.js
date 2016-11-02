var fStack=new JoomStack();
var delimiter=",";
var expiredDays=3;
var maximum_allow=25;
var prefix_char='';

/**
 * Loads data from cookies, assigns values to arr_items and total_items
 */
function init(){ 
	string_items=getStringItems();
	if (string_items!=null && string_items!=""){
		arr_items=string_items.split(delimiter);
		//alert(arr_items);
		for (i=0;i<arr_items.length;i++){
			addItem(arr_items[i]);
		}
		updateCounter();
		showCheckbox();
	}
}
var dom2=document.getElementById;
function changeInner(id,value){
	
	obj=fetch_object(id);
	//alert(obj);
	if (dom2){
			obj.innerHTML=value;
	} else if (ns){
			obj.open();
			obj.write(value);
			obj.close();
	} else {
			obj.innerHTML=value;
	}
}

function updateCheckbox(object){ 
	if (object.checked==true){
		if(!addItem(object.value)){
			object.checked=false;
			return false;
		}
	} else {
		removeItem(object.value);
	}
	saveStringItems();
//	alert(fStack.size());
	updateCounter();
	return true;
}

function showCheckbox(){  
	arr_items=fStack.toArray();
	for (anItem in arr_items){
		chk=fetch_object("f_"+arr_items[anItem]);
		if (chk!=null){
			chk.checked=true;
		} 
	}
	if (allChecked()){
		document.getElementById("checkall").checked=true;
	}
}

function updateCounter(){  
	//changeInner("total_selected",fStack.size());
}

function saveStringItems(){  

	setCookie("listjobs",fStack.toString(delimiter),expiredDays,"/","","");
}

function getStringItems()
{ 
	return getCookie("listjobs");
}

function addItem(id){ 
	if (fStack.size()>=maximum_allow){
		alert("Number of providers can not exceed " + maximum_allow);
		return false;
	} else {
		fStack.plusPush(id); 
		fStack.push(id);
		return true;
	}
}

function removeItem(id){ 
	var status = false; 
	status = fStack.diffPush(id);
	if(status) fStack.removeItem(id);
}

function listselected(url){
	if (fStack.isEmpty()){
		alert("You haven't selected any providers yet");
	} else {
		obj=fetch_object("doselected");
		task=obj.options[obj.selectedIndex].value;
		window.location=url+task+"&ids="+fStack.toString();
	}
}

function listselected1(url){
	if (fStack.isEmpty()){
		alert("You haven't selected any providers yet");
	} else {		
		window.location=url+"&ids="+fStack;
	}
}

function toggleUpdate(topCheckbox){ 
	
	var rows=document.getElementsByTagName('input');
	
	for (f=0;f<rows.length;f++){
		checkbox=rows[f];
		if (checkbox && checkbox.type=='checkbox'){			
			if (checkbox.id.charAt(0)==prefix_char){
				if (topCheckbox.checked){
					//remove	
					checkbox.checked=true;
				} else {
					checkbox.checked=false;
				}
				if(!updateCheckbox(checkbox)){//can not update any more, cause exeed the 
					return;
				}
			}
		}
	}	
	updateCounter();
	showCheckbox();
}

function checkAllFreelancers() {
	var rows=document.getElementsByTagName('input');
	for (f=0;f<rows.length;f++){
		checkbox=rows[f];
		if (checkbox && checkbox.type=='checkbox'){			
			if (checkbox.id.charAt(0)==prefix_char){
				checkbox.checked=true;
				if(!updateCheckbox(checkbox)){//can not update any more, cause exeed the 
					return;
				}
			}
		}
	}	
	updateCounter();
	showCheckbox();
}

function allChecked(){  
	var rows=document.getElementsByTagName('input');
	
	for (f=0;f<rows.length;f++){
		checkbox=rows[f];
		if (checkbox && checkbox.type=='checkbox'){
			if (checkbox.id.charAt(0)==prefix_char){
				if (!checkbox.checked){
					return false;
				}
			}
		}
	}	
	return true;
}
//init();
