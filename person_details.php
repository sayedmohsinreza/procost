<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$person_id=$_GET['person_id'];
print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';

print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';

$field=array('Name','email','password','Admin','Active');
$query = "SELECT concat(`firstname`,' ', `lastname`) as name, `email`,`password`, `is_admin`,`is_active`, `id_person_create`FROM `contact_person` WHERE id = '".$_GET['person_id']."' ";
$data= mysql_fetch_array_nullsafe($query);
create_vertical_manual_table($field,$data);
// $result = mysql_query($query);
	// while($row= mysql_fetch_array($result)){
// set_input_text("Name",$row['name']);
// set_input_text("email",$row['email']);
// set_input_text("password",$row['password']);

// set_input_text("Admin",$row['is_admin']);
// set_input_text("Active Status",$row['is_active']);
// set_input_text("Created By",value_return("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row['id_person_create']));


// }
print'<br>
      <br>';


print '<div class="page-header"><h4>Project Roles </h4>  </div>';
$query = "SELECT project.title , prole.title,assigned_by, `assinged_time` FROM `project_person` as pr, `project`, `project_role` as prole WHERE prole.id=pr.id_role and project.id=pr.`id_project` and pr.`id_person`=".$_GET['person_id']."";
$fieldname=array('Project','Role','Assigned By','Time (Assigning)');

//$result = mysql_query($query);
	//while($row= mysql_fetch_array($result)){
//set_input_text2("Paper Id:",$row['pid']);
//set_input_text2("Paper Name:",$row['title']);
            			// }
						
create_table_person($query,$fieldname);
datatable('mytable');
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

	print'<td>'.$row[0].'</td>';
	print'<td>'.$row[1].'</td>';
	print'<td>'.value_return("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$row[2]).'</td>';
	print'<td>'.customdate_format($row[3]).'</td>';
	
	
	print' </tr>';
	}
		print '</tbody>';
    print'</table>';
    }
	
	function create_vertical_manual_table($fieldname,$data_array,$id='mytable'){
   print' <table id="'.$id.'" class="table table-bordered table-hover" border="1">';
   for($i=0;$i<sizeof($fieldname);$i++){
   print'<tr>';	print'<td><b>'.$fieldname[$i].'</b></td>';	print'<td>'.$data_array[$i].'</td>';	print'</tr>';
	
	}
	print'<tr>';	print'<td><b>Created By</b></td>';	print'<td>'.mysql_fetch_array_nullsafe("SELECT concat( cr.`firstname`,' ', cr.`lastname`,'( ',`email`,')') as info  FROM `contact_person` as cr WHERE `id`=".$data_array[5])[0].'</td>';	print'</tr>';
    print'</table>';
}
?>







