<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Crud</title>

    {{-- bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <div class="navbar-header">
                <a href="{{ url('post.index')}}" class="navbar-brand">DaMjAn</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
{{-- ajax Form Add  --}}
<script type="text/javascript">

    $(document).on('click','.create-modal', function(){
        $('#create').modal('show');
        $('.form-horizontal').show();
        $('.modal-title').text('Add Post');

    });

    // function Add(Save) -> when add button is clicked an ajax call is made to the controller for adding a Post
    $('#add').click(function(){
        $.ajax({
            type : "post",
            url: 'addPost',
            data: {
                '_token': $('input[name=_token]').val(),
                'title': $('input[name=title]').val(),
                'body': $('input[name=body]').val(),
            },
            success: function(data){
                if((data.erors))
                {
                    $('.error').removeClass('hidden');
                    $('.error').text(data.errors.title);
                    $('.error').text(data.errors.body);
                }
                else
                {
                   $('.error').remove();
                   $('#table').append("<tr class='post" + data.id + "'>"+
                   "<td>" + data.id + "</td>" + 
                   "<td>" + data.title + "</td>" + 
                   "<td>" + data.body + "</td>" + 
                   "<td>" + data.created_at + "</td>" +  //ovdje mozemo da dodamo i onda tri dugmeta eto bzvz
                   "</tr>"
                   ); 
                }
            },
        });
        $('#title').val('');
        $('#body').val('');
    });

// Show function

$(document).on('click', '.show-modal', function(){
    $('#show').modal('show');
    $('.modal-title').text('show-post');
});

//function Edit Post 
//modal sa id i title, bodijem koji se mogu editovati i updatovati klikom na dugme. 
$(document).on('click', '.edit-modal', function(){
    $('#footer-action-button').text("Update Post");
    $('#btn-check-ico').removeAttr("hidden");
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('edit');
    $('.modal-title').text('Post Edit');
    $('.deleteContent').hide();
    $('.form-horizontal').show();
    $('#fid').val($(this).data('id'));
    $('#t').val($(this).data('title'));
    $('#b').val($(this).data('body'));
    $('#myModal').modal('show');
});

//nakon sto se klikne na dugme update poziva se sledeca logika koja updateuje podatke
$('.modal-footer').on('click', '.edit', function(){
        $.ajax({
            type: "post",
            url: 'editPost',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#fid').val(),
                'title': $('#t').val(),
                'body': $('#b').val(),
            },
            success: function(data){
                   $('.post' + data.id).replaceWith(" " + 
                   "<tr class='post" + data.id + "'>"+
                   "<td>" + data.id + "</td>" + 
                   "<td>" + data.title + "</td>" + 
                   "<td>" + data.body + "</td>" + 
                   "<td>" + data.created_at + "</td>" +  //ovdje mozemo da dodamo i onda tri dugmeta eto bzvz
                   "</tr>"
                   ); 
            },
        });
    });

// form Delete function

$(document).on('click','.delete-modal', function(){
    $('#footer-action-button').text("Delete");
    $('#btn-trash-ico').removeAttr("hidden");
    $('.actionBtn').addClass('btn-success');
    $('.actionBtn').removeClass('btn-danger');
    $('.actionBtn').addClass('delete');
    $('.modal-title').text('Delete Post');
    $('.id').text($(this).data('id'));
    $('.deleteContent').show();
    $('.form-horizontal').hide();
    $('.title').html($(this).data('title'));
    $('#myModal').modal('show');
});

// i onda delete operacija koristeci ajax
$('.modal-footer').on('click','.delete', function(){
    $.ajax({
        type: 'post',
        url: 'deletePost',
        data: {
            '_token': $('input[name=_token]').val(),
            'id' : $('.id').text()
        },
        success: function(data){                        //ynaci ako prodje delete request izbrisi i sa fronta
            $('.post' + $('.id').text()).remove();
        }
    });
});


</script>
</body>
</html>