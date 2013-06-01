function toggle1(){
  	var signin_menu = document.getElementById('signin_menu')
  	if (signin_menu.style.display == 'none') {
  		signin_menu.style.display = 'block'
  	} else {
  		signin_menu.style.display = 'none'
  	}
  }
$(document).ready(function(){
    
    $("input#FindPartyForm_addressInput").Watermark("Address, Neighborhood, City, State or Zip");
    
  

});
