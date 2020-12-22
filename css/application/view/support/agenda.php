<title>Agenda</title>
<div class="content" style="margin-top: 30px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Agenda</h4>
                        <!-- <p class="category">Creating new user</p> -->
                    </div>
                    <div class="card-content agendac">
                      <div id="agenda"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style media="screen">
.scrollable {
  height: 400px;
  overflow-y: scroll;
  }
</style>
<script type="text/javascript">
$('.agendaNav').addClass('active');
var date = new Date();
var d = date.getDate();
var m = date.getMonth();
var y = date.getFullYear();
$("#agenda").fullCalendar({
   timeZone: 'local',
    defaultDate: date,
    axisFormat: 'H:mm',
     timeFormat:'H:mm',
    eventMouseover: function(calEvent, jsEvent) {
        var tooltip = '<div class="tooltipevent"><b>' + calEvent.title + '</b></div>';
        $("body").append(tooltip);
        $(this).mouseover(function(e) {
            $(this).css('z-index', 100000);
            $('.tooltipevent').fadeIn('500');
            $('.tooltipevent').fadeTo('10', 1.9);
        }).mousemove(function(e) {
            $('.tooltipevent').css('top', e.pageY + 10);
            $('.tooltipevent').css('left', e.pageX + 20);
        });
        //console.log(tooltip);
    },

    eventMouseout: function(calEvent, jsEvent) {
         $(this).css('z-index', 8);
         $('.tooltipevent').remove();
    },
    eventClick: function(calEvent, jsEvent) {
        //showLead(calEvent.lead_id);
        window.open("<?php echo URL.$_SESSION['role'].'/viewLead/' ?>"+calEvent.lead_id);
        //$('#profile_modal').modal();
    },
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    events: {

        url:'<?=URL?>api/getEventsAdmin',
        type: 'POST',
        allDay: false,
    }
});
$(".scrollable").css({
  'height': (($(".agendac").height()+30) + 'px')
});
$('.fc-button').addClass('btn');
$('.fc-button').addClass('btn-infoi');

</script>
<style media="screen">
.tooltipevent{
background:white;
position:absolute;
color: black;
z-index:10001;
padding: 5px;
border: 1px solid  #23c6c8;
border-radius: 5px;

}
</style>
