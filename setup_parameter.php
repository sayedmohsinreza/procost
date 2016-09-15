<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$button_menu2[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu2[] = array('link'=>'index.php','text'=>'Go to Dashboard');

button_menu_create($button_menu2);  




print '<div class="row">';
    print '  <div class="page-header">
        <h1>Effort Factor Definition</h1>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Jobtype</h3>
            </div>
            <div class="panel-body">
             '.manual_create_table('SELECT `title`, `value` FROM `contact_jobtype`',array('Title', 'Value'),'m','contact_jobtype').'
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
       
	     <div class="col-sm-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Status of Task(ST)</h3>
            </div>
            <div class="panel-body">
             '.manual_create_table('SELECT `title`, `value` FROM `project_activity`',array('Title', 'Value'),'m','project_activity').'
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
		 </div>
		
		<div class="row">
		    <div class="col-sm-6">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Project Role</h3>
            </div>
            <div class="panel-body">
             '.manual_create_table('SELECT `title`, `value` FROM `project_role`',array('Title', 'Value'),'m','project_role').'
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
		
		    <div class="col-sm-6">
          <div class="panel panel-success">
            <div class="panel-heading">
              <h3 class="panel-title">Project Status</h3>
            </div>
            <div class="panel-body">
             '.manual_create_table('SELECT `title`, `value` FROM `project_status`',array('Title', 'Value'),'m','project_status').'
            </div>
          </div>
        </div><!-- /.col-sm-6 -->
      </div>






    </div> <!-- /container -->

';
  

  
//end farmework  
print ' </div>';
include('footer.php');

function manual_create_table($query,$fieldname,$id='mytable',$edit_link){

								
	$table_design='';
   $table_design .= ' <table id="'.$id.'" class="table table-striped">';
   
   $table_design .='<tr>';
	for($i=0;$i<sizeof($fieldname);$i++){
	$table_design .='<th>'.$fieldname[$i].'</th>';
	}
	$table_design .='</tr>';
	
	
	$result = mysql_query($query);
	while($row= mysql_fetch_array($result)){
	
	$table_design .= ' <tr>';
	
	for($i=0;$i<sizeof($row)/2;$i++){
	$table_design .='<td>'.$row[$i].'</td>';
	}
	
	$table_design .=' </tr>';
	
	}
	
    $table_design .='</table>';
	$table_design.= '<a href="edit_parameter.php?table='.$edit_link.'" align="center" class="btn btn-sm btn-primary">'.icon('pencil').' Edit</a>';

return $table_design;
}
?>