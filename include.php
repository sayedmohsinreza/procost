<?php

const THESIS_INFO  = '<b>Thesis Title: </b><i>Activity based new technique of Effort &amp; Cost 
Estimation using Functional Measurement Type for web application.</i></font></u><br>Supervisor:&nbsp;<a href="http://www.juniv.edu/iit/teachers/" target="_blank" rel="nofollow">Dr. M. Shamim Kaiser</a>, Associate Professor, Institute of Information Technology, Jahangirnagar University.<br>Co-Supervisor:&nbsp;<a href="http://www.juniv.edu/iit/teachers/" target="_blank" rel="nofollow">Shamim al Mamun</a>, Assistant Professor, Institute of Information Technology, Jahangirnagar University.<br>Funding: <a href="http://fellowship.most.gov.bd/" target="_blank" rel="nofollow">National Science &amp; Technology (NST) Fellowship</a> provided by <span><a href="http://www.most.gov.bd/" target="_blank" title="Home" rel="nofollow">Ministry of Science and Technology Government of the People\'s Republic of Bangladesh</a></span>. <br>Research Area: Software Engineering, Software Effort &amp; Cost Model etc&nbsp;<br>
                        Importance of such Thesis: <a href="https://en.wikipedia.org/wiki/Software_development_effort_estimation" target="_blank" rel="nofollow">Wikipedia</a> | <a href="http://www.gursimransinghwalia.com/Research-Projects.html" target="_blank" rel="nofollow">Professors Research</a> | <a href="http://yunus.hun.edu.tr/~sencer/research.html" target="_blank" rel="nofollow">MS Student research</a> | <a href="http://www.sei.cmu.edu/productlines/frame_report/funding.htm" target="_blank" rel="nofollow">University Funding</a> | <a href="https://nsf.gov/funding/funding_results.jsp?queryText=Software+Engineering" target="_blank" rel="nofollow">USA NSF Funding</a> |<br>';

const BASIC_INFO = 'PROCOST is an enterprise software company that develops products for software developers, project managers, and content management. It is best known for its issue tracking application and its team collaboration and Confluence.';

const HISTORY_INFO = 'Sayed Mohsin Reza founded PROCOST in 2015. The person while studying at the Jahangirnagar University in Dhak. He bootstrapped the project, financing by <a href="http://fellowship.most.gov.bd/" target="_blank" rel="nofollow">National Science &amp; Technology (NST) Fellowship</a> provided by <span><a href="http://www.most.gov.bd/" target="_blank" title="Home" rel="nofollow">Ministry of Science and Technology Government of the People\'s Republic of Bangladesh</a></span> in 2015.';


function lau ($arr){
print('<pre>');
print_r($arr);
die;

}

function check_session(){
// Inialize session
session_start();
// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
if (!isset($_SESSION['password'])) {
//session_destroy();
header('Location: login.php');
exit;
}
}
}



function create_table($query,$fieldname,$id='mytable'){


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
	
	print'<tbody>';
	
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	print ' <tr>';
	
	for($i=0;$i<sizeof($row)/2;$i++){
	print'<td>'.$row[$i].'</td>';
	}
	
	print' </tr>';
	
	}
	
    print'</tbody></table>';


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

function effort_calculation($project_task_id,$effort_type='estimate'){
$history_ids = multiple_value_1column("SELECT`id` FROM `task_history` WHERE `task_id`=".$project_task_id);

//lau($history_ids);
if(is_array($history_ids)){
reset($history_ids);
$i=0;
while ($i<count($history_ids))
  {
  $total += effort_calculation_history($history_ids[$i],$effort_type);
  $i++;
  }
}else{
$total+=1;

}
return $total;
}

