
<link rel="stylesheet" href="css/caledar.css">

<div class="content">

    <h1 class="text-center">manage calendar</h1>

    <button class="btn btn-primary schedule-prompt-btn fontDefault" onclick="setupPrompt()">schedule posting <i class="fa-regular fa-calendar-days"></i></button>

    <div class="table-responsive main-table">
        <table class="table table-striped">
            <thead class="table-light fixedTableHeader">
            <tr>
                <th scope="col">post</th>
                <th scope="col">accounts</th>
                <th scope="col">timing</th>
            </tr>
            </thead>
            <tbody id="scheduleDisplay">
             
            </tbody>
        </table>
    </div>



</div>



<!---------------------------------------hidden elements--------------------------------------------------- ----->

<script>

$(document).ready(function(){

    getCalander();
    getAccounts();
    getPosts();

    calendarTable_setup();
    
    prompt_temp =  $('.promptSelect').html();
    $('.promptSelect').remove();


});
// to store data object
let confirmData = [];
let pendingData = [];
// get required data 
var calendar = '';
var accounts = '';
var posts = '';



function getAccounts(){
    $.ajax({
        url: 'getAccounts',
        method: "GET",
        'async': false,
        success: function(res){ 
            accounts = res;                
        }
    });
}


function getPosts(){
    $.ajax({
        url: 'getPosts',
        method: "GET",
        'async': false,
        success: function(res){ 
            posts = res;                
        }
    });
}

function getCalander(){
    $.ajax({
            url: 'getCalendar',
            method: "GET",
            'async': false,
            success: function(res){ 
                calendar = res;
                console.log(res)
                
            },
            error: function(res){

            }
        });

}


// ------- setup functions -----------------------


function calendarTable_setup(){


    $("#scheduleDisplay").html('');

    
    calendar.map( c => {

        let temp = '<tr>\
                <td>\
                    <img src="images/'+c['image']+'" style="max-width:45px;">\
                    <span>'+c['title']+'</span>\
                </td>\
                <td>'+c['username']+' - '+c['platform']+'</td>\
                <td>'+c['timing']+'</td>\
                <td>'+
                    '<button type="button" class="btn btn-danger" id="'+c['publish_id']+'" onclick="deleteCalendar(this.id)"><i class="fa-solid fa-xmark"></i></button>'
                +'</td>\
            </tr>';


        $("#scheduleDisplay").append(temp);


    });


}

function setupPrompt(){

    const prompt =  '<div class="prompt scroll" style="display: none;">'+
        '<div class="header">'+
            '<button id="xCancel" class="preventOutline" onclick="closePrompt()"><i class="fa-solid fa-xmark"></i></button>'+
       ' </div>'+

    
       ' <form class="form" action="postCalendar" method="POST">'+
            '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
            '<input type="hidden" name="_method" value="POST">'+   
    
            '<div class="container-fluid">'+
    
                '<div class="row posts_input">'+
                    
                    '<div class="col-12"><div id="alert_area"></div></div>'+
    
                    '<div class="col-sm-6">'+
                      '<label for="postsDisplay" class="fontDefault">post</label>'+
                        '<select name="posts" id="postsSetup" class="selectStyle1" oninput="postShow(this.value)">'+
            
                        '</select>'+
    
                        '<div id="postShow">'+
                        
                        '</div>'+
                   '</div>'+
    
                    '<div class="col-sm-6">\
                        <label class="fontDefault" id="accountsList" >accounts</label>\
                        <input type="text" id="accountsList" placeholder="Search by username" onkeyup="filterAccounts(value)" class="inputStyle1 preventOutline">\
                        <ul class="scroll accountsList" id="accountsSetup">\
                            <!--- setup accounts checkbox template ----->\
                        </ul>\
                    </div>'+
    
                    '<div class="col-sm-12">\
                        <label for="timing" class="timing fontDefault">Timing <span class="timingAlert" style="color:red;"></span></label>\
                        <input type="datetime-local" id="timing" class="inputStyle1">\
                    </div>\
                </div>'+
    
                '<button class="buttonDefault preventOutline add-to-list" onclick="add_to_list()" >Add to the list</button>'+
    
    
               '<div style="margin: 50px 0px 0px 0px; width: 100%;">\
                    <h5>Pending</h5>\
                    <div class="table-responsive prompt-table scroll">'+
                        
                        '<table class="table table-striped">\
                            <thead class="fixedTableHeader">\
                                <tr>\
                                    <th>Post title</th>\
                                    <th>Accounts</th>\
                                    <th>Timing</th>\
                                </tr>\
                            </thead>\
                            <tbody id="pendingDisplay">\
                            </tbody>\
                        </table>\
                    </div>\
                </div>'+
                
                '<hr>'+
               ' <button class="preventOutline fontDefault confirm_prompt_info" onclick="confirmPending()">Confirm <i class="fa-regular fa-square-check"></i></button>'+
    
    
        '</form>\
        </div>\
    </div>';

    $('main').prepend(prompt);
    $('.prompt').show();
    $('.content').css('opacity','0.3');   
    
    postsSetup();
    setupCheckBoxed(accounts);
}

function setupCheckBoxed(arr){

    $('#accountsSetup').html('');

    accounts.map( account => {

        var temp = '<li>'+
                        '<input type="checkbox" id="checkbox" name="accountCheck[]" value="'+account['account_id']+'">'+
                        '<label for="checkbox" class="accountCheckLabel" style="margin-left:10px;">'+account['username']+'-'+account['platform']+'</label>'+
                    '</li>';
        $('#accountsSetup').append(temp);
        
    });

}

