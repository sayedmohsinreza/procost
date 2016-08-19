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
        <h2 class="form-signin-heading">Procost Model</h2>
        <h5 >Research, Development and Innovation Project</h5>
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


print ' </div>';
include('footer.php');
?>