function effort_calculation_history($project_history_id,$effort_type='estimate'){
$history_data =mysql_fetch_array_nullsafe("SELECT `id`, `project_id`, `person_id`, `task_id`, `activity_id`, `status_id`, `start_on`, `end_on`, `assigned_by`,closed,closed_at FROM `task_history` WHERE id= ".$project_history_id);


//JP Value
$job_position_value= mysql_fetch_array_nullsafe("SELECT value FROM `contact_jobtype` WHERE `id`=(SELECT `id_jobtype` FROM `contact_person` WHERE `id`=".$history_data['person_id'].")")[0];

// PBR Role value
$id_roles = mysql_fetch_array_nullsafe("SELECT `id_role` FROM `project_person` WHERE `id_project`=".$history_data['project_id']." and `id_person`=".$history_data['person_id']."");
if(is_array($id_roles)){
$id_roles = implode(',',$id_roles);
$assign_role_value  = mysql_fetch_array_nullsafe("SELECT sum(value) FROM `project_role` WHERE `id` IN (".$id_roles.") " )[0];
}else{
  $assign_role_value = 1;
}
//Activity Value
$project_activity_value= mysql_fetch_array_nullsafe("SELECT `value` FROM `project_activity` WHERE `id`=".$history_data['activity_id'])[0];
//status Value
$project_status_value= mysql_fetch_array_nullsafe("SELECT `value` FROM `project_status` WHERE `id`=".$history_data['status_id'])[0];

if($effort_type=='estimate'){

//Date Diff Value
if(date('Y-m-d H:i:s')>$history_data['start_on'] and date('Y-m-d H:i:s')<$history_data['end_on']){
$date_diff_value = mysql_fetch_array_nullsafe(" SELECT DATEDIFF(end_on, start_on) AS days from task_history WHERE `id`=".$project_history_id)[0];

}else{
  $date_diff_value = 1;
}
}

if($effort_type=='actual'){
 
//Date Diff Value
if(date('Y-m-d H:i:s')>$history_data['start_on'] ){
  if($history_data['closed']==0){
$date_diff_value = mysql_fetch_array_nullsafe(" SELECT DATEDIFF(NOW(), start_on) AS days from task_history WHERE `id`=".$project_history_id)[0];
}else{
$date_diff_value = mysql_fetch_array_nullsafe(" SELECT DATEDIFF(closed_at, start_on) AS days from task_history WHERE `id`=".$project_history_id)[0];

}

}else{
  $date_diff_value = 1;
}
}

$total_sum = 
$job_position_value +
$assign_role_value +
$project_activity_value +
$project_status_value +
$date_diff_value;
$total = $job_position_value. "+".$assign_role_value. "+".$project_activity_value. "+".$project_status_value. "+".$date_diff_value. "=".$total_sum;
//return $total;
return $total_sum;

return 0;
}
function icon($icon_class,$aria_hidden='true'){
return ' <span class="glyphicon glyphicon-'.$icon_class.'" aria-hidden="'.$aria_hidden.'"></span>';
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

function input_dropdown($label,$name,$arr,$class='',$value='',$size=10,$print='T'){
//in query you must select 2 column first for value and 2nd for show message
$str='';
if($class=='')$class='form-control';
$label_size = 12 - $size;
$str.=  '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$size.'">';
$str.=   '<select name='.$name.' class="'.$class.'"> ';
reset($arr);
while (list($key, $val) = each($arr)){
if($value==$val){
$str.=   '<option value="'.$key.'" selected="selected" >'.$val.'</option>';
}else{
$str.=   '<option value="'.$key.'">'.$val.'</option>';
}
}
$str.=  '</select>';
$str.=   '</div></div>';
if($print=='T')print $str; else return $str;
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
     
    if(mysql_num_rows($result)==0)
    return 1;

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


function input_date($label,$name,$value='',$class='',$size=10,$help='',$required=false,$print='T'){
if($required==false)$required='';else $required='required';
if($class=='')$class='form-control';
$label_size = 12 - $size;
$return_value =  '<div class="form-group">
    <label for="'.$name.'" class="col-sm-'.$label_size.' control-label">'.$label.'</label>
    <div class="col-sm-'.$size.'">
<div class="input-group" data-provide="datepicker">
<input class="'.$class.'" type="text" id="'.$name.'" name="'.$name.'" placeholder="'.$label.'" aria-describedby="helpBlock" value="'.$value.'" '.$required.' readonly>
<span id="datepicker'.$name.'" class="input-group-btn" >
        <button class="btn btn-default" type="button">'.icon('calendar').'</button>
      </span>
</div>
<span id="helpBlock" class="help-block">'.$help.'</span>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {

$("#'.$name.'").datepicker({
	format: \'yyyy-mm-dd\'
});
});
</script >
<style>
  .datepicker{z-index:1151 !important;}
</style>
';

if($print=='T')print $return_value; else return $return_value;

}

function date_dependency($date_1,$date_2){

return '
<script type="text/javascript">
$(document).ready(function() {
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $(\'#'.$date_1.'\').datepicker({
  onRender: function(date) {
    return date.valueOf() < now.valueOf() ? \'disabled\' : \'\';
  }
}).on(\'changeDate\', function(ev) {
  if (ev.date.valueOf() > checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() + 1);
    checkout.setValue(newDate);
  }
  checkin.hide();
  $(\'#'.$date_2.'\')[0].focus();
}).data(\'datepicker\');
var checkout = $(\'#'.$date_2.'\').datepicker({
  onRender: function(date) {
    return date.valueOf() <= checkin.date.valueOf() ? \'disabled\' : \'\';
  }
}).on(\'changeDate\', function(ev) {
  checkout.hide();
}).data(\'datepicker\');
});
</script >
';

}


