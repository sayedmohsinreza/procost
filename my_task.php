<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

print '<div class="page-header"><h2>My Task </h2>  </div>';


$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'home','class'=>'primary');

button_menu_create($button_menu);

$query = "SELECT id,`task_id`, `activity_id`, `status_id`, `start_on`, `end_on`, `assigned_by` FROM `task_history` WHERE `person_id`=".$_SESSION['id']."";
$fieldname=array('Task','Activity','Status','Start Date', 'Start End', 'Assigned By','Estimated Effort','Actual Effort');

						
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
	print'<td>'.mysql_fetch_array_nullsafe("SELECT title  FROM `project_task` WHERE `id`=".$row[1])[0].'</td>';
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
	

?>