@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        @if(session()->has('message'))
            <div class="alert alert-info">
                <strong>{{session('message')}}</strong>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading panel">
                            Billing Information
                        </div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td><strong>Room Rate: </strong></td>
                                        <td>PHP {{$guest->roomRate->price}}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Orders: </strong></td>
                                        <td>PHP {{ $orderTotalPrice }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Charges: </strong></td>
                                        <td>PHP {{ $chargeTotalPrice }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h3> <strong>Total Bill: PHP {{$guest->total_bill}}</strong></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if(session()->has('order_error'))
                        <div class="alert alert-danger">
                            <strong>{{session('order_error')}}</strong>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{-- Orders Panel  --}}
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Orders
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-order">Add Order</button>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Item Price</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{$order->item->name}}</td>
                                                <td>PHP {{$order->item->price}}</td>
                                                <td>{{$order->quantity}}</td>
                                                <td>PHP {{$order->total_price}}</td>
                                                <td>
                                                    <form action="/orders/{{$order->id}}/delete" method="POST">
                                                        {{csrf_field()}}
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-11">
                                    <h4 class="pull-right"><strong>Total Price: PHP {{$orderTotalPrice}}</strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Charges Panel --}}
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Other Charges
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-charge">Add Charge</button>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Charge Name</th>
                                                <th>Charge Price</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($charges as $charge)
                                                <tr>
                                                    <td>{{$charge->name}}</td>
                                                    <td>PHP {{$charge->price}}</td>
                                                    <td>
                                                        <form action="/charges/{{$charge->id}}/delete" method="POST">
                                                            {{csrf_field()}}
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-11">
                                    <h4 class="pull-right"><strong>Total Price: PHP {{$chargeTotalPrice}}</strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Update Guest Form --}}
        <div class="col-md-4">
            @if(session()->has('updated'))
            <div class="alert alert-success">
                <strong>{{session('updated')}}</strong>
            </div>
            @endif
            <div class="panel panel-success">
                <div class="panel-heading">
                    Update Guest
                </div>
                <div class="panel-body">
                    
                    <form action="/guests/{{$guest->id}}" method="POST">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="form-group{{ $errors->has('room_number') ? ' has-error' : '' }}">
                            <label for="room_number">Room Number:</label>
                            <input type="text" class="form-control" name="room_number" value="{{$guest->room_number}}" id="room_number" required>
                            @if ($errors->has('room_number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('room_number') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="room_type">Room Type:</label>
                            <select class="form-control" id="room_type" name="room_type" value="{{$guest->room_type}}">
                                @foreach(\App\RoomType::all() as $roomType)
                                <option value="{{$roomType->id}}">{{$roomType->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Guest Name (Optional):</label>
                            <input type="text" class="form-control" name="name" value="{{$guest->name}}" id="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Guest Contact (Optional):</label>
                            <input type="text" class="form-control" name="phone" value="{{$guest->phone}}" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="check_in">Check In:</label>
                            <input type="datetime-local" class="form-control" name="check_in" value="{{$guest->getCheckIn()}}" id="check_in">
                        </div>
                        <div class="form-group">
                            <label for="check_out">Check Out:</label>
                            <input type="datetime-local" class="form-control" name="check_out" value="{{$guest->getCheckOut()}}" id="check_out">
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.add-order')
@include('modal.add-charge')
@endsection