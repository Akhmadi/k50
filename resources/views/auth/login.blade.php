@extends('layouts.page')

@section('page_content')
    <div class="section">
        <div class="container">
            <div class="section__header">
                <h3>Авторизация</h3>
            </div>

            <form class="form form-horizontal margined__bottom" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="margined__bottom form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control form__control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="margined__bottom form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Пароль</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control form__control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group margined__bottom">
                    <div class="">
                        <button type="submit" class="btn is__red is__rounded">
                            Вход
                        </button>

                        <a class="btn is__outlined" href="{{ route('password.request') }}" style="display: none;">
                            Забыли пароль?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
