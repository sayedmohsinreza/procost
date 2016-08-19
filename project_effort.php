<?Php

include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];
$query = "SELECT `id`, `title`, `date_start`, `date_end`, `id_person_owner` FROM `project_task` WHERE `id_project`=".$_GET['pid']."";
$fieldname=array('ID','Title','Start','End', 'Assigned By');

print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_task.php?pid='.$project_id.'" class="btn btn-sm btn-primary">Add New Task</a> | ';
print '<a href="project_roles.php?pid='.$project_id.'" class="btn btn-sm btn-primary">See Project Roles</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';

print '<div class="page-header">
        <h1>Projects : '.value_return('SELECT `title` FROM `project` WHERE `id`='.$_GET['pid'].'').'</h1>
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
	
	
	print'<td>'.$row[0].'</td>';
	print'<td>'.$row[1].'</td>';
	print'<td>'.customdate_format($row[2]).'</td>';
	print'<td>'.customdate_format($row[3]).'</td>';
	
	print'<td><a href="person_details.php?person_id='.$row[4].'">'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,' (',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[4])[0].'</a></td>';
	print'<td><a href="see_history.php?task_id='.$row[0].'">History</a></td>';
	//print '  <td>'.effort_calculation($row[0]).'</td>';
	print' </tr>';
	
	}
	
    print'</table>';


}



?>