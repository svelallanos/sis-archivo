<?= headerAdmin($data) ?>

<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1><i class="fa fa-tag" aria-hidden="true"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-flag-checkered" aria-hidden="true"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/roles"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>
    <div class="tile">
        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalSave">
            <i class="fa fa-plus"></i> Nuevo
        </button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm w-100" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Titulo</th>
                                    <th>Subtitulo</th>
                                    <th>Descripción</th>
                                    <th>Email</th>
                                    <th>Ruc</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?= footerAdmin($data) ?>

<!-- Sección de Modals -->
<!-- Modal Save -->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSaveLabel">Registro de empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Registro de Roles -->
                <div class="tile-body">
                    <form id="formSave" enctype="multipart/form-data" autocomplete="off">
                        <?= csrf(); ?>
                        <div class="form-group">
                            <label class="control-label" for="txtTitle">Título
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" type="text" id="txtTitle" name="txtTitle" required
                                placeholder="Ingrese el titulo de la empresa" maxlength="200" minlength="4"
                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,200}$"
                                title="El titulo debe contener entre 4 y 200 caracteres y solo incluir letras y espacios.">
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="txtSubtitle">Subtitulo

                            </label>
                            <input class="form-control" type="text" id="txtSubtitle" name="txtSubtitle" required
                                placeholder="Ingrese el subtitulo de la empresa" maxlength="200" minlength="4"
                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,200}$"
                                title="El subtitulo debe contener entre 4 y 200 caracteres y solo incluir letras y espacios.">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="txtDescription">Descripción
                            </label>
                            <textarea class="form-control" id="txtDescription" name="txtDescription" minlength="20"
                                pattern="^[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+$"
                                placeholder="Ingrese la descripción de la empresa"></textarea>
                            <small class="form-text text-muted">
                                (Opcional) La descripción debe tener al menos 20 caracteres y solo puede incluir letras,
                                números, espacios, guiones altos y bajos.
                            </small>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="txtMail">Correo Electrónico
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control"
                                type="email"
                                id="txtMail"
                                name="txtMail"
                                required
                                placeholder="Ingrese el correo de la empresa"
                                maxlength="200"
                                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                title="Ingrese un correo electrónico válido, por ejemplo: nombre@dominio.com">
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="txtRuc">RUC
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                id="txtRuc"
                                name="txtRuc"
                                required
                                placeholder="Ingrese el RUC de la empresa"
                                maxlength="11"
                                minlength="11"
                                pattern="^[0-9]{11}$"
                                title="El RUC debe tener exactamente 11 números.">
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="txtAddress">Dirección
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                id="txtAddress"
                                name="txtAddress"
                                required
                                placeholder="Ingrese la dirección de la empresa"
                                maxlength="200"
                                minlength="4"
                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9#.,\-\s]{4,200}$"
                                title="La dirección debe tener entre 4 y 200 caracteres y puede incluir letras, números, espacios, comas, puntos, guiones y numerales.">
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="txtPhone">Teléfono
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                class="form-control"
                                type="text"
                                id="txtPhone"
                                name="txtPhone"
                                required
                                placeholder="Ingrese el teléfono de la empresa"
                                maxlength="9"
                                minlength="1"
                                pattern="^[0-9()+\-\s]{1,9}$"
                                title="El teléfono debe tener entre 7 y 15 dígitos y puede incluir números, espacios, paréntesis, guiones y signo +.">
                        </div>


                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-fw fa-lg fa-save"></i> Registrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Delete-->
