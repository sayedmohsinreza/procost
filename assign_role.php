<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];


$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'add_new_task.php?pid='.$project_id.'','text'=>'Add New Task','icon'=>'plus');
$button_menu[] = array('link'=>'project_roles.php?pid='.$project_id.'','text'=>'See Project Roles','icon'=>'info-sign');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard');
button_menu_create($button_menu);


print page_header('Assign Project Role');



if(isset($_POST['assign_role'])){
if(sizeof($_POST['person'])==0 || sizeof($_POST['role'])==0 ){
 set_input_text('Warning','Please try again and select at least one person and one role');
print'<p align="left"><a href="'.$_SERVER['PHP_SELF'].'?pid='.$project_id.'" class="btn btn-primary" type="button">Try Again</a></p>';

exit;
}else{
reset($_POST['person']);
while (list($key, $val) = each($_POST['person'])){
reset($_POST['role']);
while (list($key2, $val2) = each($_POST['role'])){
$assign_query= "INSERT INTO `project_person` (`id`, `id_project`, `id_person`, `id_role`,`assigned_by`, `assinged_time`) 
VALUES (NULL, '".$project_id."', '".$val."', '".$val2."', '1', CURRENT_TIMESTAMP);";
if(mysql_query($assign_query)){
print '<div class="alert alert-success"> person/Paper ID '.$val.' is assigned to role '.$val2.' suceesfully.</div>';
}else{
print '<div class="alert alert-danger"> person/Paper ID '.$val.' was already assigned role '.$val2.'. </div>';
}
//print $assign_query;
//print 'hello'.$val .'and'  .$val2.'<br>';
}


}

}
}


form_start('',$_SERVER['PHP_SELF'].'?pid='.$project_id);
set_input_text('Note','Left side contain person name and Right side contain role name');
set_input_text('Person Structure','(No of assign in <b>all</b> project) (No of assign in <b>current</b> project) Name');
set_input_text('Role Structure','(No of assign in <b>all</b> project) (No of assign in <b>current</b> project) Role Name');
set_input_text('Project',value_return('SELECT `title` FROM `project` WHERE `id`='.$project_id));





button_create();
design();
button_create();

print '</form>';

function design(){
print '    <div class="well well-sm">';
    
	print '<table class="table table-bordered">';
$query3 = "SELECT id,concat(`firstname`,' ', `lastname` , ' ( ',`email`,' )') as info FROM `contact_person` WHERE `is_active`=1";
$query4 = "SELECT `id`, `title` FROM `project_role`";

print '<tr><td>';
$k = dropdown('<b>Select Person</b>','person[]',$query3,'','','T');
print $k.' Person';
print ' </td>';

print '<td>';
$lo = dropdown_2nd('<b>Select Role</b>','role[]',$query4,'','','T');
print $lo.' Role';
print ' </td>';

print '</table>';
   print ' </div>';

}


function dropdown($label,$name,$query,$class='',$value='',$multiple=''){
//in query you must select 2 column first for value and 2nd for show message
if($class=='')$class='form-control';
//print '<div class="control-group info">';
print '<label control-label for="'.$name.'">'.$label.'</label>';
//print '<div class="controls">';
if($multiple !=''){
$mul=' multiple="multiple"';
}else{
$mul='';
}
print '<select name='.$name.'  class="'.$class.'" size="10" '.$mul.'> ';
$k=0;
$result= mysql_query($query);
while($row = mysql_fetch_array($result)){
$count_person_query = 'SELECT count(*) FROM `project_person` WHERE `id_person`='.$row[0];
$count_project_person_query = 'SELECT count(*) FROM `project_person` WHERE id_project = '.$GLOBALS['project_id'].' and`id_person`='.$row[0];
$count_person = value_return($count_person_query);
$count_project_person = value_return($count_project_person_query);
if($value==$row[1]){
print '<option value="'.$row[0].'"  selected="selected" >('.$count_person.') ('.$count_project_person.') '.$row[1].'</option>';
$k++;
}else{
print '<option value="'.$row[0].'"  '.$mul.'>('.$count_person.') ('.$count_project_person.')'.$row[1].'</option>';
$k++;
}
}

print'</select>';
return $k;
}

function dropdown_2nd($label,$name,$query,$class='',$value='',$multiple=''){
//in query you must select 2 column first for value and 2nd for show message
//print '<div class="control-group info">';
print '<label control-label for="'.$name.'">'.$label.'</label>';
if($class=='')$class='form-control';
//print '<div class="controls">';
if($multiple !=''){
$mul=' multiple="multiple"';
}else{
$mul='';
}
print '<select name='.$name.'  class="'.$class.'" size="10" '.$mul.'> ';
$lo=0;
$result= mysql_query($query);
while($row = mysql_fetch_array($result)){
$count_person_query = 'SELECT count(*) FROM `project_person` WHERE `id_role`='.$row[0];
$count_project_person_query = 'SELECT count(*) FROM `project_person` WHERE id_project= '.$GLOBALS['project_id'].' and `id_role`='.$row[0];
$count_person = value_return($count_person_query);
$count_project_person = value_return($count_project_person_query);
if($value==$row[1]){
print '<option value="'.$row[0].'"  selected="selected" >('.$count_person.') ('.$count_project_person.') '.$row[1].'</option>';
$lo++;
}else{
print '<option value="'.$row[0].'"  '.$mul.'>('.$count_person.') ('.$count_project_person.') '.$row[1].'</option>';
$lo++;
}
}

print'</select>';
return $lo;
}

function button_create(){
print' <div>';
print '<input class="btn btn-default" name="assign_role" type="submit" value="Assign Project Role">';

print' </div>';
}


	


?>
