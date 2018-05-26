@extends('layouts/email')

@section('content')
    <h3 class="panel-title">Password Reset</h3>
    <h2>Here is your confirmation code:</h2>
    <?php echo $code; ?>
@endsection