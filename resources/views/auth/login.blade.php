<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Formulario</title>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
</head>
<body>

    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="flex-column">
            <label>Email</label>
        </div>
        <div class="inputForm">
            <!-- Ícono SVG -->
            <!-- (Puedes dejarlo igual) -->
            <input placeholder="Enter your Email" class="input" type="email" name="email" :value="old('email')" required autofocus>
        </div>
        @if($errors->has('email'))
            <span style="color:red; font-size:12px;">{{ $errors->first('email') }}</span>
        @endif

        <!-- Password -->
        <div class="flex-column">
            <label>Password</label>
        </div>
        <div class="inputForm">
            <!-- Ícono SVG -->
            <input placeholder="Enter your Password" class="input" type="password" name="password" required>
        </div>
        @if($errors->has('password'))
            <span style="color:red; font-size:12px;">{{ $errors->first('password') }}</span>
        @endif

        <!-- Remember me y Forgot password -->
        <div class="flex-row">
            <div>
                <input type="checkbox" id="remember_me" name="remember">
                <label for="remember_me">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a class="span" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </div>

        <!-- Botón Login -->
        <button type="submit" class="button-submit">Sign In</button>

        <p class="p">
          Don't have an account?
          <a href="{{ route('register') }}" class="span">Sign Up</a>
        </p>
        <p class="p line">Or With</p>

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
