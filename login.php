<?php
include('header.php');
print ' <link href="bootstrap-3.3.6/css/signin.css" rel="stylesheet">';
print '  <div id="content">';

  
  print '<form class="form-signin" action="index.php" method="post">
        <h2 class="form-signin-heading">Procost Model</h2>
        <h5 >Research, Development and Innovation Project</h5>
        <h3 class="form-signin-heading">Please sign in</h3>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>';


print ' </div>';
include('footer.php');
?>