<?php
ob_start();
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');


$button_menu[] = array('link'=>'index.php','text'=>'Back to Home','icon'=>'home');
button_menu_create($button_menu);

print page_header('PROCOST');




print page_header(icon('info-sign').' Thesis information','h5');
print THESIS_INFO;
print page_header(icon('info-sign').' Basic  information','h5');
print BASIC_INFO;
print page_header(icon('info-sign').' History','h5');
print HISTORY_INFO;  
//end farmework  
print ' </div>';
include('footer.php');

?>