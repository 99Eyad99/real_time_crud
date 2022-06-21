@extends('includes/master')
@section('content')

    <link rel="stylesheet" href="css/login.css">

    


    <form action="/" method="POST">
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <strong>{{ $error }}</strong><br/>
                @endforeach
            </div>
        @endif

        @isset($msg)
            <div class="alert alert-danger"> <strong>{{$msg}}</strong></div>
        @endisset  

     
        <h3 class="text-center">Login</h3>
        
        @csrf
        @method('POST')
        <div class="input-feild">
            <i class="fa-solid fa-passport" style="font-size: 20px; color:#747d8c;"></i>
            <input type="text" name="ID" id="ID" placeholder="ID">
        </div>

        <div class="input-feild">
            <i class="fa-solid fa-lock" style="font-size: 20px; color:#747d8c;"></i>
            <input type="password" name="password" id="password" placeholder="password">
        </div>

        <button class="btn">Login</button>
    </form>

@endsection

