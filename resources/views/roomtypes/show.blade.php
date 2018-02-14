@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>{{$roomType->name}}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
        	<div class="panel panel-primary">
        	    <div class="panel-heading">
        	    	Promo Rates
        	    </div>
        	    <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-room-rate">Add Room Rate</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Hours</td>
                                        <td>Price</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roomType->roomRates as $roomRate)
                                        <tr>
                                            <td>{{$roomRate->name}}</td>
                                            <td>{{$roomRate->hours}}</td>
                                            <td>PHP {{$roomRate->price}}</td>
                                            <td>
                                                <a href="/room-types/room-rates/{{$roomRate->id}}/edit" class="btn btn-sm btn-success inline">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>         
                        </div>
                    </div>
                   
		        </div>
		    </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Update Name
                </div>
                <div class="panel-body">
                    <form action="/room-types/{{$roomType->id}}" method="POST">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{$roomType->name}}" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.add-room-rate')
@endsection
