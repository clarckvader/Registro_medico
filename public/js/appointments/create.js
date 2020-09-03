
let $doctor, $date, $specialty, $hours;
let iRadio;

const noHoursAlert = `<div class="alert alert-warning" role="alert">
<strong>Lo sentimos</strong>, no se encontraron horas disponibles para el médico en el dia seleccionado. 
</div>`;

$(function specialtyChange(){

    $specialty = $('#specialty');
    $date = $('#date');
    $doctor= $('#doctor');
    $hours=$('#hours');

    $specialty.change(()=>{
        const specialtyId=$specialty.val();    
        if(specialtyId){
            
            const url=`/specialties/${specialtyId}/doctors`;
            $.getJSON(url , onDoctorsLoaded);
        }
      
    });

    $doctor.change(loadHours)
    $date.change(loadHours);

    
});  




function onDoctorsLoaded(doctors){
    let htmlOptions = '';
    doctors.forEach(doctor => {
       htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`
    });
    $doctor.html(htmlOptions);
    loadHours();
}

function loadHours(){
    const selectdate=$date.val();
    const doctorId= $doctor.val();
    const url = `/schedule/hours?date=${selectdate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHours)
}

function displayHours(data){
    if(!data.morning && !data.afternoon){
        $hours.html(noHoursAlert);
        return;
    }
    let htmlHours = '';
    iRadio=0;
    if(data.morning){
        const morning_intervals = data.morning;
        morning_intervals.forEach(interval => {
            htmlHours+=getRadioIntervalHtml(interval);
        });
    }
    if(data.afternoon){
        const afternoon_intervals = data.afternoon;
        afternoon_intervals.forEach(interval => {
        htmlHours+=getRadioIntervalHtml(interval);
        });
        $hours.html(htmlHours);
    }
}

function getRadioIntervalHtml(interval){
    const text = `${interval.start} - ${interval.end} `
    return `<div class="custom-control custom-radio">
    <input type="radio" value="${interval.start}" id="interval ${iRadio}" name="schedule_time" class="custom-control-input" required>
    <label class="custom-control-label" for="interval ${iRadio++}">${text}</label>
  </div>`
}