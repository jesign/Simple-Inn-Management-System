@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@if(session()->has('message'))
		    <div class="alert alert-info">
		        <strong>{{session('message')}}</strong>
		    </div>
		@endif
	</div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                	Items
                </div>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<td>Name</td>
                				<td>Price</td>
                				<td>Action</td>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($items as $item)
	                			<tr>
	                				<td>{{$item->name}}</td>
	                				<td>PHP {{$item->price}}</td>
	                				<td>
            							<a href="/items/{{$item->id}}" class="btn btn-sm btn-success inline">Edit</a>
	                					{{-- <form action="/items/{{$item->id}}/delete" method="POST" class="inline">
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
        	    	Add Item
        	    </div>
        	    <div class="panel-body">
		        	<form action="/items" method="POST">
		        		{{csrf_field()}}
		        		<div class="form-group">
		        		    <label for="name">Name</label>
		        			<input type="text" name="name" class="form-control" required>
		        		</div>
		        		<div class="form-group">
                            <label for="price">Price</label>
		        			<input type="number" name="price" class="form-control" required>
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
