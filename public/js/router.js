function viewProfile(){
    $.ajax({
        url: 'profile',
        method: "GET",
        success: function(res){  
            $('#view').html(res);
        }
    });
}

// ---------------- side bar ----------------------------
    // ------------------ sidebar effect -----------------------------------
    let direction = ['dashboard','manage_accounts','my_calendar','add_post'];

    function activeDirection(id){
        direction.forEach(e => {
            if(e == id){
                $('#'+e).addClass('active');
            }else{
                $('#'+e).removeClass('active');
            } 
        });
    }
    // --------------- end sidebar effect------------------------------------

    // render dashbarod page
    function viewDashboard(id){
        $.ajax({
            url: 'dashboard',
            method: "GET",
            success: function(res){ 
                activeDirection(id); 
                $('#view').html(res);
            }
        });
    }

    function viewAccount(id){
        $.ajax({
            url: 'accounts',
            method: "GET",
            success: function(res){ 
                activeDirection(id); 
                $('#view').html(res);
            }
        });
    }

    function viewCalendar(id){
        $.ajax({
            url: 'calendar',
            method: "GET",
            success: function(res){ 
                activeDirection(id); 
                $('#view').html(res);
            }
        });
    }

    function addPost(id){
        $.ajax({
            url: 'add-post',
            method: "GET",
            success: function(res){ 
                activeDirection(id); 
                $('#view').html(res);
            }
        });
    }


    











