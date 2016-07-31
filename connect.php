<?php
// Connecting, selecting database

  $link = mysql_connect('localhost', 'root', '')
    or die('Could not connect: ' . mysql_error());
//echo 'Connected successfully';

  mysql_select_db('procost') or die('Could not select database');

?>