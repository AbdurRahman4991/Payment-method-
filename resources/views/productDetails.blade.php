@extends('layouts.app')

@section('content')

@php 
$auth = Auth::user()->id;
@endphp
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="{{$ProductDetail->image}}" style="width:100%; height:auto;" alt="images">
        </div>
        <div class="col-md-6">
            <h1>{{$ProductDetail->title}}</h1>
            <p style="text-align:justify">{{$ProductDetail->description}}</p>
            <ul>
                <li>color: Black</li>
                <li>Size: L, M, Xl </li>
                <li>Meterial: Cotton</li>            
            </ul>
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <form action="{{route('stripeCheckOut')}}" method="get" >
                        <input type="hidden" name='id' value="{{$ProductDetail->id}}">
                        <input type="hidden" name='userId' value="{{$auth}}">
                        <input type="number" name='quantity'  placeholder="type your product quantity"  class="form-control">

                        <button class='btn btn-success mt-2'>Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection