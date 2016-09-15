<?Php

include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');



$project_id = $_GET['pid'];
$query = "SELECT `id`, `title`, status_id,`date_start`, `date_end`, `id_person_owner` FROM `project_task` WHERE `id_project`=".$_GET['pid']."";
$fieldname=array('ID','Title','Status','Start','End', 'Assigned By','Action','Estiamted Effort (In PM)','Actual Effort(In PM)');



$button_menu[] = array('link'=>'my_task.php','text'=>'My Task');
$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'add_new_task.php?pid='.$project_id,'text'=>'Add New Task');
$button_menu[] = array('link'=>'add_new_project.php','text'=>'Add New Project','icon'=>'plus');
$button_menu[] = array('link'=>'project_roles.php?pid='.$project_id,'text'=>'Project Roles');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'wrench');
button_menu_create($button_menu);





print '<div class="page-header">
        <h1>Projects : '.value_return('SELECT `title` FROM `project` WHERE `id`='.$_GET['pid'].'').'</h1>
      </div>
      <div class="row">
        <div>';
		manual_create_table($query,$fieldname,'mytable');
        print '</div>';
datatable('mytable');

//end farmework  
print ' </div>';
include('footer.php');

function manual_create_table($query,$fieldname,$id='mytable'){


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
	
	print ' <tbody>';
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	print '<tr>';
	
	
	print'<td>'.$row[0].'</td>';
	print'<td>'.$row[1].'</td>';
print'<td>'.status_label_set($row[2]).'</td>';

	print'<td>'.customdate_format($row[3]).'</td>';
	print'<td>'.customdate_format($row[4]).'</td>';
	
	print'<td><a href="person_details.php?person_id='.$row[5].'">'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,' (',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[5])[0].'</a></td>';
	print'<td><a href="see_history.php?task_id='.$row[0].'" class="btn btn-sm btn-default">'.icon('info-sign').' Details</a></td>';
	print '  <td>'.effort_calculation($row[0]).'</td>';
		print '  <td>'.effort_calculation($row[0],'actual').'</td>';
	print' </tr>';
	
	}
	
    print'</tbody></table>';


}



?>