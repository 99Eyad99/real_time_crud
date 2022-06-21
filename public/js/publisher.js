$(document).ready(function(){

    let calendar = '';

    getCalander();
    timeCheck();

    


});



function getCalander(){
    $.ajax({
            url: 'getCalendar',
            method: "GET",
            'async': false,
            success: function(res){ 
                calendar = res; 
                console.log(calendar);
            },
            error: function(res){

            }
        });
}

function timeNow(){
    let date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    //var seconds = date.getSeconds();

    let time = year + "-0" + month + "-0" + day + " " + hours + ":" + minutes + ":00";
    return time;
}

function timeCheck(){
    setInterval(function(){
       
        let current_time = timeNow();
        
        calendar.map( c => { 
            if(c['timing'] == current_time){
                console.log('yes');
            }
            console.log(1)
        });

    },10000)
}
