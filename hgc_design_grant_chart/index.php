<!DOCTYPE html>
<html>
<head>
    <title>Design Gantt Chart for new projects</title>
    
    <!-- demo stylesheet -->
    <link type="text/css" rel="stylesheet" href="media/layout.css" />    

    <!-- helper libraries -->
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>

    <!-- daypilot libraries -->
    <script src="js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="themes/areas.css" />    
	
<script>
function print_page() {
    window.print();
}
</script>
</head>
<body>
        <div id="header">
            <div class="bg-help">
                <div class="inBox">
                    <h1 id="logo"><a href='http://code.daypilot.org/93862/html5-gantt-chart'>Procost new design Gantt Chart for new projects</a></h1>
                    <p id="claim">Gantt charts illustrate the start and finish dates of the terminal elements and summary elements of a project. Terminal elements and summary elements comprise the work breakdown structure of the project. </p>
                    <hr class="hidden" />
                </div>
            </div>
        </div>
        <div class="shadow"></div>
        <div class="hideSkipLink">
        </div>
        <div class="main">
          <a href="../index.php">Procost Homepage</a>
          
		  
            <div class="space"></div>
	<?php		
 if(!isset($_POST['submit_b'])){
?>
			
						<div >
			<form action="" method="post">
			New Project Name: <input name="p_name" type="text" /> [Ex: Sibco ERP System]<br>
			Project Start Date: <input name="p_start" type="text" /> [Ex: 2015-01-01]<br>
			Project Duration(days): <input name="p_duration" type="text" /> [Ex: 180] <br>
			<input type="submit" name="submit_b" />
			</form>
			</div>
		<?php
}
?>


              <?php if(isset($_POST['submit_b'])) {
			   ?>
			   <button onclick="print_page()">Print this Design</button>
			<h2>New Project Name: <?php echo $_POST['p_name']; ?>  </h2>
		   
            <div id="dp"></div>
		
            <script type="text/javascript">
                var dp = new DayPilot.Gantt("dp");
                dp.startDate = new DayPilot.Date("<?php echo $_POST['p_start']; ?>");
                dp.days = <?php echo $_POST['p_duration']; ?>;
                
                dp.linkBottomMargin = 5;
                
                dp.rowCreateHandling = 'Enabled';
                
                dp.columns = [
                    { title: "Name", property: "text", width: 100},
                    { title: "Duration", width: 100}
                ];
                
                dp.onBeforeRowHeaderRender = function(args) {
                    args.row.columns[1].html = new DayPilot.TimeSpan(args.task.end().getTime() - args.task.start().getTime()).toString("d") + " days";
                    args.row.areas = [
                        { 
                            right: 3, 
                            top: 3, 
                            width: 16, 
                            height: 16, 
                            style: "cursor: pointer; box-sizing: border-box; background: white; border: 1px solid #ccc; background-repeat: no-repeat; background-position: center center; background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAABASURBVChTYxg4wAjE0kC8AoiFQAJYwFcgjocwGRiMgPgdEP9HwyBFDkCMAtAVY1UEAzDFeBXBAEgxQUWUAgYGAEurD5Y3/iOAAAAAAElFTkSuQmCC);", 
                            action: "ContextMenu", 
                            menu: taskMenu, 
                            v: "Hover" 
                        }
                    ];
                };
                
                dp.contextMenuLink = new DayPilot.Menu([
                    { 
                        text: "Delete", 
                        onclick: function() {
                            var link = this.source;
                            $.post("backend_link_delete.php", {
                                id: link.id()
                            },
                            function(data) {
                                loadLinks();
                            });    
                        }
                    }
                ]);
                
                dp.onRowCreate = function(args) {
                    $.post("backend_create.php", {
                        name: args.text,
                        start: dp.startDate.toString(),
                        end: dp.startDate.addDays(1).toString()
                    },
                    function(data) {
                        loadTasks();
                    });

                };
                
                dp.onTaskMove = function(args) {
                    $.post("backend_move.php", {
                        id: args.task.id(),
                        start: args.newStart.toString(),
                        end: args.newEnd.toString()
                    },
                    function(data) {
                        dp.message("Updated");
                    });
  
                };

                dp.onTaskResize = function(args) {
                    $.post("backend_move.php", {
                        id: args.task.id(),
                        start: args.newStart.toString(),
                        end: args.newEnd.toString()
                    },
                    function(data) {
                        dp.message("Updated");
                    });
  
                };


                dp.onRowMove = function(args) {
                    $.post("backend_row_move.php", {
                        source: args.source.id,
                        target: args.target.id,
                        position: args.position
                    },
                    function(data) {
                        dp.message("Updated");
                    });
                };
                
                dp.onLinkCreate = function(args) {
                    $.post("backend_link_create.php", {
                        from: args.from,
                        to: args.to,
                        type: args.type
                    },
                    function(data) {
                        loadLinks();
                    });
                };
                
                dp.onTaskClick = function(args) {
                    var modal = new DayPilot.Modal();
                    modal.closed = function() {
                        loadTasks();
                    };
                    modal.showUrl("edit.php?id=" + args.task.id());
                };
                
                dp.init();

                loadTasks();
                loadLinks();

                function loadTasks() {
                    $.post("backend_tasks.php", function(data) {
                        dp.tasks.list = data;
                        dp.update();
                    });
                }
                
                function loadLinks() {
                    $.post("backend_links.php", function(data) {
                        dp.links.list = data;
                        dp.update();
                    });
                }
                
                var taskMenu = new DayPilot.Menu({
                    items: [
                        {
                            text: "Delete", 
                            onclick: function() { 
                                var task = this.source;
                                $.post("backend_task_delete.php", {
                                    id: task.id()
                                },
                                function(data) {
                                    loadTasks();
                                });
                            } 
                        }
                    ]
                });
                
            </script>
<?php 
}		
?>	
        </div>
        <div class="clear">
        </div>
</body>
</html>

