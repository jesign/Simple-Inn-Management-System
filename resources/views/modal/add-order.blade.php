<!-- Modal -->
<div id="add-order" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Guest</h4>
            </div>
            <div class="modal-body">
                <form action="/orders" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="guest_id" value="{{$guest->id}}">

                    <div class="form-group">
                        <label for="item_id">Item:</label>
                        <select class="form-control" id="item_id" name="item_id">
                            @foreach(\App\Item::all() as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group{{ $errors->has('quantity') ? ' has-error' : '' }}">
                        <label for="quantity">Quantity: </label>
                        <input type="number" class="form-control" name="quantity" id="quantity" required>
                        @if ($errors->has('quantity'))
                            <span class="help-block">
                                <strong>{{ $errors->first('quantity') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-default pull-right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>