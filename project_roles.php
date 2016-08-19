<?Php

include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];
$query = "SELECT concat( cr.`firstname`,' ', cr.`lastname`) as info , prole.title,assigned_by, `assinged_time` FROM `project_person` as pr, `contact_person` as cr, `project_role` as prole WHERE prole.id=pr.id_role and cr.id=pr.id_person and pr.id_project=".$_GET['pid']."";
$fieldname=array('Name','Role','Assigned By','Time (Assigning)');

print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_task.php?pid='.$project_id.'" class="btn btn-sm btn-primary">Add New Task</a> | ';
print '<a href="assign_role.php?pid='.$project_id.'" class="btn btn-sm btn-primary">Assign Project Role</a> | ';
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
	print'<td>'.value_return("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[2]).'</td>';
	print'<td>'.customdate_format($row[3]).'</td>';
	
	
	print' </tr>';
	
	}
	
    print'</table>';


}



?>