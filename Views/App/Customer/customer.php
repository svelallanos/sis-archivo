<?= headerAdmin($data) ?>

<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1><i class="fa fa-user" aria-hidden="true"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-user" aria-hidden="true"></i></li>
            <li class="breadcrumb-item"><a
                    href="<?= base_url() ?>/<?= $data['page_js_css'] ?>"><?= $data["page_title"] ?></a></li>
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
                                    <th>Nombres completos</th>
                                    <th>DNI</th>
                                    <th>Fecha nacimiento</th>
                                    <th>Genero</th>
                                    <th>Email</th>
                                    <th>Telefono</th>
                                    <th>Direccion</th>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSaveLabel">Registro de cliente</h5>
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
                            <label class="control-label" for="txtDni">NÚMERO DE DOCUMENTO
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input class="form-control" type="text" id="txtDni" name="txtDni" required
                                    placeholder="Ingrese el DNI o RUC de una persona o empresa" maxlength="11" minlength="8"
                                    pattern="^[0-9]{8-11}$" title="El DNI debe contener 8 números y el RUC 11 números"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <button type="button" class="btn btn-warning" id="btnSearch"><i
                                        class="fa fa-search"></i></i></button>
                                <button type="button" class="btn btn-primary" id="openModalPeople"><i
                                        class="fa fa-search-plus"></i> Buscar</i></button>
                            </div>
                        </div>
                        <div class="card card-profile p-0 " id="profileCard">

                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="txt_Accountnumber">Numero de cuenta 1:</label>
                                    <div class="input-group">
                                        <input type="text" id="txt_Accountnumber" name="txt_Accountnumber" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label" for="txt_Accountnumber2">Numero de cuenta 2:</label>
                                    <div class="input-group">
                                        <input type="text" id="txt_Accountnumber2" name="txt_Accountnumber2" class="form-control">

                                    </div>
                                </div>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancel">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalListPeople" tabindex="-1" aria-labelledby="modalListPeopleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListPeopleLabel">Lista de Personas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                <div class="table-responsive">
                    <table id="table_people" class="table table-sm table-hover table-bordered w-100">
                        <input type="hidden" name="txtId" id="txtId">
                        <thead class="thead-light">
                            <tr>
                                <th>N° Documento</th>
                                <th>Nombre Completo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

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
<!-- Modal de Report -->
<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="modalReportLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold" id="modalReportLabel">Reporte del cliente</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Contenedor principal con foto y datos -->

                <div class="d-flex justify-content-between  align-items-center">
                    <!-- Nombre -->
                    <div>
                        <h3 class="text-uppercase font-weight-bold text-primary" id="reportTitle">Yeison Danner
                            Carhuapoma Dett</h3>
                    </div>
                    <!-- Foto de Perfil -->
                    <div>
                        <img id="reportPhotoProfile" src="ruta_imagen.jpg" class="img-thumbnail" width="100"
                            height="100" alt="Foto de usuario">
                    </div>
                </div>
                <!-- Datos Personales -->
                <h6 class="text-uppercase font-weight-bold text-danger mt-4">Datos de cliente</h6>
                <hr>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Código Cliente</strong></td>
                            <td id="reportCodeCustomer">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td id="reportSatusCustomer">12345678</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Datos Personales -->
                <h6 class="text-uppercase font-weight-bold text-danger mt-4">Datos personales</h6>
                <hr>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Nombres completos</strong></td>
                            <td id="reportFullname">12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Numero de documento</strong></td>
                            <td id="reportDni">12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de nacimiento</strong></td>
                            <td id="reportBirthdate">01/01/2000</td>
                        </tr>
                        <tr>
                            <td><strong>Género</strong></td>
                            <td id="reportGender">Masculino</td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td id="reportEmail">12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Teléfono</strong></td>
                            <td id="reportPhone">12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Dirección</strong></td>
                            <td id="reportAddress">12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Numero de cuenta 1</strong></td>
                            <td id="reportNumberAccount">123456785554</td>
                        </tr>
                        <tr>
                            <td><strong>Numero de cuenta 2</strong></td>
                            <td id="reportNumberAccount2">123456785554</td>
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

<!-- Modal Update -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalUpdateLabel">Registro del Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Registro de Trabajadores -->
                <div class="tile-body">
                    <form id="formUpdate" enctype="multipart/form-data" autocomplete="off">
                        <?= csrf(); ?>
                        <input type="hidden" name="update_txtId" id="update_txtId">
                        <input type="hidden" name="update_txtIdPeople" id="update_txtIdPeople">

                        <div class="form-group">
                            <label class="control-label" for="update_txtDni" hidden>DNI
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input class="form-control" type="text" id="update_txtDni" name="update_txtDni"
                                    placeholder="Ingrese el dni de una persona" maxlength="11" minlength="8"
                                    pattern="^[0-9]{8-11}$" title="El DNI debe contener 8 números y el RUC 11 números"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" hidden>

                            </div>
                        </div>
                        <div class="card card-profile p-0 " id="update_profileCard">

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label" for="update_txtAccountnumber">Numero de cuenta 1:</label>
                                <div class="input-group">
                                    <input type="text" id="update_txtAccountnumber" name="update_txtAccountnumber" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for="update_txtAccountnumber2">Numero de cuenta 2:</label>
                                <div class="input-group">
                                    <input type="text" id="update_txtAccountnumber2" name="update_txtAccountnumber2" class="form-control">
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="update_slctStatus">Estado <span
                                    class="text-danger">*</span>
                            </label>
                            <select class="form-control" id="update_slctStatus" name="update_slctStatus"
                                required>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
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