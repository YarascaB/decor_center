@extends('layouts.app') {{-- Usa tu layout base si tienes uno --}}

@section('title', 'Bienvenido')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <form class="form" method="GET" action="{{ route('login') }}">
        <div class="flex-column">
            <label>Email</label>
        </div>
        <div class="inputForm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20">
                <path d="..."></path> {{-- recorta aquí por espacio --}}
            </svg>
            <input placeholder="Enter your Email" class="input" type="email" required />
        </div>

        <div class="flex-column">
            <label>Password</label>
        </div>
        <div class="inputForm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20">
                <path d="..."></path>
            </svg>
            <input placeholder="Enter your Password" class="input" type="password" required />
        </div>

        <div class="flex-row">
            <div>
                <input type="checkbox" />
                <label>Remember me</label>
            </div>
            <span class="span">Forgot password?</span>
        </div>

        <button type="submit" class="button-submit">Iniciar sesión</button>
        <p class="p">¿No tienes una cuenta? <a href="{{ route('register') }}" class="span">Regístrate</a></p>
        <p class="p line">O con</p>

        <div class="flex-row">
            <button type="button" class="btn google">Google</button>
            <button type="button" class="btn apple">Apple</button>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    {{-- Pega aquí tu CSS personalizado --}}
    {!! file_get_contents(public_path('css/custom-login.css')) !!}
</style>
@endsection
