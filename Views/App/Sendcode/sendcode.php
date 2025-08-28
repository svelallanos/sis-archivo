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
  <!-- CSS de alertas -->
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
      
    <form class="login-form" id="formSendCode" method="POST">
        <h3 class="login-head"><i class="fa fa-key fa-lg fa-fw"></i> Verificar Código</h3>
        <div class="form-group">
          <label class="control-label" for="txtCode">Código de Verificación</label>
          <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Ingresa el código" required>
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-check fa-lg fa-fw"></i> Verificar</button>
        </div>
        <div class="form-group mt-3">
          <p class="semibold-text mb-0">
            <a href="<?= base_url(); ?>/login"><i class="fa fa-angle-left fa-fw"></i> Volver al inicio</a>
          </p>
        </div>
      </form>

    </div>
  </section>

  <!-- Scripts esenciales -->
  <script src="<?= media() ?>/js/libraries/jquery-3.3.1.min.js"></script>
  <script src="<?= media() ?>/js/libraries/popper.min.js"></script>
  <script src="<?= media() ?>/js/libraries/bootstrap.min.js"></script>
  <script src="<?= media() ?>/js/libraries/main.js"></script>
  <script src="<?= media() ?>/js/libraries/plugins/pace.min.js"></script>
  <script src="<?= media() ?>/js/libraries/toastr.min.js"></script>
  <script type="text/javascript">
    const base_url = "<?= base_url(); ?>";
  </script>
  <script src="<?= media() ?>/js/app/<?= $data["page_js_css"] ?>/functions_<?= $data["page_js_css"] ?>.js"></script>
</body>

</html>