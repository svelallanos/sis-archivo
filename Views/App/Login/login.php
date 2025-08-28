<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/libraries/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- CSS de la las alertas -->
  <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/libraries/toastr.min.css">
  <link rel="shortcut icon"
    href="<?= base_url() ?>/loadfile/icon?f=<?= (getSystemInfo()) ? getSystemInfo()["c_logo"] : null; ?>"
    type="image/x-icon">
  <link rel="stylesheet"
    href="<?= media() ?>/css/app/<?= $data["page_js_css"] ?>/style_<?= $data["page_js_css"] ?>.css">
  <title><?= $data["page_title"] ?></title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1><?= (getSystemInfo()) ? getSystemInfo()["c_name"] : getSystemName(); ?></h1>
    </div>
    <div class="login-box">
      <form class="login-form" id="formLogin" autocomplete="off">
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Iniciar Sesión</h3>
        <div class="form-group">
          <label class="control-label" for="txtUser">Usuario o Email</label>
          <input class="form-control" type="text" id="txtUser" name="txtUser" placeholder="Ingrese su usuario o Email"
            autofocus required minlength="3">
        </div>
        <div class="form-group">
          <label class="control-label" for="txtPassword">Contraseña</label>
          <input class="form-control" type="password" id="txtPassword" name="txtPassword"
            placeholder="Ingrese sus contraseña" required minlength="8">
        </div>
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                <input type="checkbox" id="chbxRemember" name="chbxRemember"><span class="label-text">Recuerdame</span>
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidaste tu contraseña ?</a></p>
          </div>
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Ingresar</button>
        </div>
      </form>
      <form id="formForget" class="forget-form"  method="POST">
        <h3 class="login-head"> <i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidaste tu Contraseña?
        </h3>
        <div class="form-group">
          <label class="control-label">EMAIL</label>
          <input class="form-control" type="text" name="email" placeholder="Ingresa tu Email" required>
        </div>
        <div class="form-group btn-container">
          <button type="submit" class="btn btn-primary btn-block"> <i class="fa fa-unlock fa-lg fa-fw"></i>Reiniciar
          </button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0"> <a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Regresar al Inicio de Sesión</a>
          </p>
        </div>
      </form>

    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="<?= media() ?>/js/libraries/jquery-3.3.1.min.js"></script>
  <script src="<?= media() ?>/js/libraries/popper.min.js"></script>
  <script src="<?= media() ?>/js/libraries/bootstrap.min.js"></script>
  <script src="<?= media() ?>/js/libraries/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="<?= media() ?>/js/libraries/plugins/pace.min.js"></script>
  <!--Libreria de sweetalert-->
  <script type="text/javascript" src="<?= media() ?>/js/libraries/toastr.min.js"></script>
  <script type="text/javascript">
    const base_url = "<?= base_url(); ?>";
  </script>
  <script src="<?= media() ?>/js/app/<?= $data["page_js_css"] ?>/functions_<?= $data["page_js_css"] ?>.js"></script>
</body>

</html>