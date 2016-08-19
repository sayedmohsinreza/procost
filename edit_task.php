<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$task_id = $_GET['task_id'];
$task_info = multiple_value_1row("SELECT `id`, `id_project`, `id_parenttask`, `title`, `description`, `id_person_owner`, `date_start`, `date_end`, `status_id`, `estimated_workload` FROM `project_task` WHERE `id`=".$task_id);
print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="project_effort.php?pid='.$task_info[1].'" class="btn btn-sm btn-primary">Project Details</a> | ';
print '<a href="see_history.php?task_id='.$task_id.'" class="btn btn-sm btn-primary">See Task History</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';
print '<div class="page-header">
        <h1>Projects : '.value_return('SELECT `title` FROM `project` WHERE `id`='.$task_info[1].'').'</h1>
      </div>';


        
print '<div class="page-header">
        <h4>Add New Task </h4>
      </div>';


	  if(isset($_POST['submit'])){

$field['title'] = $_POST['task_name'];
$field['description'] = $_POST['task_desc'];
$field['date_start'] = $_POST['task_start'];
$field['date_end'] = $_POST['task_end'];
$field['status_id'] = $_POST['status_id'];
$field['estimated_workload'] = $_POST['workload'];

UpdateTable("project_task",$field,"id=".$task_id);

}
form_start('',$_SERVER['PHP_SELF'].'?task_id='.$task_id);
	  
input_text('Task Name','task_name',$task_info[3]);
input_area('Description','task_desc',$task_info[4]);

input_date('Task Start','task_start',$task_info[6]);
input_date('Task End','task_end',$task_info[7]);
print date_dependency('task_start','task_end');
$status_query = "SELECT `id`, `title` FROM `project_status` ORDER BY `id` DESC";
$selected_status_title =value_return("SELECT `title` FROM `project_status` WHERE `id`=".$task_info[8]); 
input_dropdown_query('Status','status_id',$status_query,1,$selected_status_title);
input_text('Estimated Workload(H)','workload',$task_info[9]);
//$person_query = "SELECT cr.`id`, concat(`firstname`,' ', `lastname`,' (',`email`,') - [ ',prole.title,' ]') as info FROM `project_person` as pr,`contact_person` as cr, `project_role` as prole WHERE pr.`id_person`=cr.`id` and prole.id=pr.id_role and     pr.`id_project`=".$project_id;
//input_dropdown_query('Assigned To','task_person',$person_query,5);
        
print '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i> Cancel</a>
    </div>
    </div>';

		
form_end();
    
        
  

  
//end farmework  
print ' </div>';
include('footer.php');

?>