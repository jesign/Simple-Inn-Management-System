<!-- Modal -->
<div id="add-room-rate" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Room Rate</h4>
            </div>
            <div class="modal-body">
                <form action="/room-types/room-rates/add" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="room_type_id" value="{{$roomType->id}}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="hours">Hours</label>
                        <input type="number" class="form-control" name="hours" id="hours">
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" name="price" id="price">
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