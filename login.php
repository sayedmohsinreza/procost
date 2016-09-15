<?php
include('header.php');

print ' <link href="bootstrap-3.3.6/css/signin.css" rel="stylesheet">';
print '  <div id="content">';

//ini_set('session.save_path', '/session_tmp');
//error_reporting(E_ALL);
//ini_set('display_errors', 1); 
session_start();
header("Cache-control: private"); 
if(isset($_POST['submit'])){
$username_posted = $_POST['email_user'];
$password_posted= $_POST['pass_user'];
//this 2 lines prevent sql injection
$username_posted = mysql_real_escape_string($username_posted);
$password_posted = mysql_real_escape_string($password_posted);
//print 'Username: '.$username .' & Password: '.$password;

if(value_return("SELECT count(*) FROM `contact_person` WHERE `email`='".$username_posted."' and `password`='".$password_posted."'")>0){
// store session data
$_SESSION['id'] = value_return("SELECT id FROM `contact_person` WHERE `email`='".$username_posted."' and `password`='".$password_posted."'");
$_SESSION['username']=$username_posted;
$_SESSION['password']=$password_posted;

//echo 'tare'.$_SESSION['admin_username'];
//echo $_SESSION['admin_password'];
header('Location: index.php');
exit;
}else{
alert_div_message('Your Username/Password is incorrect.try again.',$class='danger');

}
}


  print '<form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">Procost Model '.$extra_info.'</h2>
        <h5 >Research, Development and Innovation Project</h5>
        <button type="button" class="btn btn-default btn-sm btn-block" data-toggle="modal" data-target="#myModal">
  '.icon('info-sign').' About PROCOST
</button>
        <h3 class="form-signin-heading">Please sign in</h3>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email_user" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="pass_user" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>';
print '
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">PROCOST MODEL</h4>
      </div>
      <div class="modal-body">';
        print page_header(icon('info-sign').' Thesis information','h5');
print THESIS_INFO;
print page_header(icon('info-sign').' Basic  information','h5');
print BASIC_INFO;
print page_header(icon('info-sign').' History','h5');
print HISTORY_INFO;  
      print'</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>';

print ' </div>';
include('footer.php');
?>