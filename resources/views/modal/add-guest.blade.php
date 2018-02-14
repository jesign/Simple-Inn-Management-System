<!-- Modal -->
<div id="add-guest" class="modal fade" role="dialog">
    <add-guest-component inline-template room-types-json="{{$roomTypes}}">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Guest</h4>
                </div>
                <div class="modal-body">
                    <form action="/guests" method="POST">
                        {{csrf_field()}}
                        <div class="form-group{{ $errors->has('room_number') ? ' has-error' : '' }}">
                            <label for="room_number">Room Number:</label>
                            <input type="text" class="form-control" name="room_number" id="room_number" required>
                            @if ($errors->has('room_number'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('room_number') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="room_type">Room Type</label>
                            <select class="form-control" id="room_type" name="room_type" v-model="roomType">
                                <option v-for="roomType in roomTypes" :value="roomType.id">@{{ roomType.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room_rate_id">Promo</label>
                            <select class="form-control" id="room_rate_id" name="room_rate_id" v-model="roomRate">
                                <option v-for="roomRate in roomRates" :value="roomRate.id">@{{ roomRate.name }} </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Guest Name (Optional):</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="phone">Guest Contact (Optional):</label>
                            <input type="text" class="form-control" name="phone" id="phone">
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-default pull-right">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </add-guest-component>
</div>