@extends('layouts.app')

@section('content')
<div class="container" id="login">
    <img src="../../images/logo.svg" alt="" class="logo">
    <form method="POST" action="{{ route('login') }}" class="loginform">
        @csrf
        <div class="loginform__email">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} loginform__email__input" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label for="email" class="loginform__email__label">Adresse email&nbsp;:</label>
                @if ($errors->has('email'))
                    <span class="loginform__email__error" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
        </div>
        <div class="loginform__password">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} loginform__password__input" name="password" required autocomplete="current-password">
            <label for="password" class="loginform__password__label">Mot de passe&nbsp;:</label>

                @if ($errors->has('password'))
                    <span class="loginform__password__error" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
        </div>

        <button type="submit" class="loginform__submit__button button">
            Connexion
        </button>

        <!-- @if (Route::has('password.request'))
            <a class="loginform__submit__forgot" href="{{ route('password.request') }}">
                Mot de passe oublier ? 
            </a>
        @endif -->

    </form>
    <a class="nav-link register__link" href="{{ route('register') }}">Pas encore inscrit&nbsp;?</a>
</div>
@endsection
