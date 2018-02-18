@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if($data)
                    @foreach ($data as $notif)
                        <div class="row m-2">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-block p-2"
                                    @if($notif['notificationsRead'] == 0)
                                    style = "background-color: #fffd9b"
                                    @endif
                                    >
                                        <h3 class="card-title">{{$notif['txt']}}</h3>
                                        @if($notif['postTxt'] != "")
                                        <p class="card-text">{{$notif['postTxt']}}</p>
                                        @endif
                                        <a href="javascript:void(0)" onclick = "notification.markRead({{$notif['notificationsId']}}, {{$notif['notificationsPostId']}})" class="btn btn-primary">Show</a>
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
                                    <h3 class="card-title">Right now, you have no notifications.</h3>
                                    <p class="card-text">You will see the notifications for the posts made by users who you are following.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
@endsection