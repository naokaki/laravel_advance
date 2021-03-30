@extends('layouts.app')

@section('content')

    <div class="center jumbotron bg-warning">

        <div class="text-center text-white">
            <h1>YouTubeまとめ × SNS</h1>
        </div>

    </div>
    
    <div class="text-right">
            
        @if(Auth::check())
            {{Auth::user()->name}}
        @endif
            
    </div>

    <h3>退会確認</h3>
    <div class="row mt-5 mb-5">
        <div class="col-sm-6">
            <div class="mb-2">
                本当に退会しますか？この操作は取り消しできません。
            </div>
            <!--{!! Form::open(["route" => ["deleteUser", Auth::user()->id], "method"=>"delete"]) !!}-->
            <!--    {!! Form::submit("退会する？", ["class" => "button btn btn-danger mt-2"]) !!}-->
            <!--{!! Form::close() !!}-->
            
             {!! link_to_route('deleteUser','退会する',['id'=>Auth::id()],['class'=>'button btn btn-danger mt-2']) !!}
                
        </div>
    </div>
    
    <div class="row mt-5 mb-5">
        <div class="col-sm-6">
            {!! link_to_route('users.show','戻る',['id'=>Auth::id()],['class'=>'button btn btn-primary mt-2']) !!}
        </div>
    </div>


@endsection