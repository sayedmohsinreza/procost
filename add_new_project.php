<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_project.php" class="btn btn-sm btn-primary">Add New Project</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';
print '<div class="page-header">
        <h1>Add New Project </h1>
      </div>';
	  
	  if(isset($_POST['submit'])){
$query ="INSERT INTO `project` (`id`, `id_person_create`, `date_start`, `date_end`, `title`, `description`, `status`) 
VALUES (NULL, ".$_SESSION['id'].", '".$_POST['pr_start']."', '".$_POST['pr_end']."', '".$_POST['pr_name']."', '".$_POST['pr_desc']."', '".$_POST['pr_status']."');";
if(mysql_query($query)){
print '    <div class="alert alert-success">  New Project has been added Successfully .   </div>'; 
}else{
print '    <div class="alert alert-error"> Error occured.</div>'; 
}



}
form_start();	  
	  
input_text('Project Name','pr_name');
input_area('Description','pr_desc');

input_date('Project Start','pr_start');
input_date('Project End','pr_end');
input_dropdown('Project Status','pr_status',array(1=>'On',0=>'Off'));

        
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