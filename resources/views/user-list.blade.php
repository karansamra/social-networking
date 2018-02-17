@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if($data)
                    @foreach ($data as $user)
                        <div class="row m-2">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-block p-2">
                                        <h3 class="card-title">{{$user['name']}}</h3>
                                        <p class="card-text">{{$user['email']}}</p>
                                        @if($user['followed'] == 0)
                                            <a href="javascript:void(0)" onclick = "user.follow(this, {{$user['id']}}, {{$user['myId']}})" class="btn btn-primary">Follow</a>
                                        @else
                                            <a href="javascript:void(0)" onclick = "" class="btn btn-dark disabled">Following</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row m-2">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block p-2">
                                    <h3 class="card-title">No other users exist.</h3>
                                    <p class="card-text">This page lists all the users except you.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
@endsection