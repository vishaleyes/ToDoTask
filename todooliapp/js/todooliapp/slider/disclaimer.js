function viewDisclaimer() {
	var x = screen.width / 2;
		x -= 250;
		
	var y = screen.height / 2;
		y -= 150;
		
	window.open( 'disclaimer.html', 'disclaimer', 'height=250,width=500,modal=yes,alwaysRaised=yes,screenX=' + x + ',screenY=' + y );
	
	return false;
}
