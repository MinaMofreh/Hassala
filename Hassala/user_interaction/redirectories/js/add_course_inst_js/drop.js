/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$(document).ready(function(){
      $("#drop_course_button").click(function(){
        $("#course_form").hide();
        $("#form").toggle(400);
       
    });
    
       $("#add_course").click(function(){
        $("#form").hide();
        $("#course_form").toggle(500);
        
    });
});


