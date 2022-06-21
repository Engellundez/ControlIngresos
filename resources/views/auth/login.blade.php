@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="container">
	<div class="login-box">
		<img class="avatar" src="{{asset('storage/img_sistem/hamster.jpg')}}" alt="Hamster">
		<h1>Control de Ingresos</h1>
		<h1>Iniciar Sesión</h1>
		<form action="{{ route('login') }}" method="POST">
			@csrf
			{{-- username --}}
			<label for="email"><i class="fa-solid fa-envelope"></i>&nbsp;Correo</label>
			<input type="text" class="form-control-lg @error('password') is-invalid @enderror" name="email" id="email" placeholder="Ingresa tu correo">

			@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror

			{{-- password --}}
			<label for="password"><i class="fa-solid fa-lock"></i>&nbsp;Contraseña</label>
			<input type="password" class="form-control-lg @error('password') is-invalid @enderror" name="password" id="password" placeholder="Ingresa tu contraseña">

			@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror

			<input class="form-control-lg" type="submit" value="Iniciar Sesión">

			<a href="">Perdiste tu contraseña</a><br>
		</form>
	</div>
</div>
@endsection
