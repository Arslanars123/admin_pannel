<!DOCTYPE html>
<html>
<head>
	<style>
table, th, td {
  border:1px solid grey;
}
th{
	padding: 6px;
}
td{
	padding: 6px;
}
</style>
</head>
<body>
<div style="margin-left: 20px">
	<h3>{{$dynamic->customer_name}} : {{$user->name}}</h3>
	<h3>{{$dynamic->total_price}} : {{$totalPrice}}</h3>
	<h3>{{$dynamic->bookings}}</h3>
	<table>
		<th>{{$dynamic->product_name}}</th>
		<th>{{$dynamic->price}}</th>
		<th>{{$dynamic->creation_date_time}}</th>
		<tbody>
			@foreach($bookings as $booking)
			<?php 
				$product=\App\Models\ProductInfo::find($booking->product_id);
			?>
			<tr>
				<td>{{$product->name_en}} / {{$product->name_it}}</td>
				<td>{{$product->price}}</td>
				<td>{{$booking->created_at}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<h3>{{$dynamic->reservations}}</h3>
	<table>
		<tr>
		<th>{{$dynamic->service_name}}</th>
		<th>{{$dynamic->price}}</th>
        <th>{{$dynamic->reserve_date}}</th>
        <th>{{$dynamic->event_date}}</th>
        <th>{{$dynamic->number_of_people}}</th>
        <th>{{$dynamic->number_of_children}}</th>
        <th>{{$dynamic->hours_from}}</th>
        <th>{{$dynamic->hours_to}}</th>
    	</tr>
		
			@foreach($reserves as $reserve)
			<?php 
				$service=\App\Models\ServiceInfo::find($reserve->service_id);
			?>
			<tr>
				<td>{{$service->name_en}} / {{$service->name_it}}</td>
				<td>{{$service->price}}</td>
                <td>{{$reserve->reserve_date}}</td>
                <td>{{$reserve->event_date}}</td>
                <td>{{$reserve->number_of_people}}</td>
                <td>{{$reserve->number_of_children}}</td>
                <td>{{$reserve->hours_from}}</td>
                <td>{{$reserve->hours_to}}</td>
			</tr>
			@endforeach
		
	</table>
	<br>
	<button style="background-color:blue;color: white;padding: 15px" onclick="window.print()">{{$dynamic->print_summary}}</button>
	<a href="{{url('get-pdf/'.$user->id)}}" style="background-color:green;color: white;padding: 15px">{{$dynamic->take_pdf}}</a>

</div>
</body>
</html>