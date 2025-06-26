<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>

    <form class="form" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div class="flex-column">
            <label>Name</label>
        </div>
        <div class="inputForm">
            <input placeholder="Enter your name" class="input" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        @if($errors->has('name'))
            <span style="color:red; font-size:12px;">{{ $errors->first('name') }}</span>
        @endif

        <!-- Email -->
        <div class="flex-column">
            <label>Email</label>
        </div>
        <div class="inputForm">
            <input placeholder="Enter your Email" class="input" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        @if($errors->has('email'))
            <span style="color:red; font-size:12px;">{{ $errors->first('email') }}</span>
        @endif

        <!-- Password -->
        <div class="flex-column">
            <label>Password</label>
        </div>
        <div class="inputForm">
            <input placeholder="Enter your Password" class="input" type="password" name="password" required>
        </div>
        @if($errors->has('password'))
            <span style="color:red; font-size:12px;">{{ $errors->first('password') }}</span>
        @endif

        <!-- Confirm Password -->
        <div class="flex-column">
            <label>Confirm Password</label>
        </div>
        <div class="inputForm">
            <input placeholder="Confirm your Password" class="input" type="password" name="password_confirmation" required>
        </div>
        @if($errors->has('password_confirmation'))
            <span style="color:red; font-size:12px;">{{ $errors->first('password_confirmation') }}</span>
        @endif

        <!-- Botón registrar -->
        <button type="submit" class="button-submit">Register</button>

        <!-- Ya tienes cuenta -->
        <p class="p">Already registered? <a href="{{ route('login') }}" class="span">Log in</a></p>

        <!-- Línea divisora -->
        <p class="p line">Or Register With</p>

        <!-- Botón Google -->
        <div style="display: flex; justify-content: center;">
            <button type="button" class="btn google" onclick="window.location='{{ route('auth.google') }}'">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/4a/Logo_2013_Google.png" width="20" alt="Google">
                Continuar con Google
            </button>
        </div>

        <!-- Mensaje aclaratorio -->
        <p style="font-size: 13px; text-align: center; margin-top: 10px;">
            Al continuar con Google, se registrará automáticamente si aún no tiene una cuenta.
</p>
    </form>
</body>
</html>
