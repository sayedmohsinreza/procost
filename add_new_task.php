<?php
include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];

print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_project.php" class="btn btn-sm btn-primary">Add New Project</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';
print '<div class="page-header">
        <h1>Projects : '.value_return('SELECT `title` FROM `project` WHERE `id`='.$_GET['pid'].'').'</h1>
      </div>';
print '<div class="page-header">
        <h4>Add New Task </h4>
      </div>';
	  
	  if(isset($_POST['submit'])){
$query ="INSERT INTO `procost`.`project_task` (`id`, `id_project`, `id_parenttask`, `title`, `description`, `id_person_owner`, `date_start`, `date_end`, `estimated_workload`) 
VALUES (NULL, '".$project_id."', '0', '".$_POST['task_name']."', '".$_POST['task_desc']."', '1', '".$_POST['task_start']."', '".$_POST['task_end']."', '".$_POST['workload']."');";
if(mysql_query($query)){
print '    <div class="alert alert-success">  New Taks has been added Successfully .   </div>'; 
}else{
print '    <div class="alert alert-error"> Error occured.</div>'; 
}



}
form_start('',$_SERVER['PHP_SELF'].'?pid='.$project_id);
	  
input_text('Task Name','task_name');
input_area('Description','task_desc');

input_text('Task Start','task_start');
input_text('Task End','task_end');

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