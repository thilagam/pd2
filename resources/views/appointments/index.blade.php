@extends('../app')

@section('content')

<script type="text/javascript">
			// Calendar Initialization
			jQuery(document).ready(function($)
			{
				// Calendar Initialization
				$('#calendar_lvp').fullCalendar({
					header: {
						left: 'title',
					center: '',
						right: 'month,agendaWeek,agendaDay prev,next'
					},
					buttonIcons: {
						prev: 'prev fa-angle-left',
						next: 'next fa-angle-right',
					},
					defaultDate: new Date(),
					editable: true,
					eventLimit: true,
					events: [ ],
					//eventRender: function(event, element) {
					//		      $(element).tooltip({title: event.title});
					//	     }

eventMouseover:  function(event, jsEvent, view){
            $('#modalTitle').html("Subject :-"+event.title);
            $('#modalBody').html(event.description);
            $('#eventUrl').attr('href',event.url);
            $('#eventUrl1').attr('href',event.url+"/edit");
            $('#fullCalModal').modal();
        }

				});

<?php if(sizeof($appointments) > 0) { foreach($appointments as $appo){
        $description = 'Description :- '.$appo->apo_description.'<br /><br /> Client:- '.$appo->clientRelationship->name.'<br /> Product:- '.$appo->productRelationship->prod_name.'<br /> EpIncharge:- '.$appo->epInchargeRelationship->name.'<br /> ClientIncharge:- '.$appo->clientInchargeRelationship->name;
	?>
	var newEvent = new Object();
	newEvent.url = "/appointments/"+"<?php echo $appo->apo_id; ?>";
	newEvent.title = "<?php echo $appo->apo_subject ?>";
	newEvent.description = "<?php echo $description; ?>";
	var dt = "<?php echo $appo->apo_datetime ?>".replace(" ","T");
	newEvent.start = dt;
	newEvent.allDay = false;
	$('#calendar_lvp').fullCalendar( 'renderEvent', newEvent);
<?php } } ?>

			});
			</script>



			<section class="calendar-env">

				<div class="col-sm-12 calendar-right">

					<div class="calendar-main">

					@if($permit->module_client_appointments_create)
						<h5> <a class="pull-right" href="{{ route('appointments.create') }}"> <i class="fa fa-plus"></i> {{ $dictionary['apo_create'] }}</a> </h5> <br /><br />
					@endif

						<div id="calendar_lvp"></div>

					</div>

				</div>
                       </section>

<div id="fullCalModal" class="modal fade" style="margin-top:6%">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">{{ $dictionary['apo_view_close'] }}</span></button>
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ $dictionary['apo_view_close'] }}</button>
			@if($permit->module_client_appointments_read)
                <a id="eventUrl" class="btn btn-purple" >{{ $dictionary['apo_view_read'] }}</a>
            @endif
            @if($permit->module_client_appointments_edit)
                <a id="eventUrl1" class="btn btn-info" >{{ $dictionary['apo_view_edit'] }}</a>
            @endif
            </div>
        </div>
    </div>
</div>

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="{{ asset('/assets/js/fullcalendar/fullcalendar.min.css') }}">

		<!-- Imported scripts on this page -->
	<!--script src="{{ asset('/assets/js/fullcalendar/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('/assets/js/jquery-ui/jquery-ui.min.js') }}"></script -->



@stop