function datatable($tableid='',$order_cloumn_no=0,$order_type='asc'){
if($tableid=='')$tableid='mytable';
print '<script type="text/javascript"> 
$(document).ready(function() {
$(\'#'.$tableid.'\').DataTable({
   "dom": \'<"col-sm-6"l><"col-sm-6"f><t><"col-sm-5"i><"col-sm-7"p>\',
"lengthMenu": [[10, 25, 50,100 ,-1], [10, 25, 50,100, "All"]],
"order": [[ '.$order_cloumn_no.', "'.$order_type.'" ]],
buttons: [
        \'copy\', \'excel\', \'pdf\'
    ]
});

    $("div.toolbar").html(\'<b>Custom tool bar! Text/images etc.</b>\');
});
</script>';
}

/*
<div class="alert alert-success" role="alert">...</div>
<div class="alert alert-info" role="alert">...</div>
<div class="alert alert-warning" role="alert">...</div>
<div class="alert alert-danger" role="alert">...</div>
*/
function alert_div_message($message,$class='info',$print='T'){
$return_value ='<div class="alert alert-'.$class.'" role="alert">'.$message.'</div>';
if($print=='T')print $return_value; else return $return_value;

}

function mysql_insert_array ($my_table, $my_array) { 
    $keys = array_keys($my_array); 
    $values = array_values($my_array); 
    $sql = 'INSERT INTO ' . $my_table . '(' . implode(',', $keys) . ') VALUES ("' . implode('","', $values) . '")'; 
    return(mysql_query($sql)); 
}

//1 column several row
function multiple_value_1column($query){
  $value=array();
  $result= mysql_query($query);
  while($row = mysql_fetch_array($result))
  {

  array_push($value,$row[0]);
  }
  //$value=mysql_result($result,0);
  return $value;
  
  }

  //1 row several column return
function multiple_value_1row($query){
  $value=array();
  $result= mysql_query($query);
  while($row = mysql_fetch_array($result))
  {
  $i=0;
  for($i=0;$i<mysql_num_fields($result);$i++)
  array_push($value,$row[$i]);
  
  }
  //$value=mysql_result($result,0);
  return $value;
}

