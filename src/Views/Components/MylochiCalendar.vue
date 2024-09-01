<script setup>
import { ref } from 'vue'; import { Head, Link, useForm } from '@inertiajs/inertia-vue3'; import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction'
import { DateTime } from "luxon";
</script>
<template>
     <div class="collapse my-4" id="collapseEventEdit">
       <div class="card">
       <form class="card-body" id="editevent">
	         <div class="mb-3">
             <label for="inputEditEventID" class="form-label">ID</label>
             <input type="number" class="form-control" id="inputEditEventID" readonly />
             </div>
	         <div class="mb-3">
             <label for="inputEditEventTitle" class="form-label">Titulo</label>
             <input type="text" class="form-control" id="inputEditEventTitle" required />
             </div>
	         <div class="mb-3">
             <label for="inputEditEventStart" class="form-label">inicio</label>
	         <input type="datetime-local" class="form-control" id="inputEditEventStart" required />
             </div>
	         <div class="mb-3">
             <label for="inputEditEventEnd" class="form-label">Termino</label>
	         <input type="datetime-local" class="form-control" id="inputEditEventEnd" required />
             </div>
             <div class="col-12 col-md-6">
	             <button type="submit" class="btn btn-primary bg-primary" :class="{ 'opacity-25': formedit.processing }" :disabled="formedit.processing">Atualizar</button>
             </div>
       </form>
       <div class="card-footer">
             <div class="row">
                   <div class="col-12 col-md-6">
                   <form id="formdeleteevent">
                         <input type="hidden" class="form-control" id="inputDeleteEventID" />
			             <button type="submit" class="btn btn-danger bg-danger"  :class="{ 'opacity-25': formdelete.processing }" :disabled="formdelete.processing">Excluir</button>
                   </form>
                   </div>
             </div>
       </div>
       </div>
     </div>
     <FullCalendar class="calendar w-full h-50" :options='calendarOptions'></FullCalendar>
</template>
<script>
const form = useForm();
const formedit = useForm();
const formdelete = useForm();

function formatdate(currentDatetime, timezone=false, milliseconds=true, seconds=true, format='extended'){
const newdate = new DateTime.fromISO(currentDatetime).set({milliseconds: 0, seconds: 0}).toISO({suppressMilliseconds: milliseconds, suppressSeconds: seconds, includeOffset: timezone, format: format});
return newdate;
};
export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data: function() {
    return {
      calendarOptions: {
        plugins: [
          dayGridPlugin,
          timeGridPlugin,
		  listPlugin,
          interactionPlugin // needed for dateClick
        ],
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
		events: function(info){
		     return axios.get(route('managerscheduling.index', {start: info.startStr, end: info.endStr})).then(res => {
             return res.data;
             }).catch(err => {
                   $('#app').before('<div class="alert alert-danger bg-danger">Falha ao carregar os eventos deste mês</div>');
             });
		},
		locale: 'pt',
        initialView: 'dayGridMonth',
		displayEventTime: true,
        editable: true,
        selectable: true,
        selectMirror: true,
        weekends: true,
        select: this.handleDateSelect,
        eventClick: this.handleEventClick,
        eventsSet: this.handleEvents
        /* you can update a remote database when these fire:
        eventAdd:
        eventChange:
        eventRemove:
        */
      },
      currentEvents: []
    }
  },
  methods: {
    handleWeekendsToggle() {
      this.calendarOptions.weekends = !this.calendarOptions.weekends // update a property
    },
    handleDateSelect(selectInfo) {
      let calendarApi = selectInfo.view.calendar;
	  if($('#modal').hasClass('show') == false){
	  $('#modal').modal('show');
      }
      calendarApi.unselect(); // clear date selection
      $('input#inputEventStart').val(formatdate(selectInfo.startStr));
      $('input#inputEventEnd').val(formatdate(selectInfo.endStr));
	  $('body').on('submit', 'form#newevent', function(event){
	  $('form#newevent').find('button[type="submit"]').prop('disabled', true);
	  event.preventDefault();
         form.transform(data => ({
              title: $('input#inputEventTitle').val(),
              start: formatdate($('input#inputEventStart').val()),
              end: formatdate($('input#inputEventEnd').val()),
         })).post(route('managerscheduling.store'), {
			  onSuccess: function(response){
			       calendarApi.addEvent({
                   id: response.props.id,
                   title: $('input#inputEventTitle').val(),
                   start: formatdate($('input#inputEventStart').val()),
                   end: formatdate($('input#inputEventEnd').val()),
                   allDay: selectInfo.allDay
                   })
	               $('#modal').modal('hide')
			  	   $('form#newevent').find('button[type="submit"]').prop('disabled', false);
			  }
			  })
              });	  
    },
    handleEventClick(clickInfo) {
      let calendarApi = clickInfo.view.calendar;
      calendarApi.unselect(); // clear date selection
	  if($('#collapseEventEdit').hasClass('show') == false){
      $('#collapseEventEdit').collapse('show');
      }
      var datestart = new Date(clickInfo.event.startStr);
      var dateend = new Date(clickInfo.event.endStr);
      $('input#inputDeleteEventID').val(clickInfo.event.id);
      $('input#inputEditEventID').val(clickInfo.event.id);
      $('input#inputEditEventTitle').val(clickInfo.event.title);
      $('input#inputEditEventStart').val(formatdate(clickInfo.event.startStr));
      $('input#inputEditEventEnd').val(formatdate(clickInfo.event.endStr));
	  $('body').on('submit', 'form#formdeleteevent', function(event){
	     event.preventDefault();
         formdelete.transform(data => ({
              id: clickInfo.event.id,
              })).delete(route('managerscheduling.destroy', {id: clickInfo.event.id}), {
			  onSuccess: function(){
			  clickInfo.event.remove();
              $('#collapseEventEdit').collapse('hide');
			  return true;}
              });	  
      });
	  $('body').on('submit', 'form#editevent', function(event){
	  event.preventDefault();
          formedit.transform(data => ({
              title: $('input#inputEditEventTitle').val(),
              start: formatdate($('input#inputEditEventStart').val()),
              end: formatdate($('input#inputEditEventEnd').val()),
              })).put(route('managerscheduling.update', {id: clickInfo.event.id}), {
			  onSuccess: function(){ 
			  clickInfo.event.setProp('title', $('input#inputEditEventTitle').val())
			  clickInfo.event.setDates(formatdate($('input#inputEditEventStart').val()), formatdate($('input#inputEditEventEnd').val()))
              return true;
			  }
        });
      });
    },
    handleEvents(events) {
      this.currentEvents = events
    }
  }
}
</script> 