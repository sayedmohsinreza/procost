<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$table_name = $_GET['table'];



$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard');
$button_menu[] = array('link'=>'setup_parameter.php','text'=>'Setup Effort Factor','icon'=>'wrench');
button_menu_create($button_menu);



print '<div class="page-header">
        <h1>Setup Job Type </h1>
      </div>';
	  

if(isset($_POST['set_title_value']) ){

$delete_query='DELETE FROM '.$table_name;
if(mysql_query($delete_query)){
reset($_POST['title']);
$i=0;
//print'<pre>';
//print_r($_POST['value']);die;
while (list($key, $val) = each($_POST['title']))
  {
  if($val!=""){
$insert_query='INSERT INTO '.$table_name.' (`id`,`title`, `value`) VALUES ("'.($i+1).'", "'.$val.'","'.$_POST['value'][$i].'");';
mysql_query($insert_query);
$i++;}
  }
print '<div class="alert alert-success"> Successfully updated </div>';

}else{
print '<div class="alert alert-error">  Have an error. try again. </div>';
}


}
set_input_text('Note','Effort Factor');
input_message('Select your appropriate rules');

//print '<form method="post" action="'.$_SERVER['PHP_SELF'].'" onsubmit="return validate_form(this)">';
form_start('',$_SERVER['PHP_SELF'].'?table='.$table_name);
$rules_arr = array('bayes' => 'Bayesian Rules(Recommended)','flat' => 'Flattian(Not Recommended)' );
input_dropdown('Select Rules','rules',$rules_arr);
print '   <table id="param_table" class="table table-striped" >';
 print '<thead><tr><th>ID</th><th>Title</th><th>Value</th></tr> </thead> <tbody>';  
// Display existing topics
$q = "SELECT `id`,`title`, `value` FROM ".$table_name;
$r = mysql_query($q);
$title_num = mysql_num_rows($r);
$tAR = array();
$row=1;
while ($l=mysql_fetch_array($r)) {
	print '<tr><td>' . $l['id'] . '</td><td><input class="form-control" name="title[]" value="' . (isset($l['title']) ? $l['title'] : '') . '"  maxlength="250" /></td><td><input class="form-control" name="value[]" value="' . (isset($l['value']) ? $l['value'] : '') . '"  maxlength="250" /></td></tr>
';
}
// Display additional rows
$minTopics=10;
$addRows = ((($title_num + 5) < $minTopics) ? ($minTopics - $title_num) : 5);

for ($i=1; $i <= $addRows; $i++) {
	$title_num++;
	print '<tr ><td>' . $title_num . '</td><td><input class="form-control" name="title[]" value="' . (isset($tAR[$i]['name']) ? $tAR[$i]['name'] : '') . '"  maxlength="250" /></td><td><input class="form-control" name="value[]" value="' . (isset($tAR[$i]['name']) ? $tAR[$i]['name'] : '') . '"  maxlength="250" /></td></tr>';
}
print '  </tbody> </table>';

print '<a onclick="addRow();" style="text-decoration: underline" class="btn btn-sm btn-default">'.icon('plus').' Add More Rows</a><br>';
print '<script language="javascript">
var title_num = '.($title_num+1).';
var row = '.$row.';
var j;
function addRow() {
	if (document.getElementById) {
		var param_table = document.getElementById("param_table");
		if (param_table) {
			for (j=1; j<=5; j++) {
				var trackRow = param_table.insertRow(-1);
				var idCell = trackRow.insertCell(-1);
				idCell.innerHTML = title_num;
				var nameCell = trackRow.insertCell(-1);
				nameCell.innerHTML = "<input class=\"form-control\" name=\"title[]\" value=\"\" size=\"50\" maxlength=\"250\" />";
				var valueCell = trackRow.insertCell(-1);
				valueCell.innerHTML = "<input class=\"form-control\" name=\"value[]\" value=\"\" size=\"50\" maxlength=\"250\" />";
				
				title_num += 1;
				}
		}
	}
}

</script>';
print '  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10"><button name="set_title_value" type="submit"  class="btn btn-primary">'.icon('floppy-disk').' Save</button>
	<a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i> Cancel</a>
    </div>
    </div>
	';
print '</form>';


	


  
//end farmework  
print ' </div>';
include('footer.php');

?>