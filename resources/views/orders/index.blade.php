@extends('layouts.default_module')
@section('module_name')
Orders
@stop
{{-- @section('add_btn') --}}

{{-- {!! Form::open(['method' => 'get', 'route' => ['orders.create'], 'files'=>true]) !!} --}}
{{-- <span>{!! Form::submit('Add', ['class' => 'btn btn-success pull-right']) !!}</span> --}}
{{-- {!! Form::close() !!} --}}
{{-- @stop --}}

@section('table-properties')
width="400px" style="table-layout:fixed;"
@endsection


<style>
	td {
		white-space: nowrap;
		overflow: hidden;
		width: 30px;
		height: 30px;
		text-overflow: ellipsis;
	}
</style>
@section('table')


<thead>
	<tr>


        <th> User</th>
        <th> Influencer</th>
        <th> Number Of Reels</th>
        <th> Amount</th>
        <th> Status</th>
	</tr>
</thead>
<tbody>



    @foreach($orders as $c)




		<td >{!! ucwords($c->user->name ) !!} </td>
		<td >{!! ucwords($c->influencer->user->name ) !!} </td>
		<td >{!! $c->number_reels  !!} </td>
		<td >{!! $c->amount  !!} </td>
		<td >{!! ucwords($c->status)  !!} </td>
		{{-- <td >{!!ucwords($c->description) !!}</td> --}}
        <?php if (!$c->avatar) {
			$c->avatar = asset('images/logo.png');
			}

	    ?>


	   {{-- <td><img width="100px" src="{!! 	$c->avatar  !!}" class="show-product-img imgshow"></td> --}}






        </td>
		{{-- <td> --}}
    {{-- <a href="{{ route('orders.edit', ['id' => $c->id]) }}" class="badge bg-info">Edit</a> --}}
{{-- </td> --}}


{{-- 
		<td>{!! Form::open(['method' => 'POST', 'route' => ['orders.delete', $c->id]]) !!}
			<a href="" data-toggle="modal" name="activate_delete" data-target=".delete" modal_heading="Alert" modal_msg="Do you want to delete?">
				<span class="badge bg-info btn-primary ">
					{!! $c->deleted_at?'Activate':'Delete' !!}</span></a>
			{!! Form::close() !!}
		</td> --}}


	</tr>
	@endforeach


</tbody>
@section('pagination')
<span class="pagination pagination-md pull-right">{!! $orders->render() !!}</span>
<div class="col-md-3 pull-left">
	<div class="form-group text-center">
		<div>
			{!! Form::open(['method' => 'get', 'route' => ['dashboard']]) !!}
			{!! Form::submit('Cancel', ['class' => 'btn btn-default btn-block btn-lg btn-parsley']) !!}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@stop
