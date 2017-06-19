/*$(function (){
 	'use strict';

	 	// hide placeholder on focus
	 	$('[placeholder]').focus(function(){
	     // selector place holder -> []	
	     	$(this).attr('data-text', $(this).attr('placeholder'));
	     	$(this).attr('placeholder', '');
	 	}).blur(function(){
	      $(this).attr('placeholder', $(this).attr('data-text'));
	 	});
	 	// end function
});*/
/*$(document).ready(function(){

	$('.ajax').click(function(){
      $.ajax({
      	url:'',
      	success: function(){


      	}
      });
	});
});*/
$(function (){

	$('#password, #password_again').on('keyup', function () {
		var password = $('#password').val();
		var confirmPassword = $('#password_again').val();


	  if(password.length > 0 && password.length <= 5){
	  	$('#pass').html('<div class="progress"><div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40"aria-valuemin="0" aria-valuemax="100" style="width:40%"> Weak </div></div>');
	  }else if(password.length >= 5 && password.length <= 10){
        $('#pass').html('<div class="progress"><div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="70"aria-valuemin="0" aria-valuemax="100" style="width:70%"> Good </div></div>');
	  }else if(password.length >= 10){
	  	$('#pass').html('<div class="progress"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100"aria-valuemin="0" aria-valuemax="100" style="width:100%"> Strong </div></div>');
	  }
	  if(confirmPassword == password){
	  $('#password_again').html('').css('background-color','#45f94e');	
	  $('#conpass').html('Matched correctly').css('color','green');
	  }else if(confirmPassword != password){
	  	$('#conpass').html('Not matching').css('color','#000');
	  	$('#password_again').html('').css('background-color','#ea4848');
	  }

	});

});