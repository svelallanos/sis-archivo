<!DOCTYPE html>
<html lang="es">

<head>
    <title><?= $data["page_title"] ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Colocar las descripciones de la pagina-->
    <meta name="description" content="<?= getSystemInfo()["c_description"] ?>">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/libraries/main.css">
    <!-- Font-icon css-->
    <!-- <link rel="stylesheet" type="text/css"
        href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/libraries/all.min.css">
    <!-- CSS de la las alertas -->
    <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/libraries/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media() ?>/css/libraries/all.min.css">
    <!--Cargamos el inco de la pagina-->
    <link rel="shortcut icon"
          href="<?= base_url() ?>/loadfile/icon?f=<?= (getSystemInfo()) ? getSystemInfo()["c_logo"] : null; ?>"
          type="image/x-icon">
    <!-- CSS de la vista -->
    <?php
    if (is_array($data["page_js_css"])) {
        foreach ($data["page_js_css"] as $css) {
            ?>
            <link rel="stylesheet"
                  href="<?= media() ?>/css/app/<?= strtolower($data["page_container"]) ?>/style_<?= $css ?>.css">
            <?php
        }
    } else {
        ?>
        <link rel="stylesheet"
              href="<?= media() ?>/css/app/<?= strtolower($data["page_container"]) ?>/style_<?= $data["page_js_css"] ?>.css">
        <?php
    }
    ?>
    <?php require_once "./Views/App/" . ucfirst($data["page_container"]) . "/Libraries/head.php"; ?>
</head>

<body class="app sidebar-mini">
<!-- Navbar-->
<?php include "./Views/Template/panel/navbar.php"; ?>
<!-- Sidebar menu-->
<?php include "./Views/Template/panel/sidebarmenu.php"; ?>