<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código de verificación</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; padding: 20px;">
        <h2 style="color: #2c3e50;">Código de Verificación</h2>
        <p>Hola, has solicitado restablecer tu contraseña.</p>
        <p>Este es tu código de verificación:</p>
        <h1 style="background-color: #f2f2f2; padding: 10px; display: inline-block; border-radius: 5px;">
            <?= $data['codigo']; ?>
        </h1>
        <p>Este código es válido por solo 5 minutos.</p>
        <p>Si no solicitaste este código, puedes ignorar este mensaje.</p>
        <br>
        <p>Atentamente,</p>
        <strong><?= NOMBRE_SISTEMA; ?></strong>
    </div>
</body>
</html>
