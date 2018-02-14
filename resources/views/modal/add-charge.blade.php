<!-- Modal -->
<div id="add-charge" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Charge</h4>
            </div>
            <div class="modal-body">
                <form action="/charges" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="guest_id" value="{{$guest->id}}">

                    <div class="form-group">
                        <label for="item_id">Charge Name:</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                        <label for="price">Price: </label>
                        <input type="number" class="form-control" name="price" id="price" required>
                        @if ($errors->has('price'))
                            <span class="help-block">
                                <strong>{{ $errors->first('price') }}</strong>
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