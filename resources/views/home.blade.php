@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Compose a Post</div>

                <div class="card-body postComposerCard">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form id = "composePostForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="postText">Write Something to make a Post</label>
                            <textarea name = "postText" class="form-control" id="postText" rows="3" maxlength="5000"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="postImageFile">Select an Image for your Post.</label>
                            <input type="file" class="form-control-file" id="postImageFile" name = "postImage">
                        </div>
                        <div class="clearfix">
                            <br>
                            <button type="button" onclick="post.save();" class="btn btn-primary float-right">Post</button>
                        </div>
                    </form>
                </div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
