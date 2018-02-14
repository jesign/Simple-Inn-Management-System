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
                	Inventories
                </div>
                <div class="panel-body">
                	<table class="table">
                		<thead>
                			<tr>
                				<td>Inventory Name</td>
                				<td>Quantity</td>
                				<td>Action</td>
                			</tr>
                		</thead>
                		<tbody>
                			@foreach($inventory as $item)
	                			<tr>
	                				<td>{{$item->item->name}}</td>
	                				<td>{{$item->quantity}}</td>
	                				<td>
            							<a href="/inventory/{{$item->id}}" class="btn btn-sm btn-success inline">Edit</a>
	                					{{-- <form action="/inventorys/{{$inventory->id}}/delete" method="POST" class="inline">
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
        	    	Add inventory
        	    </div>
        	    <div class="panel-body">
		        	<form action="/inventories" method="POST">
		        		{{csrf_field()}}
                        <div class="form-group">
                            <label for="item_id">Item</label>
                            <select class="form-control" id="item_id" name="item_id">
                                @foreach(\App\Item::all() as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
		        		<div class="form-group">
                            <label for="quantity">Quantity</label>
		        			<input type="number" name="quantity" class="form-control" required>
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
