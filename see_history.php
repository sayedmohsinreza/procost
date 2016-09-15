<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$task_id=$_GET['task_id'];
print '<div class="page-header"><h2>'.mysql_fetch_array_nullsafe("SELECT `title` FROM `project_task` WHERE `id`=".$task_id)[0].' </h2>  </div>';

//menu
$button_menu[] = array('link'=>'my_task.php','text'=>'My Task');
$button_menu[] = array('link'=>'edit_task.php?task_id='.$task_id,'text'=>'Edit Task');
$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'project_effort.php?pid='.value_return("SELECT `id_project` FROM `project_task` WHERE `id`=".$task_id).'','text'=>'Project Details');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'wrench');
button_menu_create($button_menu);
//menu





//start 1st vertical table 
$field=array('Title','Desc','Created By','Date Start','Date End','Status','Workload');
$query = "SELECT `title`, `description`, `id_person_owner`, `date_start`, `date_end`, status_id,`estimated_workload` FROM `project_task` WHERE `id`='".$_GET['task_id']."' ";
$data= mysql_fetch_array_nullsafe($query);
create_vertical_manual_table($field,$data);
//end 1st vertical table 





$button_menu2[] = array('link'=>'add_history.php?task_id='.$task_id.'','text'=>'Add New History','icon'=>'plus');

button_menu_create($button_menu2);


$query = "SELECT id,`person_id`, `activity_id`, `status_id`, `start_on`, `end_on`, `assigned_by` FROM `task_history` WHERE `task_id`=".$_GET['task_id']."";
$fieldname=array('Person','Activity','Status','Start Date', 'Start End', 'Assigned By','Estiamted Effort', 'Actual Effort','');					
create_table_person($query,$fieldname);
datatable('mytable');



//end framework
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

		print '<tr>';
		print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[1])[0].'</td>';
		print'<td>'.mysql_fetch_array_nullsafe("SELECT `title` FROM `project_activity` WHERE `id`=".$row[2])[0].'</td>';
		print'<td>'.status_label_set($row[3]).'</td>';
		print'<td>'.customdate_format($row[4]).'</td>';
		print'<td>'.customdate_format($row[5]).'</td>';
		print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[6])[0].'</td>';
		print '<td>'.effort_calculation_history( $row[0]).' </td>';
		print '<td>'.effort_calculation_history( $row[0],'actual').' </td>';

print '<td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="edit_history.php?history_id='.$row[0].'" >'.icon('edit').' Edit</a></li>
    <li><a data-toggle="modal" data-target="#view_modal_'.$row['id'].'">'.icon('book').' View</a></li>
    <li role="separator" class="divider"></li>
    <li><a data-toggle="modal" data-target="#delete_modal_'.$row['id'].'">'.icon('trash').' Delete</a></li>
  </ul>
</div></td>';

		print' </tr>';
		}

		print'</tbody></table>';
}
	
function create_vertical_manual_table($fieldname,$data_array,$id='mytable3'){
		print' <table id="'.$id.'" class="table table-bordered table-hover" border="1">';
		print'<tr>';	print'<td><b>'.$fieldname[0].'</b></td>';	print'<td>'.$data_array[0].'</td>';	print'</tr>';
		print'<tr>';	print'<td><b>'.$fieldname[1].'</b></td>';	print'<td>'.$data_array[1].'</td>';	print'</tr>';
		print'<tr>';	print'<td><b>'.$fieldname[2].'</b></td>';	print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$data_array[2])[0].'</td>';	print'</tr>'; 
		print'<tr>';	print'<td><b>'.$fieldname[3].'</b></td>';	print'<td>'.customdate_format($data_array[3]).'</td>';	print'</tr>';
		print'<tr>';	print'<td><b>'.$fieldname[4].'</b></td>';	print'<td>'.customdate_format($data_array[4]).'</td>';	print'</tr>';
		print'<tr>';	print'<td><b>'.$fieldname[5].'</b></td>';	print'<td>'.status_label_set($data_array[5]).'</td>';	print'</tr>';
		print'<tr>';	print'<td><b>'.$fieldname[6].'</b></td>';	print'<td>'.$data_array[6].'</td>';	print'</tr>';
		print'</table>';
}
?>