function postsSetup(){

    target = document.getElementById('postsSetup');
    // add empty option
    var opt = document.createElement('option');
    opt.innerHTML = '..............';
    target.appendChild(opt);

    var index = 0;
    posts.forEach(post => {
        index++;
        var opt = document.createElement('option');
        opt.value = post['post_id'];
        opt.innerHTML = index + ' - ' + post['title'];
        target.appendChild(opt);
    });

}


// --------- end setup functions ------------------

// ------------ button actions -------------------------

function closePrompt(){
    $('.prompt').remove();
    $('.content').css('opacity','1');

}

function filterAccounts(value){

    var str = value.toLowerCase();
    var filltered_data = [];

    accounts.forEach(a => {
        if(a['username'].includes(str)){
            filltered_data.push(a);
        }    
    });

    setupCheckBoxed(filltered_data);

}

function postShow(value){

    data = [];
    posts.map(el =>{
        if(el['post_id'] == value){
            data =el;
        }  
    })

    if(Object.keys(data).length !== 0){

        const temp = ' <div class="card" style="width: 100%; margin: 10px 0px;">\
                        <img class="card-img-top" src="images/'+data['image']+'" alt="Card image cap">\
                            <div class="card-body">\
                              <h5 class="card-title">'+data['title']+'</h5>\
                              <p class="card-text">'+data['text']+'</p>\
                            </div>\
                        </div>';

        $('#postShow').html(temp);
        
    }else{
        $('#postShow').html('');
    }


}

function accountsValidation(object){
    

    let checkAccounts = 0;
    accounts.forEach( a => {
        object[0]['account'].forEach( objAccount =>{
            if(a.account_id == objAccount){
                checkAccounts = 1;
            }
        })
    })

    return checkAccounts;
 
    
}

function postValidation(object){
    let checkPost = 1;
    posts.map(el => {
        if(el['post_id'] != object[0]['post']){
            checkPost = 0;
        }
    })

    return checkPost;
}

function dateValidation(object){

    let checkDate = 1;
    
    var currentDate = new Date();

    let timing = new Date(object[0]['timing']);

    if(timing < currentDate){
        checkDate = 0;
    }
    else if(!object[0]['timing']){
        checkDate = 0;
    }

    return checkDate;
}



function validation(object){

    let msg = '';
    $("#alert_area").html('');

    if(accountsValidation(object) == 0){
        msg += 'please select an account <br>';

    }

    if(postValidation(object) == 0){
        msg += 'please select a post <br>';
    }

    if(dateValidation(object) == 0){
        msg += 'please select a proper date <br>';
    }

    console.log(msg);

    if(msg){
        let temp = '<div class="alert alert-danger"><strong>'+msg+'</strong></div>';
        $("#alert_area").html(temp);
    }

    if(accountsValidation(object) == 1 && postValidation(object) == 1 && dateValidation(object) == 1){
        return 1;
    }
    

}

function add_to_list(){

    event.preventDefault();

    // collect information
    let timing = $('#timing').val();
    let posts = $('#postsSetup :selected').val();
    let arr = [];


    let check = $("input[name='accountCheck[]']");
    for(i = 0 ; i < check.length ; i++){
        if(check[i].checked){
            arr.push([check[i].value]);
        }  
    }
    
    let obj =   [   {
                    post: posts,
                    timing:timing,
                    account: arr,
                    }
                ];

    if(validation(obj) == 1){
        pendingDisplay(obj);
        pendingData.push(obj);
    }

}

function confirmPending(){

    event.preventDefault();
    confirmData = pendingData;


    $.ajax({
            url: 'postCalendar',
            method: "POST",
            data:{
                _method:'POST',
                _token: "{{ csrf_token() }}",
                data:confirmData,
            },
            success: function(res){ 
               
            },
            error: function(res){

            }
        });

    getCalander();
    calendarTable_setup();

}


function deleteCalendar(id){
    $.ajax({
            url: 'deleteCalendar',
            method: "GET",
            data:{
                _method:'GET',
                _token: "{{ csrf_token() }}",
                id:id
            },
            success: function(res){ 
                
            },
            error: function(res){

            }
        });

        getCalander();
        calendarTable_setup();

}


// ---------------- end button actions --------------------

// ---------------- display functions --------------------

function pendingDisplay(object){

    // fetch required data
    let post_title = '';
    let accountsList = [];

    posts.map(el => {
        if(el['post_id'] == object[0]['post']){
            post_title = el['title'];
        }
    })

        
    
    for(i = 0 ; i < accounts.length ; i++){
        for(j = 0 ; j < object[0]['account'].length ; j++){
            if(accounts[i]['account_id'] == object[0]['account'][j]){
                accountsList.push(accounts[i]);
            }
        }  
    }

    let li = '';
    accountsList.forEach(el => {
        li += '<li>'+el['username']+'</li>';
    });

    const temp = '<tr>\
                    <td>'+post_title+'</td>\
                    <td>\
                        <ul class="accountsListPlacement">'+li+'</ul>\
                    </td>\
                    <td>'+object[0]['timing']+'</td>\
                </tr>';

    $('#pendingDisplay').append(temp);
    

}


// ---------------- end display functions


</script>