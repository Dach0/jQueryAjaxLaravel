@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Simple Laravel CRUD Ajax</h1>
    </div>
</div>

<div class="row">
    <div class="table table-responsive">
        <table class="table table-bordered" id="table">
            <tr>
                <th width="150px">No</th>
                <th>Title</th>
                <th>Body</th>
                <th>Created At</th>
                <th class="text-center" width="150px">
                    <a href="#" class="create-modal btn btn-success btn-sm"> 
                        <i class="fas fa-plus"></i>
                    </a>
                </th>
            </tr>
            {{ csrf_field() }}
            <?php $no=1;?>
            @foreach ($post as $key => $value)
            <tr class="post{{$value->id}}">
                <td>{{ $no++ }}</td>
                <td>{{ $value->title }}</td>
                <td>{{ $value->body }}</td>
                <td>{{ $value->created_at }}</td>
                <td>
                <a href="#" class="show-modal btn btn-info btn-sm" data-id="{{ $value->id }}" data-title="{{ $value->title }}" data-body="{{ $value->body}}" >
                <i class="fa fa-eye"></i></a>
                <a href="#" class="edit-modal btn btn-warning btn-sm" data-id="{{ $value->id }}" data-title="{{ $value->title }}" data-body="{{ $value->body}}" >
                <i class="fas fa-pencil-alt"></i></a>
                <a href="#" class="delete-modal btn btn-danger btn-sm" data-id="{{ $value->id }}" data-title="{{ $value->title }}" data-body="{{ $value->body}}" >
                <i class="fas fa-trash-alt"></i></a>
                </td>
                </tr>
            @endforeach
        </table>
    </div>
    {{ $post->links() }}
</div>

{{-- form Create Post --}}

<div class="modal fade" id="create" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form-horizontal" role="form">
                    <div class="form-group row add">
                        <label for="title" class="control-label col-sm-2">Title:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Your Title Here" required>
                            <p class="error text-center alert alert-danger" hidden></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="body" class="control-label col-sm-2">Body:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="body" name="body" placeholder="Your Body Here" required>
                            <p class="error text-center alert alert-danger" hidden></p>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="submit" id="add">
                        <span><i class="fas fa-plus"></i></span> Save Post
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span><i class="fas fa-remove"></i></span>Close
                    </button>
                </div>
        </div>
    </div>
</div>

{{-- Form Show POST --}}

<div id="show" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <h4 class="modal-title"></h4>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Title: povucem iz posta</p>
                <p>Body: povucem iz posta isto</p>
                {{-- <p>Title: {{$post->title}}</p> --}}
                {{-- <p>Body: {{$post->body}}</p> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Form to edit and delete post --}}

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" class="form-horizontal" role="modal" >
                    <div class="form-group">
                        <label for="id" class="control-label col-sm-2">ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id='fid' disabled>  {{-- ovo "fid" je ajax f-ja --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="t" > {{-- ovo "t" je title ajax f-je --}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="body">Body</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="b" > {{-- ovo "b" je body ajax f-je --}}
                        </div>
                    </div>
                </form>
                {{-- Form delete post --}}
                <div class="deleteContent">
                    Are you sure you want to delete <span class="title"></span>?
                    <span class="id" hidden></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn actionBtn" data-dismiss="modal">
                <i id='btn-check-ico' class='fas fa-check' hidden></i>
                <i id='btn-trash-ico' class="fas fa-trash-alt" hidden></i>
                <span id="footer-action-button"></span>
                </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">
                    <span></span>Close
                </button>
            </div>
        </div>
    </div>
</div>

@endsection