function status_label_set($id){
$value = value_return("SELECT `title` FROM `project_status` WHERE `id`=".$id);
if($id==1)      return '<span class="label label-success">'.$value.'</span>';
else if($id==2) return '<span class="label label-info">'.$value.'</span>';
else if($id==3) return '<span class="label label-primary">'.$value.'</span>';
else if($id==4) return '<span class="label label-warning">'.$value.'</span>';
else            return '<span class="label label-default">'.$value.'</span>';

}


function project_progress_bar($id_project){
$total = value_return("SELECT count(*) FROM `project_task` WHERE `id_project`=".$id_project);
if($total==0)$total=1;
$success_count  = value_return("SELECT count(*) FROM `project_task` WHERE status_id =1 and `id_project`=".$id_project);
$info_count  = value_return("SELECT count(*) FROM `project_task` WHERE status_id =2 and `id_project`=".$id_project);
$primary_count  = value_return("SELECT count(*) FROM `project_task` WHERE status_id =3 and `id_project`=".$id_project);
$warning_count  = value_return("SELECT count(*) FROM `project_task` WHERE status_id =4 and `id_project`=".$id_project);

return '<div class="progress">
  <div class="progress-bar progress-bar-warning progress-bar-striped" data-toggle="tooltip" data-placement="top" title="'.value_return("SELECT `title` FROM `project_status` WHERE `id`=4").' - '.$warning_count.'/'.$total.'" style="width: '.($warning_count/$total*100).'%">
    <span class="sr-only">10% Complete (danger)</span>
  </div>
  <div class="progress-bar progress-bar-primary progress-bar-striped" data-toggle="tooltip" data-placement="top" title="'.value_return("SELECT `title` FROM `project_status` WHERE `id`=3").' - '.$primary_count.'/'.$total.'" style="width: '.($primary_count/$total*100).'%">
    <span class="sr-only">20% Complete (warning)</span>
  </div>
  <div class="progress-bar progress-bar-info progress-bar-striped" data-toggle="tooltip" data-placement="top" title="'.value_return("SELECT `title` FROM `project_status` WHERE `id`=2").' - '.$info_count.'/'.$total.'" style="width: '.($info_count/$total*100).'%">
    <span class="sr-only">35% Complete (success)</span>
  </div>  
  <div class="progress-bar progress-bar-success progress-bar-striped" data-toggle="tooltip" data-placement="top" title="'.value_return("SELECT `title` FROM `project_status` WHERE `id`=1").' - '.$success_count.'/'.$total.'" style="width: '.($success_count/$total*100).'%">
    <span class="sr-only">35% Complete (success)</span>
  </div>
</div>
<script>   
$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
});
</script>
';

}


/*
SelectTableRecords("SELECT * FROM Persons"); //for condition put WHERE clause after table name
*/

function SelectTableRecords($query, $result_mode = MYSQL_BOTH){   
$result = mysql_query ($query);
$count = 0;
   $data = array();
   while ( $row = mysql_fetch_array($result,$result_mode)){
       $data[$count] = $row;
  $count++;
   }
   return $data;  
}

/*
$field['FirstName'] = 'Glenn';
$field['LastName'] = 'Quagmire';
$field['Age'] = '33';

InsertInTable("Persons",$field);
*/
function InsertInTable($table,&$fields,$success_message ="A Record has been updated successfully .",$error_message = "Error occured.") {
    $col = "insert into $table (`".implode("` , `",array_keys($fields))."`)";
    $val = " values('";   
    foreach($fields as $key => $value) { 
        $fields[$key] = mysql_escape_string($value);
    }
    $val .= implode("' , '",array_values($fields))."');";   
    $fields = array();
if(mysql_query($col.$val)){
print '    <div class="alert alert-success"> '. $success_message.'   </div>'; 
}else{
print '    <div class="alert alert-danger"> '. $error_message.' Error description: ' . mysql_error().'.</div>'; 
}
}
/*
$field['Age'] = '36';
UpdateTable("Persons",$field," FirstName= 'Glenn'");
*/
function UpdateTable($table,&$fields,$condition,$success_message ="A Record has been updated successfully .",$error_message = "Error occured.") {
    
    $sql = "update $table set ";
    foreach($fields as $key => $value) { 
        $fields[$key] = " `$key` = '".mysql_escape_string($value)."' ";
    }
    $sql .= implode(" , ",array_values($fields))." where ".$condition.";";  
    $fields = array();
if(mysql_query($sql)){
print '    <div class="alert alert-success"> '. $success_message.'   </div>'; 
}else{
print '    <div class="alert alert-danger"> '. $error_message.' Error description: ' . mysql_error().'.</div>'; 
}
}

