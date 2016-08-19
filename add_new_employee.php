<?php
include('header.php');
print '  <div id="content">';
//start framework
include('sub-header.php');

print '<div class="pull-right">';
print '<a href="hgc_design_grant_chart/" class="btn btn-sm btn-primary">Design Grant Chart for project</a> | ';
print '<a href="add_new_project.php" class="btn btn-sm btn-primary">Add New Project</a> | ';
print '<a href="index.php" class="btn btn-sm btn-primary">Go to Dashboard</a>';
print'</div>';
print '<div class="page-header">
        <h1>Add New Project </h1>
      </div>';
	  
	  if(isset($_POST['submit'])){
$query ="INSERT INTO `confreviewer` (`reviewerid`, `username`, `password`, `name`, `email`, `url`, `organization`, `country`, `telephone`, `track_id`, `comments`, `status`, `assigned_by`)
 VALUES (NULL, '".$_POST['rev_username']."', '".$_POST['rev_password']."', '".$_POST['rev_name']."', '".$_POST['rev_email']."', '', '".$_POST['rev_org']."', '".$_POST['rev_country']."', '".$_POST['rev_tel']."', '".$_POST['rev_track']."', '".$_POST['rev_message']."', 1, 0);";
if(mysql_query($query)){
$new_rid = mysql_insert_id();
$subject_mail='Greetings from '.$conf_name.': Reviewer';
$track_name= value_return('SELECT `track_name` FROM `track` WHERE `track_id`='.$_POST['rev_track']);
$body_mail='Hi '.$_POST['rev_name'].',<br>
You are invited as a reviewer of '.$conf_name.' for the track<b> '.$track_name.'</b>.<br><br>
To confirm you as a reviewer of '.$conf_name.', Please <a href="http://'.$_SERVER['SERVER_NAME'].'/proconf/review/rev_activate.php?rid='.$new_rid.'&username='.$_POST['rev_username'].'&password='.$_POST['rev_password'].'">Click Here</a> to activate.<br>
<br><b>Profile Information:</b><br>
Username : '.$_POST['rev_username'].' <br>
Password : '.$_POST['rev_password'].'<br>

To login to your reviewer page, please visit <a href="http://'.$_SERVER['SERVER_NAME'].'/proconf2016/review/"> '.$conf_name.' Reviewer Login</a><br><br>

For More Information please visit <a href="'.$conf_url.'">'.$conf_name.' Website</a> <br>
Email us to at <a href="mailto:'.$conf_email.'">'.$conf_email.'</a><br><br>

Message From Assigner: '.$_POST['rev_message'].'<br><br>
Sincerely<br>
'.$conf_name.' Committee<br>
 ';
 if(isset($_POST['email_rev'])){
send_email($conf_email,$_POST['rev_email'],$subject_mail,$body_mail,'Mail sent to '.$_POST['rev_email'].' successfully.','Mail is not sent. Try again');
}

//if(!send_email($conf_email,$_POST['rev_email'],$subject_mail,$body_mail,'Mail sent to //'.$_POST['rev_email'].' successfully.','Mail is not sent. Try again')){
//print $body_mail;
//}
print '    <div class="alert alert-success">  New Reviewer has been added Successfully .   </div>'; 

}else{
print '    <div class="alert alert-error">  Already exist email or username. Please <a href = "add_new_reviewer.php">Try again</a>.    </div>'; 
}



}
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

?>