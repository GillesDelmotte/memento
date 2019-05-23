@extends('layouts.app')

@section('content')
<div class="container" id="register">
<img src="../../images/logo.svg" alt="" class="logo">

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="registerform__name">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            <label for="name" >Nom&nbsp;:</label>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
        </div>

        <div class="registerform__email">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            <label for="email" >Adresse email&nbsp;:</label>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
        </div>

        <div class="registerform__gsm">
            <input id="gsm" type="tel"  pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}" name="gsm"  required>
            <label for="gsm" >Numéro de gsm&nbsp;:</label>
        </div>

        <div class="registerform__job">
            <input id="job" type="text" name="job" required>
            <label for="job" >Profession&nbsp;:</label>
        </div>

        <div class="registerform__password">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="new-password">
            <label for="password" >Mot de passe&nbsp;:</label>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

        </div>

        <div class="registerform__confirm">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            <label for="password-confirm" >Confirmation de mot de passe&nbsp;:</label>
        </div>

        <button type="submit" class="registerform__submit__button button">
            Inscription
        </button>

    </form>
    <a class="nav-link register__link" href="{{ route('login') }}">Me connecter</a>
</div>
@endsection
