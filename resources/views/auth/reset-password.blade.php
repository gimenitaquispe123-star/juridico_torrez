<h3>Restablecer contraseña</h3>

<form action="{{ route('password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">

    <label>Correo electrónico:</label>
    <input type="email" name="email" required>

    <label>Nueva contraseña:</label>
    <input type="password" name="password" required>

    <label>Confirmar contraseña:</label>
    <input type="password" name="password_confirmation" required>

    <button type="submit">Guardar nueva contraseña</button>
</form>
