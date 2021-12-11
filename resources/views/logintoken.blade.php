@extends('layouts.app')
@section('content')
    <div class="form-group col-lg-6 offset-lg-3">
        <form method="post" action="{{ route('login.token') }}" id="form">
            @csrf
            <h2 for="two_fact_auth">Enter Your Token</h2><br>
            <input id="input" onkeyup="valid()" type="text"
                class="text-dark form-control mt-3 @error('token') is-invalid @enderror" placeholder="Token" name="token"
                style="background:rgb(202, 201, 201)" value="{{ old('token') }}">
            @error('token')
                <p style="color:red">{{ $message }}</p>
            @enderror
            <br>
            <button class="btn btn-primary offset-lg-5 mt-3" onclick="empty()" id="btn">Send</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        function valid() {
            var input = document.getElementById('input');
            if (input.value == '') {
                document.getElementById("btn").disabled = true;
            } else {
                document.getElementById("btn").disabled = false;
            }
        }

        function empty() {
            if (input.value == '') {
                alert('fill the field');
                document.getElementById("form").addEventListener("submit", function(event) {
                    event.preventDefault()
                });
            } else {
                document.getElementById("form").submit();
            }
        }

    </script>
@endsection
