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
        <h1>Add New Task </h1>
      </div>';
	  
	  if(isset($_POST['submit'])){
$query ="INSERT INTO `project` (`id`, `id_person_create`, `date_start`, `date_end`, `title`, `description`, `status`) 
VALUES (NULL, '0', '".$_POST['pr_start']."', '".$_POST['pr_end']."', '".$_POST['pr_name']."', '".$_POST['pr_desc']."', '".$_POST['pr_status']."');";
if(mysql_query($query)){
print '    <div class="alert alert-success">  New Project has been added Successfully .   </div>'; 
}else{
print '    <div class="alert alert-error"> Error occured.</div>'; 
}



}
form_start();	  
	  
input_text('Task Name','task_name');
input_area('Description','task_desc');

input_text('Task Start','task_start');
input_text('Task End','task_end');
input_dropdown('Task Status','task_status',array('On','Off'));
$person_query = "SELECT cr.`id`, concat(`firstname`,' ', `lastname`,' (',`email`,') - [ ',prole.title,' ]') as info FROM `project_person` as pr,`contact_person` as cr, `project_role` as prole WHERE pr.`id_person`=cr.`id` and prole.id=pr.id_role and     pr.`id_project`=".$project_id;
input_dropdown_query('Assigned To','task_person',$person_query,5);
        
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