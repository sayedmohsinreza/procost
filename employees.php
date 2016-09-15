<?php
include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');

print '';

	  
if(isset($_POST['submit'])){

}


//table - SELECT
$data = SelectTableRecords("SELECT `id`, `id_person_create`, `password`, `email`, `is_admin`, `is_active`, `firstname`, `lastname`, `id_jobtype` FROM `contact_person` ");
$tabel_fieldname = array('ID','Name','Email','Position','Created By','' );
print page_header(icon('plus').' Add New Employees');



$button_menu2[] = array('link'=>'add_employee.php','text'=>'Add Employee','icon'=>'plus');
$button_menu2[] = array('link'=>'index.php','text'=>'Back to Dashboard');
button_menu_create($button_menu2);


create_manual_table($data,$tabel_fieldname,'mytable',$table_head);
datatable();

//end farmework  
print ' </div>';
include('footer.php');


function create_manual_table($data,$fieldname,$id='mytable',$table_head='Table',$table_desc=''){


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
    $modal_print ='';
foreach($data as $key => $row) { 
    print ' <tr>';

    print'<td>'.$row['id'].'</td>';
    print'<td>'.$row['firstname'].' '.$row['lastname'].'</td>';
    print'<td>'.$row['email'].'</td>';
    print'<td>'.value_return('SELECT `title` FROM `contact_jobtype` where id ='.$row['id_jobtype']).'</td>';  
print'<td>'.value_return("SELECT concat(firstname,' ',lastname) FROM `contact_person` where id =".$row['id_person_create']).'</td>';

print '<td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="edit_employee.php?employee_id='.$row[0].'" >'.icon('edit').' Edit</a></li>
    <li><a data-toggle="modal" data-target="#view_modal_'.$row['id'].'">'.icon('book').' View</a></li>
    <li role="separator" class="divider"></li>
    <li><a data-toggle="modal" data-target="#delete_modal_'.$row['id'].'">'.icon('trash').' Delete</a></li>
  </ul>
</div></td>';
  

    
    print' </tr>';

    
    }
    
    print'</tbody></table>';


}





?>