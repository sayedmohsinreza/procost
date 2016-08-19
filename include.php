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

$dt =value_return(' SELECT DATEDIFF(date_end, date_start) AS days from project_task WHERE `id`='.$project_task_id);

$total = $ar*$pt_st*$p_st*dt;
return $total;
}

function set_input_text($title,$message){
print '<div class="control-group info">
<label >
<p><b>'.$title.' : </b>'.$message.'</p>
</label>
</div>';

}
function input_message($message,$class='text-success'){
print '<p class="'.$class.'">'.$message.'</p>';

}

function form_start($name='',$action='',$method='',$class='',$print='T'){
if($name=='')$name='form';
if($method=='')$method='post';
if($action=='')$action=$_SERVER['PHP_SELF'];
if($class=='')$class='form-horizontal';
$return_value=  '<form name="'.$name.'" action="'.$action.'" method="'.$method.'" class="'.$class.'" enctype="multipart/form-data" onsubmit="return validate_form(this)">';
if($print=='T')print $return_value; else return $return_value;

}
function form_end($print='T'){
$return_value =  '</form>';
if($print=='T')print $return_value; else return $return_value;
}

function input_text($label,$name,$value='',$class='',$size=10,$help='',$required=false,$print='T'){
if($required==false)$required='';else $required='required';
if($class=='')$class='form-control';
$label_size = 12 - $size;
$return_value =  '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$size.'">
<input class="'.$class.'" type="text" id="'.$name.'" name="'.$name.'" placeholder="'.$label.'" aria-describedby="helpBlock" value="'.$value.'" '.$required.'>
<span id="helpBlock" class="help-block">'.$help.'</span>
</div>
</div>';

if($print=='T')print $return_value; else return $return_value;

}

function input_area($label,$name,$value='',$class='',$rows='3',$size=10,$help='',$print='T'){
if($class=='')$class='form-control';
$label_size = 12 - $size;
$return_value =  '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$size.'">
<textarea rows="'.$rows.'" class ="'.$class.'" id="'.$name.'" aria-describedby="helpBlock" name="'.$name.'">'.$value.'</textarea>
<span id="helpBlock" class="help-block">'.$help.'</span>
</div>
</div>';
if($print=='T')print $return_value; else return $return_value;

}

function input_dropdown($label,$name,$arr,$class='',$value='',$size=10){
//in query you must select 2 column first for value and 2nd for show message
if($class=='')$class='form-control';
$label_size = 12 - $size;
print '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$size.'">';
print '<select name='.$name.' class="'.$class.'"> ';
reset($arr);
while (list($key, $val) = each($arr)){
if($value==$val){
print '<option value="'.$val.'" selected="selected" >'.$val.'</option>';
}else{
print '<option value="'.$val.'">'.$val.'</option>';
}
}
print'</select>';
print '</div></div>';
}
function icon($icon_class,$aria_hidden='true'){
return ' <span class="glyphicon glyphicon-'.$icon_class.'" aria-hidden="'.$aria_hidden.'"></span>';
}

function input_dropdown_query($label,$name,$query,$size,$value='',$class='',$input_size=10){
//in query you must select 2 column first for value and 2nd for show message
if($class=='')$class='form-control';
$label_size = 12 - $input_size;
print '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$input_size.'">';
print '<select class="'.$class.'" name="'.$name.'" size = "'.$size.'" >';
$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	if($value==$row[1]){
print '<option value="'.$row[0].'" selected="selected">'.$row[1].'</option>';
}else{
print '<option value="'.$row[0].'">'.$row[1].'</option>';
}
}
print '</select>';
print '</div></div>';

}
/*
*    mysql_fetch_array_nullsafe
*
*
*    get a result row as an enumerated and associated array
*    ! nullsafe !
*
*    parameter:    $result
*                    $result:    valid db result id
*
*    returns:    array | false (mysql:if there are any more rows)
*
*/
function mysql_fetch_array_nullsafe($query) {
    $ret=array();
$result = mysql_query($query);
    $num = mysql_num_fields($result);
    if ($num==0) return $ret;

    $fval = mysql_fetch_row ($result);
     if ($fval === false) return false;

    $i=0;
     while($i<$num)
        {
            $fname[$i] = mysql_field_name($result,$i);           
            $ret[$i] = $fval[$i];            // enum
            $ret[''.$fname[$i].''] = $fval[$i];    // assoc
            $i++;
        }

    return $ret;
}

function create_vertical_table($fieldname,$data_array,$id='mytable'){
   print' <table id="'.$id.'" class="table table-bordered table-hover" border="1">';
   for($i=0;$i<sizeof($fieldname);$i++){
   print'<tr>';	print'<td><b>'.$fieldname[$i].'</b></td>';	print'<td>'.$data_array[$i].'</td>';
	print'</tr>';
	
	}
    print'</table>';
}


?>