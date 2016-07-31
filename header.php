<?php
include('connect.php');
include('include.php');
print '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Procost Model</title>

	<script src="bootstrap-3.3.6/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <link href="bootstrap-3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script> 
$(document).ready(function(){
		$("#content").hide()
		$("#pb").animate({    width: \'100%\'}, Math.floor((Math.random() * 5000) + 2500), function(){
		
		$("#pb-box").remove()
		$("#content").show()
		})
		//$("#pb-box").remove()
});
</script> 
  </head>
  <body>';
$message = array('Intializing...','Loading...','Digitizing...');
  
  print '<div class="container">
		<div id="pb-box">
	<div  class="progress" style=" margin-top: 30px;">
    <div id="pb" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
      </div>
	  	  </div>
		  
		  <h1>'.$message[rand(0,count($message)-1)].'</h1>
  </div>';
  ?>
  