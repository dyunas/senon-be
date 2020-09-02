<table>
	<tbody>
		<tr>
			<td>INSURER:</td>
			<td>{{ $insurer ?? '' }}</td>
		</tr>
		<tr>
			<td>PERIOD:</td>
			<td>Update as of {{ $export_date ?? '' }}</td>
		</tr>
	</tbody>
</table>
<br/>
<table>
	<thead>
		<tr>
				<th>REF. NO.</th>
				<th>DATE ASSIGNED</th>
				<th>DATE INSPECTED</th>
				<th>ADJUSTER</th>
				<th>BROKER</th>
				<th>CLAIM NUMBER</th>
				<th>INSURED</th>
				<th>THIRD PARTY</th>
				<th>POLICY NO.</th>
				<th>POLICY TYPE</th>
				<th>RISK LOCATION</th>
				<th>NATURE LOSS</th>
				<th>DATE LOSS</th>
				<th>LOSS RESERVE</th>
				<th>STATUS</th>
		</tr>
	</thead>
	<tbody>
	@if ($assignments)
		@foreach($assignments as $assignment)
			<tr>
				<td>{{ $assignment->ref_no }}</td>
				<td>{{ $assignment->date_assigned }}</td>
				<td>{{ $assignment->date_inspected }}</td>
				<td>{{ $assignment->adjuster }}</td>
				<td>{{ $assignment->broker }}</td>
				<td>{{ $assignment->claim_number }}</td>
				<td>{{ $assignment->name_insured }}</td>
				<td>{{ $assignment->third_party }}</td>
				<td>{{ $assignment->pol_no }}</td>
				<td>{{ $assignment->pol_type }}</td>
				<td>{{ $assignment->risk_location }}</td>
				<td>{{ $assignment->nature_loss }}</td>
				<td>{{ $assignment->date_loss }}</td>
				<td>{{ $assignment->loss_reserve }}</td>
				<td>{{ $assignment->status_list->status }}</td>
			</tr>
		@endforeach
	@else
		<tr>
			<td colspan="15">No available data found in record.</td>
		</tr>
	@endif
	</tbody>
</table>
