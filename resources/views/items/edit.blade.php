@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
        	<div class="panel panel-primary">
        	    <div class="panel-heading">
        	    	Edit Item
        	    </div>
        	    <div class="panel-body">
		        	<form action="/items/{{$item->id}}" method="POST">
		        		{{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT">
		        		<div class="form-group">
		        		    <label for="name">Name</label>
		        			<input type="text" name="name" class="form-control" value="{{$item->name}}" required>
		        		</div>
		        		<div class="form-group">
                            <label for="price">Price</label>
		        			<input type="number" name="price" class="form-control" value="{{$item->price}}" required>
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
@endsection
