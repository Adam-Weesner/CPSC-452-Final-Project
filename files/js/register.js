$(document).ready(function(){
  // When this element is clicked, hide the loginForm and show the registerForm
  $("#hideLogin").click(function(){
    $("#loginForm").hide();
    $("#registerForm").show();
  });
  // When this element is clicked, show the loginForm and hide the registerForm
  $("#hideRegister").click(function(){
    $("#loginForm").show();
    $("#registerForm").hide();
  });
});