/*
DeleteRecord("DELETE FROM Persons WHERE LastName = 'Griffin'");
*/
function DeleteRecord($query,$success_message ="A Record has been deleted successfully .",$error_message = "Error occured.") {
    $result = mysql_query ($query);
    if(mysql_query($sql)){
print '    <div class="alert alert-success"> '. $success_message.'   </div>'; 
}else{
print '    <div class="alert alert-danger"> '. $error_message.' Error description: ' . mysql_error().'.</div>'; 
} 
}
//$buttons[] = array('link'=>'index.php','text'=>'Go to Dashboard','icon'=>'plus','class'=>'primary');
//$buttons[] = array('link'=>'my_task.php','text'=>'Go to Dashboard','icon'=>'plus','class'=>'primary');
function button_menu_create($buttons,$style='1' ){
$rand_class = array ('primary','success','warning','danger');
$rand_icon = array ('plus','edit','asterisk','wrench','home');
print '<div class="pull-right">';
 foreach($buttons as $key => $value) { 
  if(!isset($value['class'])){$class =$rand_class[rand(0,count($rand_class)-1)]; }else{$class = $value['class'];}
  if(!isset($value['icon'])){$icon =$rand_icon[rand(0,count($rand_icon)-1)]; }else{$icon = $value['icon'];}
print '<a href="'.$value['link'].'" class="btn btn-sm btn-'.$class.'"><span class="glyphicon glyphicon-'.$icon.'" aria-hidden="true"></span> '.$value['text'].'</a> | ';
      }
print'</div>';




}



function create_modal($id, $header,$body,$action_type='save',$form_start_line=''){
if($form_start_line=='')$form_start_line =form_start('form','','POST','','F');

if($action_type == 'save') $button_code = '<button type="submit" name="save_button" id="save_button" class="btn btn-primary">'.icon('floopy-disk').' Save</button>';
if($action_type == 'update') $button_code = '<button type="submit" name="update_button" id="update_button" class="btn btn-primary">'.icon('floopy-open').' Update</button>';
if($action_type == 'view') $button_code = '';
if($action_type == 'delete') $button_code = '<button type="submit" name="delete_button" id="delete_button" class="btn btn-danger">'.icon('floopy-open').' Confirm Delete</button>';


$str = '';
$str.=  $form_start_line;
$str.='<div id="'.$id.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_'.$id.'">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel_'.$id.'">'.$header.'</h4>
      </div>
      <div class="modal-body">
        '.$body.'
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       '.$button_code.'
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->';

$str.= form_end('F');
return $str;
}


function page_header($text,$tag='h3'){
return '<div class="page-header"><'.$tag.'>'.$text.' </'.$tag.'></div>';
}

function input_checkbox_without_label($name,$value='',$message='',$size=10,$help=''){
$label_size = 12 - $size;
return  ' <div class="form-group">
    <div class="col-sm-offset-'.$label_size.' col-sm-'.$size.'">
      <div class="checkbox">
<label>
<input  type="checkbox" id="'.$name.'" name="'.$name.'"  value="'.$value.'">'.$message.'
</label>
<span id="helpBlock" class="help-block">'.$help.'</span>
</div></div>
  </div>';

}
?>