<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header text-center">
                <h4>Registro de Usuario</h4>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="/registro" method="POST">
                    <div class="form-group">
                        <label for="nombres">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingresa tus nombres" required>
                    </div>
                    <div class="form-group">
                        <label for="ap">Apellido Paterno</label>
                        <input type="text" class="form-control" id="ap" name="ap" placeholder="Ingresa tu apellido paterno" required>
                    </div>
                    <div class="form-group">
                        <label for="am">Apellido Materno</label>
                        <input type="text" class="form-control" id="am" name="am" placeholder="Ingresa tu apellido materno" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu email" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ingresa un nombre de usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="/iniciar-sesion">¿Ya tienes cuenta? Inicia Sesión</a>
            </div>
        </div>
    </div>
</div>