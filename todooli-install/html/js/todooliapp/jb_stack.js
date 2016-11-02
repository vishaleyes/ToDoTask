// JavaScript Document
function JoomStack(){
	var stack=new Array();
	var countStack = new Array();
	this.push=push;
	this.pop=pop;
	this.isEmpty=isEmpty;
	this.removeItem=removeItem;
	this.toArray=toArray;
	this.exists=exists;
	this.size=size;
	
	this.toString=toString;
	
	function push(anItem){
		if (!this.exists(anItem)){
			stack.push(anItem);
		}
	}
	
	this.plusPush = function (anItem){
		if (this.exists(anItem)){
			countStack[anItem] = countStack[anItem] + 1;
		}
		else{
			countStack[anItem] = 1;
		}
	}
	this.diffPush = function (anItem){
		if(countStack[anItem] > 1){
			countStack[anItem] = countStack[anItem] - 1;
			return false;
		}
		else{
			countStack[anItem] = countStack[anItem] - 1;
			return true;				
		}
	}
	
	function empty(){
			stack=new Array();
	}
	
	function size(){
		return stack.length;
	}
	
	function pop(){
		return stack.pop();
	}
	
	function removeItem(anItem){
		index=indexOf(anItem);
		
		if (index!=-1){
			stack.splice(index,1);
		}
		
	}
	
	function indexOf(anItem){
		for (i=0;i<stack.length;i++){
			if (stack[i]==anItem) return i;
		}
		return -1;
	}
	
	function exists(anItem){
		return inArray(stack,anItem);
	}
	
	function inArray(anArray,value){
		var i;
		for (i=0; i < anArray.length; i++) {
			if (anArray[i] === value) {
				return true;
			}
		}
		return false;
	}
	
	function toString(delimiter){
		return stack.join(delimiter);
	}
	
	function toArray(){
		return stack;
	}
	
	function isEmpty(){
		return (stack.length==0);
	}
	
}

