<form action="/guest/check-out/{{$guestId}}" method="POST">
	{{csrf_field()}}
	<button type="submit" class="btn {{isset($button_size) ? $button_size : 'btn-sm'}} btn-danger">Check Out</button>
</form>