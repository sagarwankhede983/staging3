$(document).ready(function() {
    //var currentTimezone = "Asia/Bangkok";
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        editable: true,
        selectable: true,
        selectHelper: true,
        eventColor: '#378006',
      //  timezone: currentTimezone,
        dayClick: function(date, jsEvent, view) {


            //alert('Clicked on: ' + date.format());
            //alert(date);


        },
        eventClick: function(calEvent, jsEvent, view) {

            alert('Event: ' + calEvent.title +'start:'+calEvent.start.format()+'end:'+calEvent.end.format());
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);

            // change the border color just for fun
            //$(this).css('border-color', 'red');
           // $('#modal1').openModal();

        },
        select: function(start, end) {

           /*var allDay = !start.hasTime() && !end.hasTime();
            alert(["Event Start date: " + moment(start).format(),
                "Event End date: " + moment(end).format(),
                "AllDay: " + allDay].join("\n"));

            $('#starttime').val(start);
            $('#endtime').val(end);*/
            calendar.fullCalendar('unselect');
            /*$('#myForm').submit(function(event){

                // Abort any pending request
                if (request) {
                    request.abort();
                }
                // setup some local variables
                var $form = $(this);

                // Let's select and cache all the fields
                var $inputs = $form.find("input, select, button, textarea");

                // Serialize the data in the form
                var serializedData = $form.serialize();

                console.log( $( this ).serialize() );

                // Let's disable the inputs for the duration of the Ajax request.
                // Note: we disable elements AFTER the form data has been serialized.
                // Disabled form elements will not be serialized.
                $inputs.prop("disabled", true);

                // Fire off the request to /form.php
                request = $.ajax({
                    url: "/ajax/addEvent",
                    type: "post",
                    data: serializedData
                });

                // Callback handler that will be called on success
                request.success(function (response, textStatus, jqXHR){
                    // Log a message to the console
                    Materialize.toast("event added");
                    console.log("Hooray, it worked!");
                });

                // Prevent default posting of form
                event.preventDefault();



            });*/

        }
    });

});


