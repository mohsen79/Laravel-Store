@extends('layouts.app')
@section('content')
    <div class="form-group col-lg-6 offset-lg-3">
        <form method="post" action="{{ route('TwoFact.check', ['user' => auth()->user()]) }}">
            @csrf
            <h2 for="two_fact_auth">Enter Your Token</h2><br>
            <input type="text" class="text-dark form-control mt-3 @error('token') is-invalid @enderror" placeholder="Token"
                name="token" style="background:rgb(202, 201, 201)" value="{{ old('token') }}">
            @error('token')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <br>
            <button class="btn btn-primary offset-lg-5 mt-3">Send</button>
        </form>
    </div>
@endsection
