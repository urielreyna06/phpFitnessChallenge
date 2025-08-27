<div class="card fade-in" style="max-width: 600px; margin: 40px auto;">
    <h2>Crear cuenta</h2>

    <?php if (!empty($error)): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="message success">¡Registro exitoso! Redirigiendo...</div>
    <?php endif; ?>

    <form action="" method="POST" class="fade-in">
        <label for="fullname">Nombre completo:</label>
        <input type="text" name="fullname" id="fullname" required>

        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Número de celular:</label>
        <input type="text" name="phone" id="phone" placeholder="6000-1234" pattern="\d{4}-?\d{4}">

        <label for="gender">Sexo:</label>
        <select name="gender" id="gender" required>
            <option value="" disabled selected>Selecciona...</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>

        <label for="birthdate">Fecha de nacimiento:</label>
        <input type="date" name="birthdate" id="birthdate" required>

        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Registrarse" class="btn-primary">

        <div style="text-align: center; margin-top: 12px;">
            ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </form>
</div>
