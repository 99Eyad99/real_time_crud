
<link rel="stylesheet" href="css/accounts.css">





<div class="content">
    <h1 class="text-center">manage accounts</h1>

    <button class="btn btn-primary add-account-btn" onclick="prompt()">Add new post <i class="fa-solid fa-plus"></i></button>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-light fixedTableHeader">
              <tr>
                <th scope="col">username</th>
                <th scope="col">platform</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody id="accountsDisplay">
            </tbody>
        </table>
    </div>


</div>


<script>

$(document).ready(function(){
    getAccounts();
    
})

// get all posts 
var accounts = '';
    function getAccounts(){
        // make posts array empty to re-count and re-store posts in case of adding new posts
        posts = null;
        $.ajax({
            url: 'getAccounts',
            method: "GET",
            'async': false,
            success: function(res){ 
                accounts = res;                
                accountDisplay();
            }
        });
    }


function accountDisplay(){

    $('#accountsDisplay').html('');

    accounts.forEach(a => {
        var template = '<tr>'+
                            '<td>'+a['username']+'</td>'+
                            '<td>'+a['platform']+'</td>'+
                            '<td>'+
                                '<div class="control">'+
                                    '<button class="btn btn-danger" id="'+a["account_id"]+'" onclick="deleteAccount(this.id)"><i class="fa-solid fa-trash"></i></button>'+
                                    '<button class="btn btn-success" id="'+a["account_id"]+'" onclick="display_veiw_edit_prompt(this.id)"><i class="fa-regular fa-eye"></i></button>'+
                                '</div>'+
                            '</td>'+
                        '</tr>';

        $('#accountsDisplay').append(template);

    });
 

}


function prompt() {
        let text;
        const form = '  <div class="add-account-prompt">'+
                            '<div class="alert alert-danger" id="add_account_form_error_area" style="display:none;"></div>'+
                            '<div class="alert alert-success" id="add_account_form_success_area" style="display:none;"></div>'+
                            '<form action="addPost" method="POST" id="add_account_from" enctype="multipart/form-data">'+                                
                                '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                '<input type="hidden" name="_method" value="POST">'+

                                '<label for="username" class="fontDefault ">username</label>'+
                                '<input type="text" name="username" id="username" class="preventOutline" required>'+

                                '<label for="password" class="fontDefault">password</label>'+
                                '<input type="password" name="password" id="password" class="preventOutline" required>'+

                                '<label for="platform" class="fontDefault">platform</label>'+
                                '<select name="platform" id="platfrom">'+
                                    '<option value="Instagram">Instagram</option>'+
                                    '<option value="Facebook">Facebook</option>'+
                                    '<option value="twitter">Twitter</option>'+
                                '</select>'+

        
                                '<button class="buttonDefault btn-submit" onclick="saveAccount()">Save</button>'+
                                '<button class="buttonDefault btn-cancel" onclick="resetPrompt()">cancel</button>'+
                            '</form>'+
                        '</div>';
        // display
        $('main').prepend(form);
        $('.content').css('opacity','0.3');

    }

    function resetPrompt(){
        event.preventDefault();
        $('.add-account-prompt').remove();
        $('.content').css('opacity','1');
    }

    function resetView(){
        event.preventDefault();
        $('.view_edit_template').remove();
        $('.content').css('opacity','1');
    }

    // view edit prompt

    function display_veiw_edit_prompt(id){

        let arr;
        accounts.forEach( (e) => {
                if(e['account_id'] == id){
                    arr = e;
                }
            }
                    
        )

        const template = '<div class="view_edit_prompt">'+
                               ' <div class="container-fuild">'+
                                    '<div class="controller">'+
                                        '<button class="cancel preventOutline" onclick="close_veiw_edit_prompt()"><i class="fa-solid fa-xmark"></i></button>'+
                                   '</div>'+
                                    '<div class="row">'+
                                        '<div class="col-md-6">'+
                                            '<div class="view_part">'+
                                                '<h5 class="text-center title">account infomation <i class="fa-solid fa-circle-info"></i></h5>'+
                                                '<table>'+
                                                    '<tr>'+
                                                        '<th>username</th>'+
                                                        '<td>'+arr["username"]+'</td>'+
                                                    '</tr>'+
                                                    '<tr>'+
                                                        '<th>platform</th>'+
                                                        '<td>'+arr["platform"]+'</td>'+
                                                    '</tr>'+
                                                '</table>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-md-6">'+

                                            '<div class="alert alert-danger" id="update_account_form_error_area" style="display:none; margin:20px 0px 5px 0px;"></div>'+
                                            '<div class="alert alert-success" id="update_account_form_success_area" style="display:none; margin:20px 0px 5px 0px;"></div>'+

                                            '<button class="edit_open_btn preventOutline fontDefault" id="'+arr["account_id"]+'" onclick="displayEditFrom(this.id); $(this).hide();">Edit account information <i class="fa-solid fa-pen-to-square"></i></button>'+
                                            '<div class="edit_part" id="edit_part">'+
                                        
                                            '</div>'+
                                       ' </div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

        $('main').prepend(template);
        $('.content').css('opacity','0.3');
            
    }

    function close_veiw_edit_prompt(){

        $('.content').css('opacity','1');
        $('.view_edit_prompt').remove();

    }

    function displayEditFrom(id){

        let arr;
        accounts.forEach( (e) => {
                if(e['account_id'] == id){
                    arr = e;
                }
            }
                    
        )

                        ;

        const template =    '<form action="updateAccount" method="POST" id="update_account_form" style="margin: 15px 0px 15px 0px;">'+

                                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                    '<input type="hidden" name="_method" value="POST">'+
                                    '<input type="text" name="id"  value="'+arr['account_id']+'" hidden>'+

                                    '<label for="username" class="fontDefault">username</label>'+
                                    '<input type="text" name="username" id="username" value="'+arr['username']+'" class="inputStyle1 preventOutline">'+

                                    '<label for="password" class="fontDefault">password</label>'+
                                    '<input type="password" name="password" id="password" placeholder="optinal (Enter if you want to change) " class="inputStyle1 preventOutline">'+

                                    '<label for="platform" class="fontDefault">platform</label>'+
                                    '<select name="platform" id="platform" class="selectStyle1">'+
                                        '<option value="Instagram">Instagram</option>'+
                                        '<option value="Facebook">Facebook</option>'+
                                        '<option value="twitter">Twitter</option>'+
                                    '</select>'+

                                    '<button class="preventOutline fontDefault" onclick="updateAccount(event)">Submit</button>'+
                            '</form>';
                    
                    // add template 
                $('#edit_part').html(template);

    }

    // -------------------


