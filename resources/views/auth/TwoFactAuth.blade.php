@extends('layouts.app')
@section('content')
<div class="form-group col-lg-6 offset-lg-3">
<form method="post" action="{{route('TwoFact.update')}}">
        @csrf
        <h2 for="two_fact_auth">Two Factor by SMS</h2><br>
        <select name="two_fact_auth" class="form-control" onclick="show()" style="color:black;background:rgb(202, 201, 201)">
            @foreach(config('TwoFactAuth') as $key => $value)
            <option name="two_fact_auth" value="{{$key}}" {{old('two_fact_auth') || auth()->user()->hasTwoFact($key) ? 'selected' : ''}}>
                {{$value}}
            </option>
            @endforeach
        </select>
        <input type="number" class="text-dark form-control mt-3 @error('phone_number') is-invalid @enderror" placeholder="enter your phone number" name="phone_number" style="display: none;background:rgb(202, 201, 201)" value="{{old('phone_number') ?? auth()->user()->phone_number}}">
        @error('phone_number')
        <p style="color:red">{{$message}}</p>
        @enderror
        <br>
        <button class="btn btn-primary offset-lg-5 mt-3">update</button>
    </form>
</div>
<script>
    var value = document.getElementsByName('two_fact_auth')[0];
    if (value.value == 1 || value.value == 'on') {
        document.getElementsByName('phone_number')[0].style.display = 'block';
    }

    function show() {
        if (value.value == 1 || value.value == 'on') {
            document.getElementsByName('phone_number')[0].style.display = 'block';
        } else {
            document.getElementsByName('phone_number')[0].style.display = 'none';
        }
    }
</script>
@endsection