<div class="modal fade" id="confirmModalDelete" tabindex="-1" role="dialog" aria-labelledby="confirmModalDeleteLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalLabel">Confirmación de Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa fa-exclamation-triangle fa-5x text-danger mb-3"></i>
                <p class="font-weight-bold">¿Estás seguro?</p>
                <p class="" id="txtDelete"></p>
                <p class="text-danger"><strong>Esta acción no se puede deshacer</strong></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fa fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" data-token="<?= csrf(false); ?>" id="confirmDelete">
                    <i class="fa fa-check"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update-->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalUpdateLabel">Actualizar información de la empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Actualziacion de Usuario -->
                <div class="tile-body">
                    <form id="formUpdate" autocomplete="off">
                        <?= csrf(); ?>
                        <input type="hidden" name="update_txtId" id="update_txtId">
                        <div class="form-group">
                            <label class="control-label" for="update_txtTitle">Título
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" type="text" id="update_txtTitle" name="update_txtTitle" required
                                placeholder="Ingrese el titulo de una empresa" maxlength="200" minlength="4"
                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,250}$"
                                title="El nombre debe contener entre 4 y 250 caracteres y solo incluir letras y espacios.">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="update_txtSubtitle">Subtítulo</label>
                            <input
                                class="form-control"
                                type="text"
                                id="update_txtSubtitle"
                                name="update_txtSubtitle"
                                placeholder="Ingrese el subtítulo de la empresa"
                                maxlength="200"
                                pattern="^([A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,200})?$"
                                title="Si ingresa un subtítulo, debe tener entre 4 y 200 letras y espacios.">
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="update_txtDescription">Descripción
                            </label>
                            <textarea class="form-control" id="update_txtDescription" name="update_txtDescription"
                                minlength="20" pattern="^[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()-]+$"
                                placeholder="Ingrese la descripción de la categoria"></textarea>
                            <small class="form-text text-muted">
                                (Opcional)La descripción debe tener al menos 20 caracteres y solo puede incluir letras,
                                números, espacios, guiones altos y bajos.
                            </small>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="update_txtMail">Email</label>
                            <input
                                class="form-control"
                                type="email"
                                id="update_txtMail"
                                name="update_txtMail"
                                placeholder="Ingrese el email de la empresa"
                                maxlength="200"
                                pattern="^[^@\s]+@[^@\s]+\.[^@\s]+$"
                                title="Ingrese un correo electrónico válido (ejemplo@dominio.com)">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="update_txtRuc">RUC</label>
                            <input
                                class="form-control"
                                type="text"
                                id="update_txtRuc"
                                name="update_txtRuc"
                                placeholder="Ingrese el RUC de la empresa"
                                maxlength="11"
                                pattern="^([0-9]{11})?$"
                                title="Si ingresa un RUC, debe tener exactamente 11 dígitos numéricos.">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="update_txtAddress">Dirección</label>
                            <input
                                class="form-control"
                                type="text"
                                id="update_txtAddress"
                                name="update_txtAddress"
                                placeholder="Ingrese la dirección de la empresa"
                                maxlength="200"
                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ0-9#.,\s]{4,200}$"
                                title="Si ingresa una dirección, debe tener entre 4 y 200 caracteres y puede incluir letras, números y algunos símbolos como # , .">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="update_txtPhone">Teléfono</label>
                            <input
                                class="form-control"
                                type="text"
                                id="update_txtPhone"
                                name="update_txtPhone"
                                placeholder="Ingrese el teléfono de la empresa"
                                maxlength="9"
                                pattern="^\d{7,9}$"
                                inputmode="numeric"
                                title="El teléfono debe tener entre 7 y 9 dígitos numéricos, como se usa en Perú.">
                        </div>



                        <div class="form-group">
                            <label class="control-label" for="update_txtStatus">Estado
                                <span class="text-danger">*</span></label>
                            <select class="form-control" id="update_txtStatus" name="update_txtStatus" required>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-success btn-block" type="submit">
                                <i class="fa fa-fw fa-lg fa-pencil"></i>Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Report -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReportLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold" id="modalReportLabel">Reporte de la empresa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Contenedor principal con foto y datos -->
                <!-- Contenedor principal con foto y datos -->
                <div class="d-flex justify-content-center  align-items-center">
                    <h3 class="text-uppercase font-weight-bold text-primary" id="reportTitle">Título del registro</h3>
                </div>
                <!-- Datos Personales -->
                <h6 class="text-uppercase font-weight-bold text-danger mt-4">Información de la empresa</h6>
                <hr>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Codigo</strong></td>
                            <td id="reportCode">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Titulo</strong></td>
                            <td id="reportTitle">Medina SA</td>
                        </tr>
                        <tr>
                            <td><strong>Subtitulo</strong></td>
                            <td id="reportSubtitle">Asociacion Medina</td>
                        </tr>
                        <tr>
                            <td><strong>Descripcion</strong></td>
                            <td id="reportDescription">Texto adicional</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td id="reportEmail">Medina@gmail.com</td>
                        </tr>
                        <tr>
                            <td><strong>Ruc</strong></td>
                            <td id="reportRuc">95415411114</td>
                        </tr>
                        <tr>
                            <td><strong>Direccion</strong></td>
                            <td id="reportAddress">Jr Lima</td>
                        </tr>
                        <tr>
                            <td><strong>Telefono</strong></td>
                            <td id="reportPhone">985445785</td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td id="reportEstado">Root</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Datos de registro: Fecha de registro y actualización -->
                <div class="p-3 bg-light border rounded">
                    <p class="text-muted mb-1">
                        <strong>Fecha de registro:</strong> <span class="text-dark"
                            id="reportRegistrationDate">29/01/2025</span>
                    </p>
                    <p class="text-muted mb-0">
                        <strong>Fecha de actualización:</strong> <span class="text-dark"
                            id="reportUpdateDate">29/01/2025</span>
                    </p>
                </div>
            </div>
            <!-- Pie del Modal -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>