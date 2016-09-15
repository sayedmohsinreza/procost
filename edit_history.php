<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$history_id = $_GET['history_id'];

$task_id = mysql_fetch_array_nullsafe('SELECT `task_id` FROM `task_history` WHERE `id`='.$history_id.'')[0];
$project_id = mysql_fetch_array_nullsafe('SELECT `id_project` FROM `project_task` WHERE `id`='.$task_id.'')[0];
$button_menu[] = array('link'=>'my_task.php','text'=>'My Task');
$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project','icon'=>'plus','class'=>'primary');
$button_menu[] = array('link'=>'see_history.php?task_id='.$task_id.'','text'=>'See Task History','icon'=>'plus','class'=>'primary');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'plus','class'=>'primary');
button_menu_create($button_menu);




$task_name = value_return('SELECT `title` FROM `project_task` WHERE `id`='.$task_id.'');
print '<div class="page-header"><h1>Task : '.$task_name.'</h1>
      </div>';
print '<div class="page-header">
        <h4>Update Exist History </h4>
      </div>';
	  
	  if(isset($_POST['submit'])){

$field['project_id'] = $project_id;
$field['person_id'] = $_POST['task_person'];
$field['task_id'] = $task_id;
$field['activity_id'] = $_POST['activity_id'];
$field['status_id'] = $_POST['status_id'];
$field['closed'] = $_POST['closed_status'];
$field['start_on'] = $_POST['hist_start'];
$field['end_on'] = $_POST['hist_end'];
$field['assigned_by'] = $_SESSION['id'];

if($_POST['closed_status']==1){
  $curr_timestamp = date('Y-m-d H:i:s');
$field['closed_at'] = $curr_timestamp;
}

UpdateTable("task_history",$field," id=".$history_id);

}

$data_history = SelectTableRecords("SELECT `id`, `project_id`, `person_id`, `task_id`, `activity_id`, `status_id`, `closed`, `start_on`, `end_on`, `assigned_by`, `closed_at` FROM `task_history` WHERE `id`=".$history_id);

form_start('',$_SERVER['PHP_SELF'].'?history_id='.$history_id);
$person_query = "SELECT cr.`id`, concat(`firstname`,' ', `lastname`,' (',`email`,') - [ ',prole.title,' ]') as info FROM `project_person` as pr,`contact_person` as cr, `project_role` as prole WHERE pr.`id_person`=cr.`id` and prole.id=pr.id_role and  pr.`id_project`=".$project_id;
input_dropdown_query_manual('Assigned To','task_person',$person_query,1,$data_history[0]['person_id']);

$activity_query = "SELECT `id`, `title` FROM `project_activity`";
input_dropdown_query_manual('Activity','activity_id',$activity_query,1,$data_history[0]['activity_id']);

$status_query = "SELECT `id`, `title` FROM `project_status` ORDER BY `id` DESC";
input_dropdown_query_manual('Status','status_id',$status_query,1,$data_history[0]['status_id']);

input_dropdown_manual('Open/closed','closed_status',array('0'=>'Open','1'=>'Close'),'',$data_history[0]['closed']);
input_date('Start','hist_start',$data_history[0]['start_on']);
input_date('End','hist_end',$data_history[0]['end_on']);

        
print '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" name="submit" id="submit" class="btn btn-primary">'.icon('floppy-open').' Update</button>
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
  if($value==$row[0]){
print '<option value="'.$row[0].'" selected="selected">'.$row[1].'</option>';
}else{
print '<option value="'.$row[0].'">'.$row[1].'</option>';
}
}
print '</select>';
print '</div></div>';

}


function input_dropdown_manual($label,$name,$arr,$class='',$value='',$size=10,$print='T'){
//in query you must select 2 column first for value and 2nd for show message
$str='';
if($class=='')$class='form-control';
$label_size = 12 - $size;
$str.=  '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$size.'">';
$str.=   '<select name='.$name.' class="'.$class.'"> ';
reset($arr);
while (list($key, $val) = each($arr)){
if($value==$key){
$str.=   '<option value="'.$key.'" selected="selected" >'.$val.'</option>';
}else{
$str.=   '<option value="'.$key.'">'.$val.'</option>';
}
}
$str.=  '</select>';
$str.=   '</div></div>';
if($print=='T')print $str; else return $str;
}
?>