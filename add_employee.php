<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');
//menu
$button_menu[] = array('link'=>'employees.php','text'=>'Employees','icon'=>'user');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'home','class'=>'primary');
button_menu_create($button_menu);
//menu     
print page_header('Add Employee','h3');


	  if(isset($_POST['submit'])){
$field['id'] = NULL;
$field['id_person_create'] = $_SESSION['id'];
$field['password'] = $_POST['password'];
$field['email'] = $_POST['email'];
if(isset($_POST['is_admin'])){$field['is_admin'] = 1;}else{$field['is_admin'] = 0;}
if(isset($_POST['is_active'])){$field['is_admin'] = 1;}else{$field['is_admin'] = 0;}
$field['firstname'] = $_POST['firstname'];
$field['lastname'] = $_POST['lastname'];
$field['id_jobtype'] = $_POST['id_jobtype'];


InsertInTable("contact_person",$field);

}

	  
form_start($form_name,'','','');        
input_text('Employee First Name','firstname','','',10,'',false,'T');
input_text('Employee last Name','lastname','','',10,'',false,'T');
print input_checkbox_without_label('is_admin','','Admin',10,'');
input_text('Email','email','','',10,'',false,'T');
input_text('Password','password','','',10,'',false,'T');
print input_checkbox_without_label('is_active','','Active',10,'');
input_dropdown_query_manual('Job Position','id_jobtype','SELECT `id`, `title` FROM `contact_jobtype` ',1,'','',10);
print '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" name="submit" id="submit" class="btn btn-primary">'.icon('plus').' Add</button>
    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i> Cancel</a>
    </div>
    </div>';
		
form_end();
    
        
  

  
//end farmework  
print ' </div>';
include('footer.php');

function input_dropdown_query_manual($label,$name,$query,$size,$value='',$class='',$input_size=10){
//in query you must select 2 column first for value and 2nd for show message
if($class=='')$class='form-control';
$label_size = 12 - $input_size;
print '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$input_size.'">';
print '<select class="'.$class.'" name="'.$name.'" size = "'.$size.'" >';
$result = mysql_query($query);
  while($row= mysql_fetch_array($result)){
  if($value==$row[1]){
print '<option value="'.$row[0].'" selected="selected">'.$row[1].'</option>';
}else{
print '<option value="'.$row[0].'">'.$row[1].'</option>';
}
}
print '</select>';
print '</div></div>';

}
?>