<?php
ob_start();
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');



$query = "SELECT `id`, `title`, `description`, `status` FROM `project`";
$fieldname=array('ID','Title','Progress','Status','');

$button_menu[] = array('link'=>'my_task.php','text'=>'My Task','icon'=>'plus');
$button_menu[] = array('link'=>'employees.php','text'=>'Add New Employee');
$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'add_new_project.php','text'=>'Add New Project','icon'=>'plus');
$button_menu[] = array('link'=>'setup_parameter.php','text'=>'Setup Effort Factor','icon'=>'wrench');
button_menu_create($button_menu);


print '<div class="page-header"> <h3>Projects / Repositories  </h4>  </div>
	  
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
	//print'<td>'.$row[2].'</td>';

	print'<td>'.project_progress_bar($row[0]).'</td>';

	print'<td>'.$icon_logo.'</td>';
	
	print '  <td><a href="project_effort.php?pid='.$row[0].'" class="btn btn-sm btn-primary">Details</a></td>';
	print' </tr>';
	
	}
	
    print'</table>';


}
?>