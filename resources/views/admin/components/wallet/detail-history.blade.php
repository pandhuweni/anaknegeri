<div class="row">
	<div class="col-md-4">
		<img class="img-thumbnail" @if($deposit->image !=null) src="{{ asset('img/confirms/')}}/{{ $deposit->image }}" @else src="{{ asset('img/bg-primary.png' )}}"  @endif >
	</div>
	<div class="col-md-8">
		<table class="table table-bordered table-striped">
			<thead class="thead-inverse">
				<tr>
					<th>ID</th>
					<th>{{ $deposit->id }}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Owner</td>
					<td>{{ $deposit->wallet->user->name }}</td>
				</tr>
				<tr>
					<td>Status</td>
					<td>{{ $deposit->status }}</td>
				</tr>
				<tr>
					<td>Token</td>
					<td><?php echo substr($deposit->token, 0, 32) ?>...</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>