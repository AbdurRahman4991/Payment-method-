@extends('layouts.app')

@section('content')
<style>
    #cardImg{
        width:100%;
        height:300px;
    }
    #cardText{
        width:100%;
        height:auto;
        text-align:justify;
    }
</style>
<div class="container">
    <div class="row">
        @foreach($ProductList as $product)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{$product->title}}</div>
                <div class="card-body">
                    <img src="{{$product->image}}" alt="image" id="cardImg">
                    <p id='cardText'>{{$product->description}}</p>
                    <a href="{{route('productDetails',[$product->id])}}" class='btn btn-danger mt-2'>See more</a>
                    <a href="#" class='btn btn-success mt-2' style="float:right;">${{$product->price}}</a>
                </div>
            </div>
        </div>
        @endforeach        
    </div>
</div>

@endsection