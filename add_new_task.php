<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];


$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'project_effort.php?pid='.$project_id.'','text'=>'Project Details','icon'=>'info-sign');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard');
button_menu_create($button_menu);


print page_header('Projects : '.value_return('SELECT `title` FROM `project` WHERE `id`='.$_GET['pid'].'').'');


     if(!value_return('SELECT count(*) FROM `project_person` WHERE `id_project`='.$project_id)){
alert_div_message( 'No, project roles are found. At first, you have to add roles under this project. <a href="assign_role.php?pid='.$project_id.'" >Click here</a> to add New Project Roles','danger');
        //end farmework  
print ' </div>';
include('footer.php');
exit;
      }      
print '<div class="page-header">
        <h4>Add New Task </h4>
      </div>';


	  if(isset($_POST['submit'])){
$query ="INSERT INTO `project_task` (`id`, `id_project`, `id_parenttask`, `title`, `description`, `id_person_owner`, `date_start`, `date_end`, `status_id`,`estimated_workload`) 
VALUES (NULL, '".$project_id."', '0', '".$_POST['task_name']."', '".$_POST['task_desc']."', '1', '".$_POST['task_start']."', '".$_POST['task_end']."','".$_POST['status_id']."', '".$_POST['workload']."');";
if(mysql_query($query)){
print '    <div class="alert alert-success">  New Taks has been added Successfully .   </div>'; 
}else{
print '    <div class="alert alert-error"> Error occured.</div>'; 
}



}
form_start('',$_SERVER['PHP_SELF'].'?pid='.$project_id);
	  
input_text('Task Name','task_name');
input_area('Description','task_desc');

input_date('Task Start','task_start');
input_date('Task End','task_end');
print date_dependency('task_start','task_end');
$status_query = "SELECT `id`, `title` FROM `project_status` ORDER BY `id` DESC";
input_dropdown_query('Status','status_id',$status_query,1);
input_text('Estimated Workload(H)','workload');
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