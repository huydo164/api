@if ($data)
<h1>{{ $data['start_date'] }}</h1>
<p>{{ $data['problem'] }}</p>
<p>{{ $data['risk'] }}</p>
<p>{{ $data['solution'] }}</p>
@endif