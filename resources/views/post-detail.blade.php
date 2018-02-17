@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{--This Div holds the list of Posts of this user.--}}
                <div id="postHolder">
                    <div id = "'+data.data[i].postId+'" class="card card-posts-list mt-4">
                        <div class="card-header">
                            <span class="float-left">{{$data[0]["nameOfUser"]}}</span>
                            <span class="float-right">{{$data[0]["postsCreatedAt"]}}</span>
                            </div>
                            <div class="card-body" id = "listOfPosts">
                                <div class="container">
                                    @if ($data[0]["postTxt"] != null && $data[0]["postTxt"] != "" )
                                        <p class="lead">{{$data[0]["postTxt"]}}</p>
                                    @endif
                                    </div>
                                @if ($data[0]["imagePath"] != null && $data[0]["imagePath"] != "" ) {
                                <img src="{{$data[0]["imagePath"]}}" class="img-fluid" alt="Responsive image"/>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection