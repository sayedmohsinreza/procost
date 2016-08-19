<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$task_id=$_GET['task_id'];
print '<div class="page-header"><h2>'.mysql_fetch_array_nullsafe("SELECT `title` FROM `project_task` WHERE `id`=".$task_id)[0].' </h2>  </div>';
print '<div class="pull-right">';
print '<a href="edit_task.php?task_id='.$task_id.'" class="btn btn-sm btn-primary">Edit</a> | ';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="project_effort.php?pid='.value_return("SELECT `id_project` FROM `project_task` WHERE `id`=".$task_id).'" class="btn btn-sm btn-primary">Project Details</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';

$field=array('Title','Desc','Created By','Date Start','Date End','Status','Workload');
$query = "SELECT `title`, `description`, `id_person_owner`, `date_start`, `date_end`, status_id,`estimated_workload` FROM `project_task` WHERE `id`='".$_GET['task_id']."' ";
$data= mysql_fetch_array_nullsafe($query);
create_vertical_manual_table($field,$data);




print '<div class="page-header"><h4>Task History </h4>  </div>';
print '<div class="pull-right">';
print '<a href="add_history.php?task_id='.$task_id.'" class="btn btn-sm btn-primary">Add New History</a>';
print'</div>';
$query = "SELECT id,`person_id`, `activity_id`, `status_id`, `start_on`, `end_on`, `assigned_by` FROM `task_history` WHERE `task_id`=".$_GET['task_id']."";
$fieldname=array('Person','Activity','Status','Start Date', 'Start End', 'Assigned By','Estiamted Effort', 'Actual Effort');


						
create_table_person($query,$fieldname);
datatable();
print '</div>';
include('footer.php');
   
    function create_table_person($query,$fieldname,$id='mytable'){
    print' <table id="'.$id.'" class="table table-striped">';
   
    print'<thead><tr>';
	for($i=0;$i<sizeof($fieldname);$i++){
	print'<th>'.$fieldname[$i].'</th>';
	}
	print'</tr></thead>';

	    print'<tfoot><tr>';
	for($i=0;$i<sizeof($fieldname);$i++){
	print'<th>'.$fieldname[$i].'</th>';
	}
	print'</tr></tfoot>';
	
	print '<tbody>';
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	print ' <tr>';
	print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[1])[0].'</td>';
	print'<td>'.mysql_fetch_array_nullsafe("SELECT `title` FROM `project_activity` WHERE `id`=".$row[2])[0].'</td>';
	print'<td>'.status_label_set($row[3]).'</td>';
	print'<td>'.customdate_format($row[4]).'</td>';
	print'<td>'.customdate_format($row[5]).'</td>';
	print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[6])[0].'</td>';
	print '<td>'.effort_calculation_history( $row[0]).' </td>';
	print '<td>'.effort_calculation_history( $row[0],'actual').' </td>';
	
	
	print' </tr>';
	}
	
    print'</tbody></table>';
    }
	
	function create_vertical_manual_table($fieldname,$data_array,$id='mytable3'){
   print' <table id="'.$id.'" class="table table-bordered table-hover" border="1">';
   //for($i=0;$i<sizeof($fieldname);$i++){
   print'<tr>';	print'<td><b>'.$fieldname[0].'</b></td>';	print'<td>'.$data_array[0].'</td>';	print'</tr>';
   print'<tr>';	print'<td><b>'.$fieldname[1].'</b></td>';	print'<td>'.$data_array[1].'</td>';	print'</tr>';
	print'<tr>';	print'<td><b>'.$fieldname[2].'</b></td>';	print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$data_array[2])[0].'</td>';	print'</tr>'; 
	print'<tr>';	print'<td><b>'.$fieldname[3].'</b></td>';	print'<td>'.customdate_format($data_array[3]).'</td>';	print'</tr>';

   print'<tr>';	print'<td><b>'.$fieldname[4].'</b></td>';	print'<td>'.customdate_format($data_array[4]).'</td>';	print'</tr>';
      print'<tr>';	print'<td><b>'.$fieldname[5].'</b></td>';	print'<td>'.status_label_set($data_array[5]).'</td>';	print'</tr>';
   
   print'<tr>';	print'<td><b>'.$fieldname[6].'</b></td>';	print'<td>'.$data_array[6].'</td>';	print'</tr>';
	
	//}
	
    print'</table>';
}
?>







