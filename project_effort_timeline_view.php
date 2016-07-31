<?Php

include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

$project_id = $_GET['pid'];
$query = "SELECT `id`, `title`, `date_start`, `date_end` FROM `project_task` WHERE `id_project`=".$_GET['pid']."";
$fieldname=array('ID','Title','Start','End','Effort');

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
	
	print '  <td>'.effort_calculation($row[0]).'</td>';
	print' </tr>';
	
	}
	
    print'</table>';


}


function effort_calculation($project_task_id){
$project_id = value_return('SELECT `id_project` FROM `project_task` WHERE `id`='.$project_task_id);
$ar = value_return('SELECT pr.value FROM `project_activity` as pr, `project_task` as pt WHERE pr.id=pt.`id_activity` and pt.id='.$project_task_id);
//project task status
$pt_st = value_return('SELECT st.value FROM `project_status` as st, `project_task` as pt WHERE st.id=pt.`status` and pt.id='.$project_task_id);
//project_status
$p_st = value_return('SELECT st.value FROM `project_status` as st, `project` as pt WHERE st.id=pt.`status` and pt.id='.$project_id);


$total = $ar*$pt_st*$p_st;
return $total;
}
?>