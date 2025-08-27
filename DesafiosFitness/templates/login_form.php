<div class="card fade-in">
    <h2>Iniciar sesión</h2>

    <!-- Muestra mensaje de error si lo hay -->
    <?php if (isset($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold;"><?= $error ?></p>
    <?php endif; ?>

    <form action="../public/login.php" method="POST">
        <div class="full-width">
            <label for="username">Usuario</label>
            <input type="text" name="username" id="username" required>
        </div>

        <div class="full-width">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="full-width">
            <input type="submit" value="Ingresar">
        </div>
    </form>

    <p class="text-center mt-2">¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
</div>
