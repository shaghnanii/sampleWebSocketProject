@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Notifications') }}</div>

                <div class="card-body" id="mynotifications">

                    <div class="alert alert-success">Some Notification Here</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    Echo.private('App.Models.User.1')
        .notification((notification) => {
            var array = [];
            console.log(notification.message);
            array.push(notification.message);
            var content = document.getElementById("mynotifications");

            for (var i = 0; i < array.length; i++) {
                content.innerHTML += '<div class="alert alert-success">' + array[i] + '</div>';
            }

        });

</script>
@endsection
