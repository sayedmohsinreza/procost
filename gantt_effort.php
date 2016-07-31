<?php // content="text/plain; charset=utf-8"
// Gantt example
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_gantt.php');
require_once('connect.php'); 
require_once('include.php'); 

$graph = new GanttGraph();

$project_title = value_return("SELECT `title` FROM `project` WHERE `id`=".$_GET['pid']) ;
$graph->title->Set("Procost Gantt Chart for Project: ".$project_title);
 
// Setup some "very" nonstandard colors
$graph->SetMarginColor('lightgreen@0.8');
$graph->SetBox(true,'yellow:0.6',2);
$graph->SetFrame(true,'darkgreen',4);
$graph->scale->divider->SetColor('yellow:0.6');
$graph->scale->dividerh->SetColor('yellow:0.6');
 
// Explicitely set the date range 
// (Autoscaling will of course also work)
$date_start = value_return("SELECT `date_start` FROM `project` WHERE `id`=".$_GET['pid']) ;
$date_end = value_return("SELECT `date_end` FROM `project` WHERE `id`=".$_GET['pid']) ;
$graph->SetDateRange(customdate_format($date_start,'Y-m-d'),customdate_format($date_end,'Y-m-d'));
 
// Display month and year scale with the gridlines
$graph->ShowHeaders(GANTT_HMONTH | GANTT_HYEAR);
$graph->scale->month->grid->SetColor('gray');
$graph->scale->month->grid->Show(true);
$graph->scale->year->grid->SetColor('gray');
$graph->scale->year->grid->Show(true);
 
 
// Setup activity info
 
// For the titles we also add a minimum width of 100 pixels for the Task name column
$graph->scale->actinfo->SetColTitles(
    array('Name','Duration','Start','Finish'),array(100));
$graph->scale->actinfo->SetBackgroundColor('green:0.5@0.5');
$graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
$graph->scale->actinfo->vgrid->SetStyle('solid');
$graph->scale->actinfo->vgrid->SetColor('gray');
 
$main_query= "SELECT `title`, `date_start`, `date_end` FROM `project_task` WHERE `id_project`=".$_GET['pid']; 
$result = mysql_query($main_query) ;

$i=0;
// Data for our example activities
$data = array();
while($row = mysql_fetch_array($result)){
$date1=date_create(customdate_format($row['date_start'],'Y-m-d'));
$date2=date_create(customdate_format($row['date_end'],'Y-m-d'));
$diff=date_diff($date1,$date2);


array_push($data, array($i,array($row['title'],$diff->format("%R%a days"),customdate_format($row['date_start']),customdate_format($row['date_end']))
          , customdate_format($row['date_start'],'Y-m-d'),customdate_format($row['date_end'],'Y-m-d'),FF_ARIAL,FS_NORMAL,8));
		  $i++;
		  }
    
//);
    
// Create the bars and add them to the gantt chart
for($i=0; $i<count($data); ++$i) {
    $bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],"[50%]",10);
    if( count($data[$i])>4 )
        $bar->title->SetFont($data[$i][4],$data[$i][5],$data[$i][6]);
    $bar->SetPattern(BAND_RDIAG,"yellow");
    $bar->SetFillColor("gray");
    $bar->progress->Set(0.5);
    $bar->progress->SetPattern(GANTT_SOLID,"darkgreen");
    $graph->Add($bar);
}
 
// Output the chart
$graph->Stroke();
 
?>