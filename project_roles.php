<?Php

include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];
$query = "SELECT concat( cr.`firstname`,' ', cr.`lastname`) as info , prole.title,assigned_by, `assinged_time` FROM `project_person` as pr, `contact_person` as cr, `project_role` as prole WHERE prole.id=pr.id_role and cr.id=pr.id_person and pr.id_project=".$_GET['pid']."";
$fieldname=array('Name','Role','Assigned By','Time (Assigning)');


$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'add_new_task.php?pid='.$project_id.'','text'=>'Add New Task','icon'=>'plus');
$button_menu[] = array('link'=>'assign_role.php?pid='.$project_id.'','text'=>'Assign Project Role');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard');
button_menu_create($button_menu);

print page_header('Projects : '.value_return('SELECT `title` FROM `project` WHERE `id`='.$_GET['pid'].'').'');
      print '<div class="row">
        <div>';
		manual_create_table($query,$fieldname,'mytable');
		datatable();
        print '</div>';


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
	
	print '<tbody>';
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	print ' <tr>';
	
	
	print'<td>'.$row[0].'</td>';
	print'<td>'.$row[1].'</td>';
	print'<td>'.value_return("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[2]).'</td>';
	print'<td>'.customdate_format($row[3]).'</td>';
	
	
	print' </tr>';
	
	}
	print '</tbody>';
    print'</table>';


}



?>