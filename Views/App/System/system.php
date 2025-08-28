<?= headerAdmin($data) ?>
<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1><i class="fa fa-gear"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-gear fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/system"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>

    <!-- ============================ FORMULARIO 1 ============================ -->
    <div class="d-flex justify-content-center align-items-center mb-5">
        <div class="card p-4 container-fluid shadow">
            <h4 class="text-center mb-4">Configuración del Sistema</h4>
            <form id="formSave" enctype="multipart/form-data" autocomplete="off">
                <?= csrf() ?>
                <div class="form-group">
                    <label for="logo">Logo / Ícono</label>
                    <input type="file" class="form-control-file" id="logo" name="logo" accept="image/png, image/jpeg"
                        onchange="previewLogo(event)">
                    <div class="mt-3 text-center">
                        <img id="logoPreview"
                            src="<?= base_url() ?>/loadfile/icon?f=<?= (getSystemInfo()) ? getSystemInfo()["c_logo"] : ""; ?>"
                            alt="Vista previa del logo" class="img-fluid" style="max-height: 100px; width: 100px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombreSistema">Nombre del Sistema <span class="text-danger">*</span></label>
                    <input type="text" id="nombreSistema" name="nombreSistema" class="form-control"
                        placeholder="Ingrese el nombre del sistema" required
                        value="<?= (getSystemInfo()) ? getSystemInfo()["c_name"] : getSystemName(); ?>">
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                        pattern="^[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+$"
                        placeholder="Ingrese una descripción"><?= (getSystemInfo()) ? getSystemInfo()["c_description"] : getSystemName(); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-save"></i> Guardar Configuración
                </button>
            </form>
        </div>
    </div>

    <!-- ============================ FORMULARIO 2 ============================ -->
    <div class="d-flex justify-content-center align-items-center">
        <div class="card p-4 container-fluid shadow">
            <h4 class="text-center mb-4"><i class="fa fa-building"></i> Configuración de los datos de la empresa</h4>
            <form id="formSaveEmpresa" autocomplete="off">
                <?= csrf() ?>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="tituloEmpresa">Título de la empresa <span class="text-danger">*</span></label>
                        <input type="text" id="tituloEmpresa" name="tituloEmpresa" class="form-control" required
                            value="<?= (getConfigurationSytem()) ? getConfigurationSytem()['title'] : getSystemName(); ?>">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="subtituloEmpresa">Subtítulo de la empresa <span class="text-danger">*</span></label>
                        <input type="text" id="subtituloEmpresa" name="subtituloEmpresa" class="form-control" required
                            value="<?= (getConfigurationSytem()) ? getConfigurationSytem()['subtitle'] : getSystemName(); ?>">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="emailEmpresa">Correo electrónico <span class="text-danger">*</span></label>
                        <input type="email" id="emailEmpresa" name="emailEmpresa" class="form-control" required
                            value="<?= (getConfigurationSytem()) ? getConfigurationSytem()['mail'] : ""; ?>">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="rucEmpresa">RUC de la empresa <span class="text-danger">*</span></label>
                        <input type="text" id="rucEmpresa" name="rucEmpresa" class="form-control" required
                            pattern="\d{11}" maxlength="11" minlength="11"
                            value="<?= (getConfigurationSytem()) ? getConfigurationSytem()['ruc'] : ""; ?>">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="direccionEmpresa">Dirección de la empresa <span class="text-danger">*</span></label>
                        <input type="text" id="direccionEmpresa" name="direccionEmpresa" class="form-control" required
                            value="<?= (getConfigurationSytem()) ? getConfigurationSytem()['address'] : ""; ?>">
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="telefonoEmpresa">Teléfono de la empresa <span class="text-danger">*</span></label>
                        <input type="tel" id="telefonoEmpresa" name="telefonoEmpresa" class="form-control" required
                            pattern="\d{9}" maxlength="9" minlength="9"
                            value="<?= (getConfigurationSytem()) ? getConfigurationSytem()['phone'] : ""; ?>">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fa fa-save"></i> Guardar Información
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewLogo(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('logoPreview');
                output.src = reader.result;
                output.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</main>
<?= footerAdmin($data) ?>