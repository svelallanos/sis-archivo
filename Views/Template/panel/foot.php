<!-- Essential javascripts for application to work-->
<script src="<?= media() ?>/js/libraries/jquery-3.3.1.min.js"></script>
<script src="<?= media() ?>/js/libraries/popper.min.js"></script>
<script src="<?= media() ?>/js/libraries/bootstrap.min.js"></script>
<script src="<?= media() ?>/js/libraries/main.js"></script>
<script src="<?= media() ?>/js/libraries/validateSesionActivity.js"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="<?= media() ?>/js/libraries/plugins/pace.min.js"></script>
<script src="<?= media() ?>/js/libraries/all.min.js"></script>
<!--Libreria de sweetalert-->
<script type="text/javascript" src="<?= media() ?>/js/libraries/toastr.min.js"></script>
<!--Librerias de la view-->
<?= require_once "./Views/App/" . ucfirst($data["page_container"]) . "/Libraries/foot.php"; ?>
<!-- Page specific javascripts-->
<script type="text/javascript">
    const base_url = "<?= base_url(); ?>";
</script>
<?php
if (is_array($data["page_js_css"])) {
    foreach ($data["page_js_css"] as $js) {
        ?>
        <script
                src="<?= media() ?>/js/app/<?= strtolower($data["page_container"]) ?>/functions_<?= $js ?>.js"></script>
        <?php
    }
} else {
    ?>
    <script
            src="<?= media() ?>/js/app/<?= strtolower($data["page_container"]) ?>/functions_<?= $data["page_js_css"] ?>.js"></script>
    <?php
}
?>

</body>

</html>