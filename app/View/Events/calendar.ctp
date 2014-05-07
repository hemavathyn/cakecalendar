<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src='/CALENDARCAKE/js/jquery-ui-1.10.3.custom.min.js'></script>
<script src='/CALENDARCAKE/js/fullcalendar.min.js'></script> 
<script src='/CALENDARCAKE/js/fullcalendar.js'></script> 
<link href='/CALENDARCAKE/css/fullcalendar.css' rel='stylesheet' />
<link href='/CALENDARCAKE/css/fullcalendar.print.css' rel='stylesheet' media='print' />
<script>
		$(document).ready(function() {
			var date = new Date();
			var d = date.getDate();
			var m = date.getMonth();
			var y = date.getFullYear();	

			var calendar = $('#calendar').fullCalendar({
						header: {
                					left: 'prev,next today',
                					center: 'title',
                					right: 'month,agendaWeek,agendaDay'
            					},
					editable: true,
					events: "/CALENDARCAKE/events/event",
					selectable: true,
					selectHelper: true,
					select: function(start, end, allDay) {
 						var title = prompt('Event Title:');
						var details = prompt('Description');
					 	if (title) {
 								start = $.fullCalendar.formatDate(start, "yyyy-MM-dd");
 								end = $.fullCalendar.formatDate(end, "yyyy-MM-dd");
 								$.ajax({
	 									url: "/CALENDARCAKE/events/add",
 										data: 'title='+ title+ '&details=' + details +'&start='+ start +'&end='+ end ,
	 									type: "POST",
 										success: function(json) {
 										alert('OK');
 										}
 								});
 								calendar.fullCalendar('renderEvent',
 								{
 									title: title,
									details: details,
	 								start: start,
 									end: end,
									allDay: allDay
		
 								},
 									true 
 								);
 						}
 						calendar.fullCalendar('unselect');
					},

					eventClick: function(calEvent, jsEvent, view) {
							start = $.fullCalendar.formatDate(calEvent.start, "yyyy-MM-dd");
 							end = $.fullCalendar.formatDate(calEvent.end, "yyyy-MM-dd");
						        alert('Description: ' + calEvent.details);
        					        alert('start: ' + start );
		        				alert('end: ' + end );
							    $(this).css('border-color', 'black');
    					},
					eventDrop: function(event, delta) {
							
                					
					},
            		loading: function(bool) {
                					if (bool) $('#loading').show();
                					else $('#loading').hide();
            				},
				   	eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
						start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd");
 							end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd");
							alert('start: ' + start );
		        				alert('end: ' + end );
							$.ajax({
 								url: "/CALENDARCAKE/events/edit",
 								data: 'title='+ event.title+ '&details='+event.details+ '&start='+ start +'&end='+ end +'&id='+ event.id,
 								type: "POST",
 								success: function(json) {
 									alert("OK");
 								}
 						});
 					}
				});
									
			});
				
		</script>
		<style>
			
		body {
			margin-top: 40px;
			text-align: center;
			font-size: 14px;
			font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
			background-color:#600000 ;url("events/calendar");
			
		}

		
    		#loading {
        			position: absolute;
        			top: 5px;
        			right: 5px;
        	}
		#calendar {
			width: 900px;
			margin: 0 auto;
			background-color:#808080;url("events/calendar"); 
		}
		</style>
		<div id='calendar'></div>
		<div id="eventContent" title="Event Details" style="display:none;">
    			<span id="startTime"></span>
    			<span id="endTime"></span>
    			<div id="eventInfo"></div>
    			<p><strong><a id="eventLink" href="" target="_blank">Read More</a></strong></p>

		</div>
		<?php echo $this->Html->link( "Logout",   array('controller' => 'users', 'action'=>'logout') );?>