// ------------------ start buttons action ---------------------------

function saveAccount(){
        event.preventDefault();
        let formData = new FormData($('#add_account_from')[0]);


        $.ajax({
        url: 'addAccount',
        method: "POST",
        data:formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(res){  
            $('#add_account_form_error_area').css('display','none');
            $('#add_account_form_success_area').html('<strong>'+res+'</strong>');
            $('#add_account_form_success_area').css('display','block');
            // to get updated array of posts
            getAccounts();
        },
        error:function(res){
            $('#add_account_form_success_area').css('display','none');
            $('#add_account_form_error_area').html('');
                
            errorsList = [];
            if(res['responseJSON']['errors']['username'] != undefined){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['username'][0]+'</strong><br>');
            }
            if(res['responseJSON']['errors']['password'] != undefined ){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['password'][0]+'</strong><br>');

            }
            if(res['responseJSON']['errors']['platform'] != undefined){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['image'][0]+'</strong><br>');
            }

            $('#add_account_form_error_area').html(errorsList);
            $('#add_account_form_error_area').css('display','block');
        }
    });
           
}


function deleteAccount(id){
        if(confirm('are you sure') == true ){
            $.ajax({
                url: 'deleteAccount',
                method: "GET",
                data:{
                    id:id,
                },
                success: function(res){ 
                    // to get updated array of posts
                    getAccounts();
                }
            });
        }
    
}

function updateAccount(event){

    let formData = new FormData($('#update_account_form')[0]);
    event.preventDefault();

    $.ajax({
        url: 'updateAccount',
        method: "POST",
        data:formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(res){ 

            $('#update_account_form_error_area').css('display','none');
            $('#update_account_form_success_area').html('<strong>'+res+'</strong>');
            $('#update_account_form_success_area').css('display','block');
            // to get updated array of posts
            getAccounts();
        },
        error:function(res){

            $('#update_account_form_success_area').css('display','none');
            $('#update_account_form_error_area').html('');

            errorsList = [];
            if(res['responseJSON']['errors']['username'] != undefined){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['username'][0]+'</strong><br>');
            }
            if(res['responseJSON']['errors']['platform'] != undefined ){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['platform'][0]+'</strong><br>');

            }

            $('#update_account_form_error_area').html(errorsList);
            $('#update_account_form_error_area').css('display','block');

        }

    });

}





// ------------------- end buttons action ------------------------------------



</script>