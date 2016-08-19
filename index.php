<?php
include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');


$query = "SELECT `id`, `title`, `description`, `status` FROM `project`";
$fieldname=array('ID','Title','Desc','Status','');
print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_project.php" class="btn btn-sm btn-primary">Add New Project</a> | ';
print '<a href="setup_parameter.php" class="btn btn-sm btn-primary">Setup Effort Factor</a>';
print'</div>';
print '<div class="page-header">
        <h1>Projects </h1>
      </div>
	  
      <div class="row">
        
		<div>';
		
		manual_create_table($query,$fieldname,'mytable');
        print '</div>';
        
  

  
//end farmework  
print ' </div>';
include('footer.php');

function manual_create_table($query,$fieldname,$id='mytable'){


   print' <table id="'.$id.'" class="table table-striped">';
   
   print'<tr>';
	for($i=0;$i<sizeof($fieldname);$i++){
	print'<th>'.$fieldname[$i].'</th>';
	}
	print'</tr>';
	
	
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	print ' <tr>';
	if($row[3]==0){
	$icon_logo = icon('remove-sign');
	}else{
	$icon_logo = icon('ok-sign');
	}
	
	print'<td>'.$row[0].'</td>';
	print'<td>'.$row[1].'</td>';
	print'<td>'.$row[2].'</td>';
	print'<td>'.$icon_logo.'</td>';
	
	print '  <td><a href="project_effort.php?pid='.$row[0].'" class="btn btn-sm btn-primary">Details</a></td>';
	print' </tr>';
	
	}
	
    print'</table>';


}
?>