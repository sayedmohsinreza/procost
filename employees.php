<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

$button_menu[] = array('link'=>'hgc_design_grant_chart/','text'=>'Design Grant Chart for project');
$button_menu[] = array('link'=>'add_new_project.php','text'=>'Add New Project');
$button_menu[] = array('link'=>'index.php','text'=>'Go to Dashboard');
button_menu_create($button_menu);

print '<div class="page-header"><h1>Employeess </h1>   </div>';
	  
if(isset($_POST['submit'])){

}

$select_table = "SELECT concat(`firstname`, ' ',`lastname`) as name,`email`,`id_jobtype`,`id_person_create`,`is_active` FROM `contact_person` WHERE 1";
$fieldname = array('Name','Email','Position','Created By','Active' );
create_manual_table($query,$fieldname,$id='mytable')

form_start();	  
	  
input_text('Project Name','pr_name');
input_area('Description','pr_desc');

input_text('Project Start','pr_start');
input_text('Project End','pr_end');
input_dropdown('Project Status','pr_status',array('On','Off'));

        
print '<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
    <a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-remove-circle"></i> Cancel</a>
    </div>
    </div>';

		
form_end();
    
        
  

  
//end farmework  
print ' </div>';
include('footer.php');


function create_manual_table($query,$fieldname,$id='mytable'){


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

    print'<td>'.$row[0].'</td>';
    print'<td>'.$row[1].'</td>';
    print'<td>'.$row[2].'</td>';
    print'<td>'.$row[3].'</td>';  
print'<td>'.$row[4].'</td>';
print'<td>'.$row[5].'</td>';
  

    
    print' </tr>';
    
    }
    
    print'</tbody></table>';


}

?>