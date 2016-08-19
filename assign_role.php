<?php
include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];
print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_task.php?pid='.$project_id.'" class="btn btn-sm btn-primary">Add New Task</a> | ';
print '<a href="assign_role.php?pid='.$project_id.'" class="btn btn-sm btn-primary">Assign Project Role</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';
print '<div class="page-header">
        <h1>Assign Project Role</h1>
      </div>';



if(isset($_POST['assign_role'])){
if(sizeof($_POST['person'])==0 || sizeof($_POST['role'])==0 ){
 set_input_text('Warning','Please try again and select at least one person and one role');
print'<p align="left"><a href="assign_role.php" class="btn btn-primary" type="button">Try Again</a></p>';

printfooter();
exit;
}else{
reset($_POST['person']);
while (list($key, $val) = each($_POST['person'])){
reset($_POST['role']);
while (list($key2, $val2) = each($_POST['role'])){
$assign_query= "INSERT INTO `confpaperrole` (`paperid`, `roleid`, `completed`, `assignerid`) VALUES ('".$val."', '".$val2."', 'F', '0');";
if(mysql_query($assign_query)){
print '<div class="alert alert-success"> person/Paper ID '.$val.' is assigned to role '.$val2.' suceesfully.</div>';
$paper_title= value_return('SELECT title FROM paper where pid='.$val);
$info_role = multiple_value_1row('SELECT `username`, `password`, `name`, `email` FROM `confrole` where roleid='.$val2);
$subject_mail='Greetings from '.$conf_name.': Review System';
$body_mail='Dear '.$info_role[2].',<br><br>
We would like to inform you that the <b>'.$conf_name.'</b> Technical Program Committee (TPC) has assigned the following paper(s) to you:<br><br>
<b>Paper ID: </b>'.$val.'<br>
<b>Paper Title: </b>'.$paper_title.'<br><br>
Please log in to our paper review system.<br><br>
You can log in to <a href="http://'.$_SERVER['SERVER_NAME'].'/proconf2016/review/login.php"> '.$conf_name.' Review System</a> with your <b>username: </b>'.$info_role[0].' . <br> <br>

We are humbly requesting you to complete the review. Your cooperation is essential for the success of the conference and it will be greatly appreciated.<br>
For More Information please visit <a href="'.$conf_url.'">'.$conf_name.' Website</a> <br>
Email us to at <a href="mailto:'.$conf_email.'">'.$conf_email.'</a><br><br>

Thank you in advance.<br><br>
Sincerely<br>
The '.$conf_name.' Committee';

send_email($conf_email,$info_role[3],$subject_mail,$body_mail,'Mail sent to '.$info_role[3].' successfully.','Mail is not sent. Try again');
//print $body_mail;


}else{

print '<div class="alert alert-error"> person/Paper ID '.$val.' was already assigned role '.$val2.'. </div>';
}
//print $assign_query;
//print 'hello'.$val .'and'  .$val2.'<br>';
}


}

}
}


form_start();
set_input_text('Note','Left side contain person name and Right side contain role name');
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
$count_person = value_return($count_person_query);
if($value==$row[1]){
print '<option value="'.$row[0].'"  selected="selected" >('.$count_person.') '.$row[1].'</option>';
$k++;
}else{
print '<option value="'.$row[0].'"  '.$mul.'>('.$count_person.') '.$row[1].'</option>';
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
$count_person = value_return($count_person_query);
if($value==$row[1]){
print '<option value="'.$row[0].'"  selected="selected" >('.$count_person.') '.$row[1].'</option>';
$lo++;
}else{
print '<option value="'.$row[0].'"  '.$mul.'>('.$count_person.') '.$row[1].'</option>';
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
