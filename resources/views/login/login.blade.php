<!DOCTYPE html>
<html>
<head>
    <title> Reels Pro  Panel LogIn</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

     <link rel="stylesheet" href="{{asset('theme/vendor/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('theme/styles/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('theme/styles/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('theme/styles/animate.css')}}">
    <link rel="stylesheet" href="{{asset('theme/styles/sublime.css')}}">
    <style type="text/css">
        .box{
            width:600px;
            margin:0 auto;

        }
    </style>
</head>

    <body class="bg-primary">

        <div class="cover" style="background-image: url({{asset('theme/images/cover1.jpg')}})"></div>
        {{-- <div class="cover" style="background-image: url({{asset('images/download.png')}})"></div> --}}
<br />
<div class="container box">
    <h3 align="center" style="color: black;
    font-size: 23px;
    font-weight: 700;">Reels Pro  Panel LogIn</h3><br />


    @if ($message = Session::get('error'))


        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>




    @endif

    @if (count($errors) > 0)



        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>




        
    @endif

    <form method="post" action="{{ url('/admin/checklogin') }}">
        {{ csrf_field() }}
        <input type="hidden" name="my_timezone" id="my_timezone">
        <div class="form-group">
            <label style="color: black;
            font-size: 17px;
            font-weight: 700;">Enter Email</label>
            <input type="email" name="email" class="form-control"  />
        </div>
        <div class="form-group">
            <label  style="color: black;
            font-size: 17px;
            font-weight: 700;">Enter Password</label>
            <input type="password" name="password" class="form-control" />
        </div>
        <div class="form-group">
            <input type="submit" name="login" class="btn btn-primary" value="Login" />
        </div>
    </form>
</div>
</body>
<script>
    $(function(){
        var gmt_offset = new Date().getTimezoneOffset();
        console.log(gmt_offset);
        $('#my_timezone').val(gmt_offset);
    })
</script>
</html>
