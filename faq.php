 <?php

 include('header.php');
check_session();
print '  <div id="content">';
//start framework
include('sub-header.php');
print '<div class="page-header">
        <h1>Frequently asked questions (FAQ) </h1>
      </div>';

print '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
$i=1;
question_answer('one','What does person-month mean in development time?','<b>Person-month</b> is politically correct synonym for Man-month.<br>It\'s mean amount of work performed by the average worker in one month.');
question_answer('two','What is Function Point Analisys? What is Function Point?','Func­tion Point Analy­sis (FPA) is a software measurement tech­ni­que based on the users point of view. It measures the software functions and Func­tion Point (FP) is its mea­su­ring unit. The method has as an objective to become independent of the technology being used to build the software. In other words, FPA looks to measure what the software does and not how the software was developed.
<br><br>

This being said, the mea­su­rement pro­cess (also cal­led func­tion point coun­ting) is based on a stan­dard eva­lu­a­tion of the user’s func­ti­o­nal requi­re­ments. This stan­dard pro­ce­dure is des­cri­bed by IFPUG in the Coun­ting Prac­tices Manual.

 <br><br>

The main estimation techniques used for software development projects assume that the soft­ware size is an impor­tant dri­ver for the esti­ma­tion of its deve­lop­ment effort. Thus, knowing its size is one of the first steps in the effort, duration and cost estimation. 
<br><br>

At this point it is impor­tant to know that func­tion points do not mea­sure effort, pro­duc­ti­vity nor cost direc­tly. It is exclu­si­vely a soft­ware func­ti­o­nal size unit. This size, along with other vari­a­bles, is what could be used to derive pro­duc­ti­vity, esti­mate effort and cost of soft­ware projects.');

question_answer('three',' What’s the size to consider that a software project is small, medium or large?','It is desi­ra­ble within an orga­ni­za­tion that the pro­ject mana­ge­ment pro­cess be sca­la­ble in accor­dance with the pro­ject size. Big pro­jects need more rigorous and for­ma­l on its mana­ge­ment than small pro­jects. Using the same appro­ach for any size pro­ject means burdening smaller projects with a relatively high cost of management, ie, waste of resources.

 <br><br>

There is no indus­try stan­dard defi­ni­tion to define if a pro­ject is small, medium or large. This is a rela­tive con­cept and it must be sol­ved by each orga­ni­za­tion. In fact, it’s not usu­ally neces­sary to define a pro­ject in 3 levels (small, medium and large). For orga­ni­za­ti­ons that usu­ally work in a simi­lar way, that clas­si­fi­ca­tion could be unne­ces­sary and using the same mana­ge­ment pro­cess for all pro­jects might be the best appro­ach. Some orga­ni­za­ti­ons have a mana­ge­ment tac­tics for just two types of pro­jects (small and large). Also, it is not prohi­bi­ted if an orga­ni­za­tion wants to define more than 3 levels for the pro­ject size; (for exam­ple: small, medium, large and extra large). But this is not usual. 

 <br><br>

In summary, the con­cept of small, medium or large is very rela­tive; each orga­ni­za­tion can esta­blish it own cri­te­ria to appoint a pro­ject in rela­tion to its size.

 ');







print '</div>';






//end farmework  
print ' </div>';
include('footer.php');
 function question_answer($name,$question,$answer){
 print '<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading_'.$name.'">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$name.'" aria-expanded="true" aria-controls="collapse'.$name.'">
          Question # '.$GLOBALS['i'].' - '.$question.'
        </a>
      </h4>
    </div>
    <div id="collapse'.$name.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$name.'">
      <div class="panel-body">
        '.$answer.'
      </div>
    </div>
  </div>';
  $GLOBALS['i']++;
}

  ?>