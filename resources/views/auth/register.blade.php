@extends('layouts.app')

@section('content')
<div class="container">
	<div class="register-box">
		<img src="{{asset('storage/img_sistem/hamster.jpg')}}" alt="Hamster" class="avatar">
		<h1>Control de Ingresos</h1>
		<h1>Registrate</h1>
		<form action="{{ route('register') }}" method="post">
			@csrf
			<label for="name"><i class="fa-solid fa-user"></i>&nbsp;Nombre</label>
			<input type="text" id="name" name="name" placeholder="Juan Perez" value="{{ old('name') }}" required class="form-congrol-lg @error('name') is-invalid @enderror">

			@error('name')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror

			<label for="email"><i class="fa-regular fa-envelope"></i>&nbsp;Correo</label>
			<input type="email" name="email" id="email" class="form-control-lg @error('email') is invalid @enderror" placeholder="Juan.Perez@gmail.com" required>

			@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror

			<label for="pasword"><i class="fa-solid fa-key"></i>&nbsp;Contraseña</label>
			<input type="password" name="password" id="password" class="form-control-lg @error('password') is-invalid @enderror" placeholder="Ingresa una contraseña">

			@error('password')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror

			<label for="password-confirm"><i class="fa-solid fa-key"></i>&nbsp;Confirmar Contraseña</label>
			<input type="password" name="password-confirm" id="password-confirm" class="form-control-lg @error('password-confirm') is-invalid @enderror" placeholder="Repite tu contraseña">

			@error('password-confirm')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
			@enderror

			<div class="d-flex align-items-center">
				<button type="submit" class="form-control btn-lg btn-block"><i class="fa-solid fa-circle-check"></i>&nbsp;Registrate</button>
			</div>
		</form>
	</div>
</div>
@endsection
