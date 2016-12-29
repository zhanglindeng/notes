```html
<!doctype html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bootstrap</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style>
        .main {
            margin-top: 20px;
        }

        nav.nav {
            height: 60px;
            padding: 0;
            margin: 0;
            background-color: red;
            display: flex;
        }

        .links-left a,
        .login-register a {
            text-decoration: none;
            display: inline-block;
            line-height: 60px;
            padding: 0 20px;
            color: #ffffff;
        }

        .left {
            flex: 1;
            display: flex;
            background-color: #f0ad4e;
        }

        .right {
            background-color: #2a88bd;
        }

        nav.nav div.links-left {
            display: flex;
            background-color: green;
        }

        .login-register {
            display: flex;
        }

        .links-left a:hover, .login-register a:hover {
            background-color: #000;
        }

        /*nav2*/
        .nav2 {
            height: 60px;
            background-color: rgb(100, 100, 0);
            margin-top: 20px;
            
            display: flex;
        }

        .nav2 .left2 {
            /*background-color: #1b6d85;*/
            padding-left: 30px;
        }

        .nav2 .right2 {
            /*background-color: #f0ad4e;*/
            flex: 1;

            display: flex;
            justify-content: flex-end;
        }

        .nav2 .right2 .links {
            display: flex;
            /*background-color: #0d3625;*/
        }

        .nav2 .right2 .user {
            display: flex;
            /*background-color: #3c763d;*/
        }

        .links a, .user a {
            text-decoration: none;
            display: inline-block;
            line-height: 60px;
            padding: 0 20px;
            color: #ffffff;
            font-size: 2rem;
        }

        .links a:hover, .user a:hover {
            background-color: rgb(80, 80, 0);
        }
    </style>
</head>
<body>
<div class="container main">
    <nav class="nav">
        <div class="left">
            <div class="logo">
                <a href="{{url('/')}}">
                    <img src="{{asset('image/dog.jpeg')}}" height="60">
                </a>
            </div>
            <div class="links-left">
                <div><a href="#">link</a></div>
                <div><a href="#">link</a></div>
                <div><a href="#">link</a></div>
                <div><a href="#">link</a></div>
                <div><a href="#">link</a></div>
            </div>
        </div>
        {{--<div class="links-right">--}}
        {{--<div><a href="#">link</a></div>--}}
        {{--<div><a href="#">link</a></div>--}}
        {{--<div><a href="#">link</a></div>--}}
        {{--<div><a href="#">link</a></div>--}}
        {{--<div><a href="#">link</a></div>--}}
        {{--</div>--}}
        <div class="right">
            <div class="login-register">
                <div><a href="#">login</a></div>
                <div><a href="#">register</a></div>
            </div>
        </div>
    </nav>

</div>
<div class="nav2">
    <div class="left2">
        <div class="logo">
            <a href="{{url('/')}}">
                <img src="{{asset('image/dog.jpeg')}}" height="60">
            </a>
        </div>
    </div>
    <div class="right2">
        <div class="links">
            <div><a href="#">link</a></div>
            <div><a href="#">link</a></div>
            <div><a href="#">link</a></div>
            <div><a href="#">link</a></div>
            <div><a href="#">link</a></div>
        </div>
        <div class="user">
            <div><a href="#">register</a></div>
            <div><a href="#">login</a></div>
        </div>
    </div>
</div>


<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
```
