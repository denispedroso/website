<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DTP Motoshop') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="app"></div>
    <div id="napp">
    <h1> New Users</h1>

    <ul>
        <li v-for="user in users"> @{{ user }}</li>
    </ul>
    </div>


    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        var socket = io.connect('http://192.168.10.10:3000');

        new Vue({
            el: '#napp',

            data: {
                users: []
            },

            mounted: function () {
                socket.on('test-channel:App\\Events\\UserSignedUp', function (data) {
                    //console.log(data);
                    this.users.push(data.username);
                }.bind(this));
            } 
        })
    
    </script>
</body>
</html>