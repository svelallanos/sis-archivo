<?= headerAdmin($data) ?>

<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1><i class="fa fa-id-badge"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-id-badge"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/jobtitle"><?= $data["page_title"] ?></a></li>
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
                        <table class="table table-hover table-bordered w-100" id="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
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

<!-- Modal Save -->
<div class="modal fade" id="modalSave" tabindex="-1" role="dialog" aria-labelledby="modalSaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Registrar Cargo</h5>
                <button type="button" class="close" id="closeButtonSave" data-dismiss="modal"><span>&times;</span></button>

            </div>
            <form id="formSave" autocomplete="off">
                <div class="modal-body">
                    <?= csrf(); ?>
                    <div class="form-group">
                        <label for="txtName">Nombre del cargo <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="txtName" name="txtName" required maxlength="50" placeholder="Ej. Auxiliar Administrativo, Ingeniero de Sistemas">
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Descripción</label>
                        <textarea class="form-control" id="txtJobtitleDescription" name="txtJobtitleDescription"
                            minlength="10" maxlength="200"
                            pattern="^[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()\-]+$"
                            placeholder="Ingrese la descripción del cargo"></textarea>
                        <small class="form-text text-muted">
                            Mínimo 10 y máximo 200 caracteres. Letras, números y signos básicos permitidos.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Actualizar Cargo</h5>
                <button type="button" class="close" id="closeButtonSave" data-dismiss="modal"><span>&times;</span></button>

            </div>
            <form id="formUpdate" autocomplete="off">
                <?= csrf(); ?>
                <input type="hidden" name="update_txtId" id="update_txtId">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_txtName">Nombre del Cargo<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" id="update_txtName" name="update_txtName" required>
                    </div>
                    <div class="form-group">
                        <label for="update_txtDescription">Descripción</label>
                        <textarea class="form-control" id="update_txtDescription" name="update_txtJobtitleDescription"
                            minlength="10" maxlength="200"
                            pattern="^[a-zA-ZÁÉÍÓÚáéíóúÜüÑñ0-9\s.,;:!?()\-]+$"
                            placeholder="Ingrese la descripción del cargo"></textarea>
                        <small class="form-text text-muted">
                            Mínimo 10 y máximo 200 caracteres. Letras, números y signos básicos permitidos.
                        </small>


                    </div>
                    <div class="form-group">
                        <label for="update_slctStatus">Estado <span class="text-danger">*</span></label>
                        <select class="form-control" id="update_slctStatus" name="update_slctStatus" required>
                            <option value="ACTIVO">Activo</option>
                            <option value="INACTIVO">Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Report -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold">Reporte</h5>
                <button type="button" class="close" id="closeButtonSave" data-dismiss="modal"><span>&times;</span></button>

            </div>
            <div class="modal-body">
                <h1 class="text-center" style="color: red;">REPORTE DE CARGO</h1>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>ID</strong></td>
                            <td id="reportId"></td>
                        </tr>

                        <tr>
                            <td><strong>Nombre</strong></td>
                            <td id="reportName"></td>
                        </tr>
                        <tr>
                            <td><strong>Descripción</strong></td>
                            <td id="reportDescription"></td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td id="reportStatus"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="p-3 bg-light border rounded">
                    <p><strong>Fecha de registro:</strong> <span id="reportRegistrationDate"></span></p>
                    <p><strong>Fecha de actualización:</strong> <span id="reportUpdateDate"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmación de Eliminación (estilo mejorado como Roles) -->
<!-- Modal Delete-->
<div class="modal fade" id="confirmModalDelete" tabindex="-1" role="dialog" aria-labelledby="confirmModalDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document"> <!-- Centrado vertical -->
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
                <p id="txtDelete"></p>
                <p class="text-danger"><strong>Esta acción no se puede deshacer</strong></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-danger" data-token="<?= csrf(false); ?>" id="confirmDelete">
                    <i class="fa fa-check"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>