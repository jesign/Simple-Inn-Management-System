@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@if(session()->has('message'))
		    <div class="alert alert-info">
		        <strong>{{session('message')}}</strong>
		    </div>
		@endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
	</div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                	Room Types
                </div>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<td>Name</td>
                				<td>Action</td>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($roomTypes as $roomType)
	                			<tr>
	                				<td>{{$roomType->name}}</td>
	                				<td>
            							<a href="/room-types/{{$roomType->id}}" class="btn btn-sm btn-primary inline">View</a>
	                					{{-- <form action="/room-types/{{$roomType->id}}/delete" method="POST" class="inline">
                                            {{csrf_field()}}
		                					<button type="submit" class="btn btn-sm btn-danger inline">Delete</button>
                						</form> --}}
	                				</td>
	                			</tr>
                			@endforeach
                		</tbody>
                	</table>
                </div>
			</div>        	
        </div>
        <div class="col-md-4">
        	<div class="panel panel-primary">
        	    <div class="panel-heading">
        	    	Add Room Type
        	    </div>
        	    <div class="panel-body">
		        	<form action="/room-types" method="POST">
		        		{{csrf_field()}}
		        		<div class="form-group">
		        		    <label for="name">Name</label>
		        			<input type="text" name="name" class="form-control" required>
		        		</div>
                        <div class="form-group">
                        	<button type="submit" class="form-control btn btn-primary">Add</button>
                        </div>
		        	</form>
		        </div>
		    </div>
        </div>
    </div>
</div>
@endsection
