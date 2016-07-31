<?php
function create_table($query,$fieldname,$id='mytable'){


   print' <table id="'.$id.'" class="table table-striped">';
   
   print'<tr>';
	for($i=0;$i<sizeof($fieldname);$i++){
	print'<th>'.$fieldname[$i].'</th>';
	}
	print'</tr>';
	
	
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	print ' <tr>';
	
	for($i=0;$i<sizeof($row)/2;$i++){
	print'<td>'.$row[$i].'</td>';
	}
	
	print' </tr>';
	
	}
	
    print'</table>';


}

//
	function value_return($query){
	
	$result= mysql_query($query);
	$value=mysql_result($result,0);
	return $value;
	
	}
	
	function customdate_format($timestampDate,$default_format='l, d M Y'){
//$originalDate = "2010-03-21";
//d-m-Y  ---- 08-1-2016
//l, d M Y ---- Friday, 08 Jan 2016
$newDate = date($default_format, strtotime($timestampDate));
return $newDate;
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