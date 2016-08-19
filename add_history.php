<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$task_id = $_GET['task_id'];
$project_id = mysql_fetch_array_nullsafe('SELECT `id_project` FROM `project_task` WHERE `id`='.$task_id.'')[0];

$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project','icon'=>'plus','class'=>'primary');
$button_menu[] = array('link'=>'see_history.php?task_id='.$task_id.'','text'=>'See Task History','icon'=>'plus','class'=>'primary');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'plus','class'=>'primary');
button_menu_create($button_menu);




$task_name = value_return('SELECT `title` FROM `project_task` WHERE `id`='.$task_id.'');
print '<div class="page-header"><h1>Task : '.$task_name.'</h1>
      </div>';
print '<div class="page-header">
        <h4>Add New History </h4>
      </div>';
	  
	  if(isset($_POST['submit'])){
$field['id'] = NULL;
$field['project_id'] = $project_id;
$field['person_id'] = $_POST['task_person'];
$field['task_id'] = $task_id;
$field['activity_id'] = $_POST['activity_id'];
$field['status_id'] = $_POST['status_id'];
$field['closed'] = $_POST['closed_status'];
$field['start_on'] = $_POST['hist_start'];
$field['end_on'] = $_POST['hist_end'];
$field['assigned_by'] = $_SESSION['id'];


InsertInTable("task_history",$field);

}

form_start('',$_SERVER['PHP_SELF'].'?task_id='.$task_id);
$person_query = "SELECT cr.`id`, concat(`firstname`,' ', `lastname`,' (',`email`,') - [ ',prole.title,' ]') as info FROM `project_person` as pr,`contact_person` as cr, `project_role` as prole WHERE pr.`id_person`=cr.`id` and prole.id=pr.id_role and  pr.`id_project`=".$project_id;
input_dropdown_query('Assigned To','task_person',$person_query,1);

$activity_query = "SELECT `id`, `title` FROM `project_activity`";
input_dropdown_query('Activity','activity_id',$activity_query,1);

$status_query = "SELECT `id`, `title` FROM `project_status` ORDER BY `id` DESC";
input_dropdown_query('Status','status_id',$status_query,1);
input_dropdown('Open/closed','closed_status',array('0'=>'Open','1'=>'Close'));
input_date('Start','hist_start');
input_date('End','hist_end');
//$person_query = "SELECT cr.`id`, concat(`firstname`,' ', `lastname`,' (',`email`,') - [ ',prole.title,' ]') as info FROM `project_person` as pr,`contact_person` as cr, `project_role` as prole WHERE pr.`id_person`=cr.`id` and prole.id=pr.id_role and     pr.`id_project`=".$project_id;
//input_dropdown_query('Assigned To','task_person',$person_query,5);
        
print '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i> Cancel</a>
    </div>
    </div>';

		
form_end();
    
        
  

  
//end farmework  
print ' </div>';
include('footer.php');

?>