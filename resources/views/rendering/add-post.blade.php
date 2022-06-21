<link rel="stylesheet" href="css/add-post.css">


<div class="content">
    <h1  class="text-center page-title">Manage posts</h1>


<button class="btn btn-primary add-post-btn" onclick="prompt()">Add new post <i class="fa-solid fa-plus"></i></button>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-light fixedTableHeader">
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Text</th>
            <th scope="col">image</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="postsDisplay">
        </tbody>
    </table>
</div>

</div>



<script>

// -------------------------------- start get posts -------------------------------------------------------
$(document).ready(function(){
    getPosts();
    
})

// get all posts 
var posts = '';
    function getPosts(){
        // make posts array empty to re-count and re-store posts in case of adding new posts
        posts = null;
        $.ajax({
            url: 'getPosts',
            method: "GET",
            'async': false,
            success: function(res){ 
                posts = res;                
                postDisplay();
            }
        });
    }
// -------------------------------- end get posts -------------------------------------------------------


// ------------------------------ start interface elements ----------------------------------------------
    function postDisplay(){

        $('#postsDisplay').html('');

        posts.forEach(p => {
            var template = '<tr>'+
                                '<td>'+p['title']+'</td>'+
                                '<td>'+p['text']+'</td>'+
                                '<td><img src="images/'+p['image']+'" alt="" style="width: 55px;"></td>'+
                                '<td>'+
                                    '<div class="control">'+
                                        '<button class="btn btn-danger" id="'+p["post_id"]+'" onclick="deletePost(this.id)"><i class="fa-solid fa-trash"></i></button>'+
                                        '<button class="btn btn-success" id="'+p["post_id"]+'" onclick="viewPost(this.id)"><i class="fa-regular fa-eye"></i></button>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>';

            $('#postsDisplay').append(template);

         });
         

    }

     
function prompt() {
        let text;
        const form = '  <div class="add-form-prompt">'+
                            '<div class="alert alert-danger" id="add_post_form_error_area" style="display:none;"></div>'+
                            '<div class="alert alert-success" id="add_post_form_success_area" style="display:none;"></div>'+
                            '<form action="addPost" method="POST" id="add_post_from" enctype="multipart/form-data">'+                                
                                '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                '<input type="hidden" name="_method" value="POST">'+

                                '<label for="title">Title</label>'+
                                '<input type="text" name="title" id="title" class="form-control" required>'+

                                '<label for="text">Text</label>'+
                                '<textarea name="text" id="text" class="form-control" cols="30" rows="10" required></textarea>'+

                                '<label for="img">image</label>'+
                                '<input type="file" name="image" id="img" class="form-control" required>'+

        
                                '<button class="submit-btn btn btn-success" onclick="savePost()">Save</button>'+
                                '<button class="cancel-btn" onclick="resetPrompt()">cancel</button>'+
                            '</form>'+
                        '</div>';
        // display
        $('main').prepend(form);
        $('.content').css('opacity','0.3');

    }

    function resetPrompt(){
        event.preventDefault();
        $('.add-form-prompt').remove();
        $('.content').css('opacity','1');
    }

    function resetView(){
        event.preventDefault();
        $('.view_edit_template').remove();
        $('.content').css('opacity','1');
    }



    function viewPost(id){

        let arr;
        posts.forEach( (e) => {
                if(e['post_id'] == id){
                    arr = e;
                }
            }
                    
        )


        const template = '<div class="view_edit_template">'+

                            '<div class="btn-control">'+
                                '<button class="close-btn preventOutline" onclick="resetView()">close <i class="fa-solid fa-rectangle-xmark"></i></button>'+
                                '<button class="edit-btn preventOutline" onclick="open_edit_form(); activate();">update information <i class="fa-solid fa-pen-to-square"></i></button>'+
                            '</div>'+

                            '<div class="container-fuild">'+
                                '<div class="row" style="width:100%;">'+

                                '<div class="col-md-6">'+
                                    '<div class="view">'+ 
                                        '<img id="output" src="images/'+arr['image']+'" alt="" class="responsive-img">'+
                                        ' <div class="info">'+
                                                    '<div class="title">'+
                                                        '<div class="subject">Title</div>'+
                                                        '<span id="titleTarget">'+arr['title']+'</span>'+
                                                    '</div>'+

                                                '<div class="text">'+
                                                    '<div class="subject">text</div>'+
                                                    '<span id="textTarget">'+arr['text']+'</span>'+
                                                '</div>'+
                                        '</div>'+

                                    '</div>'+
                                '</div>'+

                            '<div class="col-md-6">'+
                                        '<div class="edit" style="display:none">'+
                                            '<form id="update_post_from" action="updatePost" method="POST" enctype="multipart/form-data">'+

                                                '<div class="alert alert-danger" id="edit_post_form_error_area" style="display:none;"></div>'+
                                                '<div class="alert alert-success" id="edit_post_form_success_area" style="display:none;"></div>'+

                                                '<input type="hidden" name="_token" value="{{ csrf_token() }}">'+
                                                '<input type="hidden" name="_method" value="POST">'+
                                                '<input type="text" name="id"  value="'+arr['post_id']+'" hidden>'+


                                                '<div class="input-group">'+
                                                        '<label for="title" class="fontDefault">title</label>'+
                                                        '<input type="text" name="title" id="title" class="preventOutline" value="'+arr['title']+'" onkeyup="liveTitlePreview($(this).val())" required>'+
                                                '</div>'+
                                                '<div class="input-group">'+
                                                    ' <label for="text" class="fontDefault">Text</label>'+
                                                    ' <textarea name="text" id="text" cols="30" rows="10" class="preventOutline" onkeyup="liveTextPreview($(this).val())" required>'+arr['text']+'</textarea>'+
                                                '</div>'+
                                                '<div class="input-group">'+
                                                    '<label for="image" class="fontDefault">image</label>'+
                                                    '<input type="file" name="image" id="image" class="preventOutline"  onchange="liveImagePreview()">'+
                                                '</div>'+
                                    
                                                '<div class="btn-control">'+
                                                    '<button class="preventOutline fontDefault" onclick="updatePost(event)">submit</button>'+
                                                '</div>'+
                                            '</form>'+
                                        '</div>'+
                                    '</div>'+

                                '</div>'+
                            '</div>'+

                        '</div>';

        $('main').prepend(template);
        $('.content').css('opacity','0.3');

    }

    function open_edit_form(){

        $(this).hide();
        $('.view_edit_template .edit').slideDown();

    }

    function liveImagePreview(){
        $('#output').attr('src', URL.createObjectURL(event.target.files[0]));
    }

    function liveTitlePreview(val){
        $('#titleTarget').text(val);
    }

    function liveTextPreview(val){
        $('#textTarget').text(val);
    }
    /*

    function activate(class){
        swap = ['edit-btn','changeImage-btn'];
        console.log($(this).attr('class'));
        if(this.className == 'edit-btn'){
            $('.edit-btn').addClass('active');
            $('.changeImage-btn').removeClass('active');
        }else{
            $('.changeImage-btn').addClass('active');
            $('.edit-btn').removeClass('active');
        }
    }
    */


