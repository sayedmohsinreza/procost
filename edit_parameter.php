<?php
include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

$table_name = $_GET['table'];

print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a> | ';
print '<a href="setup_parameter.php" class="btn btn-sm btn-primary">Setup Effort Factor</a>';
print'</div>';
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
set_input_text('Note','if submissions have been made or reviewers signed up already, you should only add new track to the end of the list or change a track\'s name to clarify it. If you want to delete a track in the middle of the list, replace its name with N/A or something authors and reviewers will know not to select.');
input_message('Tracks are used for Chair, co-chair and members to look up some topic when making automated review assignments. Both authors and reviewers are asked to select topics. Enter a sequential list of track below. When you click on Set track, track will be added sequentially regardless of the Track ID listed, with blank track ignored; thus track should only be deleted until a submission has been made or reviewer signed up.');

//print '<form method="post" action="'.$_SERVER['PHP_SELF'].'" onsubmit="return validate_form(this)">';
form_start('',$_SERVER['PHP_SELF'].'?table='.$table_name);


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

print '<span onclick="addRow();" style="text-decoration: underline">Add More Rows</span><br>';
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
    <div class="col-sm-offset-2 col-sm-10"><button name="set_title_value" type="submit"  class="btn btn-primary">Set Track</button>
	<a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i> Cancel</a>
    </div>
    </div>
	';
print '</form>';


	


  
//end farmework  
print ' </div>';
include('footer.php');

?>