@extends('layouts.app')

@section('content')
<guests-component inline-template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-guest">Add Guest</button>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <form action="/guests" class="form pull-right">
                    <h4 class="inline">Date:</h4>
                    <input name="date" type="date" class="short-date-field form-control inline-important" v-model="date">
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">    
                @if(session()->has('message'))
                    <div class="alert alert-info">
                        <strong>{{session('message')}}</strong>
                    </div>
                @endif
            
                <div class="panel panel-default">
                    <div class="panel-heading">Guest's Check in</div>

                    <div class="panel-body">
                        <table class="table table-responsive table-striped">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Guest Name</th>
                                    <th>Check-In Time</th>
                                    <th>Check-out Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="guest in guests" :class="{warning : isTimeout(guest.check_out), danger : isCheckout(guest.status)}">   
                                    <td><a :href="'guests/' + guest.id">@{{ guest.room_number }}</a></td>
                                    <td>@{{ guest.room_type.name }}</td>
                                    <td>@{{ guest.name }}</td>
                                    <td>@{{ guest.checkin_time }}</td>
                                    <td>@{{ guest.checkout_time }}</td>
                                    <td>@{{ guest.status }}</td>
                                    <td>
                                        <a :href="'guests/' + guest.id" class="btn inline btn-success btn-sm">Manage</a>
                                        {{-- <form action="'guests/' + guest.id + '/delete'" method="POST" class="inline">
                                            <button type="submit" href="guests/@{{guest.id}}" class="btn inline btn-danger btn-sm">Delete</button>
                                        </form> --}}
                                        <a href="#" class="btn btn inline btn-danger btn-sm" @click="checkout(guest.id)">Checkout</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</guests-component>
@include('modal.add-guest')
@endsection