// ------------------------------ end interface elements ----------------------------------------------


// ------------------------------ start button actions ---------------------------------------------
    function savePost(){
        event.preventDefault();
        let formData = new FormData($('#add_post_from')[0]);


        $.ajax({
        url: 'addPost',
        method: "POST",
        data:formData,
        cache: false,
        processData: false,
        contentType: false,
        success: function(res){  
            $('#add_post_form_error_area').css('display','none');
            $('#add_post_form_success_area').html('<strong>'+res+'</strong>')
            $('#add_post_form_success_area').css('display','block');
            // to get updated array of posts
            getPosts();

        },
        error:function(res){
            $('#add_post_form_success_area').css('display','none');
            $('#add_post_form_error_area').html('');
                
            errorsList = [];
            if(res['responseJSON']['errors']['title'] != undefined){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['title'][0]+'</strong><br>');
            }
            if(res['responseJSON']['errors']['text'] != undefined ){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['text'][0]+'</strong><br>');

            }
            if(res['responseJSON']['errors']['image'] != undefined){
                    errorsList.push('<strong>'+res['responseJSON']['errors']['image'][0]+'</strong><br>');
            }

            $('#add_post_form_error_area').html(errorsList);
            $('#add_post_form_error_area').css('display','block');
        }
    });
           
    }

    function updatePost(event){

        let formData = new FormData($('#update_post_from')[0]);
        event.preventDefault();

        $.ajax({
            url: 'updatePost',
            method: "POST",
            data:formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){ 
                $("#edit_post_form_success_area").html('<strong>'+res+'</strong>');
                $("#edit_post_form_success_area").css('display','block');
                // to get updated array of posts
                getPosts();
            },
            error: function(res){
                $("#edit_post_form_error_area").html('<strong>'+res+'</strong>');
                $("#edit_post_form_error_area").css('display','block');
                // to get updated array of posts
            }

        });

    }

    function deletePost(id){
        if(confirm('are you sure') == true ){
            $.ajax({
                url: 'deletePost',
                method: "GET",
                data:{
                    id:id,
                },
                success: function(res){ 
                    // to get updated array of posts
                    getPosts();
                }
            });
        }
    
    }


// ------------------------------ end button actions ---------------------------------------------




</script>



