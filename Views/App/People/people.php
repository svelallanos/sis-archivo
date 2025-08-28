<?= headerAdmin($data) ?>

<main class="app-content">
    <div class="app-title pt-5">
        <div>
            <h1><i class="fa fa-users" aria-hidden="true"></i> <?= $data["page_title"] ?></h1>
            <p><?= $data["page_description"] ?></p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-users" aria-hidden="true"></i></li>
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/product"><?= $data["page_title"] ?></a></li>
        </ul>
    </div>
    <div class="tile">
        <button id="openModalSave" class="btn btn-primary" type="button">
            Nuevo
            <i class="fa fa-plus"></i>
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
                                    <th>Perfil</th>
                                    <th>Razón Social</th>
                                    <th>T Doc.</th>
                                    <th>Documento</th>
                                    <th>Correo Electrónico</th>
                                    <th>Teléfono</th>
                                    <th>Fecha Registro</th>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalSaveLabel">Registrar Persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Registro de Roles -->
                <div class="tile-body">
                    <form id="formSave" enctype="multipart/form-data" autocomplete="off">
                        <?= csrf(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="control-label font-weight-bold mb-0">Seleccion un tipo de persona
                                    </label>
                                    <small class="form-text text-muted mt-0">
                                        Puedes seleccionar el registro de una persona jurídica con RUC 10 - 20 o persona natural con DNI de 8 dígitos.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkCompanyName" id="naturalName" value="NATURAL" checked>
                                            <label class="form-check-label font-weight-bold" for="naturalName">
                                                Natural
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkCompanyName" id="juridicaName" value="JURIDICA">
                                            <label class="form-check-label font-weight-bold" for="juridicaName">
                                                Jurídica
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="divName" class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtName">Nombre
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtName" name="txtName"
                                        placeholder="**" maxlength="255" minlength="4"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}$"
                                        title="El nombre debe contener entre 4 y 255 caracteres y solo incluir letras y espacios.">
                                    <small class="form-text text-muted">
                                        El nombre de la persona debe tener al menos 4 caracteres y solo puede incluir letras y espacios.
                                    </small>
                                </div>
                            </div>
                            <div id="divLastname" class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtLastname">Apellidos
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtLastname" name="txtLastname"
                                        placeholder="**" maxlength="255" minlength="4"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}$"
                                        title="El apellido debe contener entre 4 y 255 caracteres y solo incluir letras y espacios.">
                                    <small class="form-text text-muted">
                                        El apellido de la persona debe tener al menos 4 caracteres y solo puede incluir letras y espacios.
                                    </small>
                                </div>
                            </div>
                            <div id="divCompany" class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtCompanyName">Razón Social
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtCompanyName" name="txtCompanyName"
                                        placeholder="**" maxlength="255" minlength="4"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}$"
                                        title="El nombre debe contener entre 4 y 255 caracteres y solo incluir letras y espacios.">
                                    <small class="form-text text-muted">
                                        La razón social debe tener al menos 4 caracteres y solo puede incluir letras y espacios.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtnumberDocument">Número de Documento
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtnumberDocument" name="txtnumberDocument" required
                                        placeholder="" maxlength="11" minlength="8"
                                        pattern="^[0-9]{8,11}$"
                                        title="El Número de Documento debe contener entre 8 y 11 dígitos.">
                                    <small class="form-text text-muted">
                                        El Número de Documento de la persona debe tener entre 8 y 11 dígitos.
                                    </small>
                                </div>
                            </div>
                            <div id="divBirthdate" class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtBirthdate">Fecha de Nacimiento
                                        <span class="text-muted font-weight-normal">(opcional)</span>
                                    </label>
                                    <input class="form-control" type="date" id="txtBirthdate" name="txtBirthdate">
                                    <small class="form-text text-muted">
                                        La fecha de nacimiento es opcional.
                                    </small>
                                </div>
                            </div>
                            <div id="divGender" class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtGender">Género
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control" id="txtGender" name="txtGender" required>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtMail">Correo Electrónico
                                        <span class="text-muted font-weight-normal">(opcional)</span>
                                    </label>
                                    <input class="form-control" type="email" id="txtMail" name="txtMail"
                                        placeholder="ejemplo@dominio.com" maxlength="255"
                                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                        title="Por favor, ingrese un correo electrónico válido.">
                                    <small class="form-text text-muted">
                                        El correo electrónico es opcional y debe ser válido.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtPhone">Teléfono
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="tel" id="txtPhone" name="txtPhone" required
                                        placeholder="123456789" maxlength="9" minlength="9"
                                        pattern="^[0-9]{9}$"
                                        title="El teléfono debe contener exactamente 9 dígitos.">
                                    <small class="form-text text-muted">
                                        El teléfono de la persona debe tener exactamente 9 dígitos.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtAddress">Dirección
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtAddress" name="txtAddress" required
                                        placeholder="Ingrese su dirección" maxlength="255">
                                    <small class="form-text text-muted">
                                        La dirección es obligatoria.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label for="flPhoto" class="font-weight-bold mb-2">
                                        Cargar Perfil <small class="text-muted">(JPG, JPEG, PNG - máx. 2 MB)</small>
                                    </label>

                                    <!-- Área para soltar o seleccionar -->
                                    <div id="drop-area" class="custom-drop-area mb-3">
                                        <div class="text-center">
                                            <i class="fa fa-cloud-upload fa-2x text-primary mb-2"></i>
                                            <p class="text-muted mb-2">Arrastra una imagen aquí o haz clic para seleccionarla</p>
                                            <button type="button" id="fileSelectBtn" class="btn btn-outline-primary btn-sm">
                                                Seleccionar imagen
                                            </button>
                                        </div>
                                        <input type="file" id="flPhoto" name="flPhoto" accept="image/*" hidden>
                                    </div>

                                    <!-- Vista previa -->
                                    <div id="preview-container" class="d-flex align-items-center">
                                        <img id="imgNewProfile" src="" alt="Previsualización" class="img-preview mr-3" style="display: none;">
                                        <div>
                                            <p id="fileName" class="file-name" style="display: none;"></p>
                                            <button type="button" id="btnRemoveImage" class="btn btn-outline-danger btn-sm" style="display: none;">
                                                <i class="fa fa-trash mr-1"></i> Eliminar imagen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtComment">Comentario
                                        <span class="text-muted font-weight-normal">(opcional)</span>
                                    </label>
                                    <textarea class="form-control" type="text" id="txtComment" name="txtComment" placeholder="Ingrese su comentario" maxlength="100" minlength="4" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,100}$"></textarea>
                                    <small class="form-text text-muted">
                                        El comentario debe tener al menos 4 caracteres y solo puede incluir letras,
                                        números, espacios, guiones altos y bajos.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fa fa-fw fa-lg fa-check-circle"></i> Registrar
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
<!-- Modal Update-->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalUpdateLabel">Actualizar información de la Persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de Actualizacion de Usuario -->
                <div class="tile-body">
                    <form id="formUpdate" autocomplete="off">
                        <?= csrf(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label class="control-label font-weight-bold mb-0">Seleccione un tipo de persona
                                    </label>
                                    <small class="form-text text-muted mt-0">
                                        Puedes seleccionar el registro de una persona jurídica con RUC 10 - 20 o persona natural con DNI de 8 dígitos.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkCompanyNameUpdate" id="naturalNameUpdate" value="NATURAL" checked>
                                            <label class="form-check-label font-weight-bold" for="naturalNameUpdate">
                                                Natural
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="checkCompanyNameUpdate" id="juridicaNameUpdate" value="JURIDICA">
                                            <label class="form-check-label font-weight-bold" for="juridicaNameUpdate">
                                                Jurídica
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="divNameUpdate" class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtNameUpdate">Nombre
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtNameUpdate" name="txtNameUpdate"
                                        placeholder="**" maxlength="255" minlength="4"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}$"
                                        title="El nombre debe contener entre 4 y 255 caracteres y solo incluir letras y espacios.">
                                    <small class="form-text text-muted">
                                        El nombre de la persona debe tener al menos 4 caracteres y solo puede incluir letras y espacios.
                                    </small>
                                </div>
                            </div>
                            <div id="divLastnameUpdate" class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtLastnameUpdate">Apellidos
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtLastnameUpdate" name="txtLastnameUpdate"
                                        placeholder="**" maxlength="255" minlength="4"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}$"
                                        title="El apellido debe contener entre 4 y 255 caracteres y solo incluir letras y espacios.">
                                    <small class="form-text text-muted">
                                        El apellido de la persona debe tener al menos 4 caracteres y solo puede incluir letras y espacios.
                                    </small>
                                </div>
                            </div>
                            <div id="divCompanyUpdate" class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtCompanyNameUpdate">Razón Social
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtCompanyNameUpdate" name="txtCompanyNameUpdate"
                                        placeholder="**" maxlength="255" minlength="4"
                                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,255}$"
                                        title="El nombre debe contener entre 4 y 255 caracteres y solo incluir letras y espacios.">
                                    <small class="form-text text-muted">
                                        La razón social debe tener al menos 4 caracteres y solo puede incluir letras y espacios.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtNumberDocumentUpdate">Número de Documento
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtNumberDocumentUpdate" name="txtNumberDocumentUpdate" required
                                        placeholder="" maxlength="11" minlength="8"
                                        pattern="^[0-9]{8,11}$"
                                        title="El Número de Documento debe contener entre 8 y 11 dígitos.">
                                    <small class="form-text text-muted">
                                        El Número de Documento de la persona debe tener entre 8 y 11 dígitos.
                                    </small>
                                </div>
                            </div>
                            <div id="divBirthdateUpdate" class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtBirthdateUpdate">Fecha de Nacimiento
                                        <span class="text-muted font-weight-normal">(opcional)</span>
                                    </label>
                                    <input class="form-control" type="date" id="txtBirthdateUpdate" name="txtBirthdateUpdate">
                                    <small class="form-text text-muted">
                                        La fecha de nacimiento es opcional.
                                    </small>
                                </div>
                            </div>
                            <div id="divGenderUpdate" class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtGenderUpdate">Género
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control" id="txtGenderUpdate" name="txtGenderUpdate" required>
                                        <option value="MASCULINO">Masculino</option>
                                        <option value="FEMENINO">Femenino</option>
                                        <option value="OTRO">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtMailUpdate">Correo Electrónico
                                        <span class="text-muted font-weight-normal">(opcional)</span>
                                    </label>
                                    <input class="form-control" type="email" id="txtMailUpdate" name="txtMailUpdate"
                                        placeholder="ejemplo@dominio.com" maxlength="255"
                                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                        title="Por favor, ingrese un correo electrónico válido."
                                        aria-describedby="emailHelp">
                                    <small id="emailHelp" class="form-text text-muted">
                                        El correo electrónico es opcional y debe ser válido.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtPhoneUpdate">Teléfono
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="tel" id="txtPhoneUpdate" name="txtPhoneUpdate" required
                                        placeholder="123456789" maxlength="9" minlength="9"
                                        pattern="^[0-9]{9}$"
                                        title="El teléfono debe contener exactamente 9 dígitos.">
                                    <small class="form-text text-muted">
                                        El teléfono de la persona debe tener exactamente 9 dígitos.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtAddressUpdate">Dirección
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="text" id="txtAddressUpdate" name="txtAddressUpdate" required
                                        placeholder="Ingrese su dirección" maxlength="255">
                                    <small class="form-text text-muted">
                                        La dirección es obligatoria.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="flPhoto" class="font-weight-bold mb-2">
                                        Cargar Imagen <small class="text-muted">(JPG, JPEG, PNG - máx. 2 MB)</small>
                                    </label>

                                    <!-- Área para soltar o seleccionar -->
                                    <div id="drop-area_update" class="custom-drop-area mb-3">
                                        <div class="text-center">
                                            <i class="fa fa-cloud-upload fa-2x text-primary mb-2"></i>
                                            <p class="text-muted mb-2">Arrastra una imagen aquí o haz clic para seleccionarla</p>
                                            <button type="button" id="fileSelectBtn_update" class="btn btn-outline-primary btn-sm">
                                                Seleccionar imagen
                                            </button>
                                        </div>
                                        <input type="file" id="flPhoto_update" name="flPhoto_update" accept="image/*" hidden>
                                    </div>

                                    <!-- Vista previa -->
                                    <div id="preview-container_update" class="d-flex align-items-center">
                                        <img id="imgNewProfile_update" src="" alt="Previsualización" class="img-preview mr-3" style="display: none;">
                                        <div>
                                            <p id="fileName_update" class="file-name" style="display: none;"></p>
                                            <button type="button" id="btnRemoveImage_update" class="btn btn-outline-danger btn-sm" style="display: none;">
                                                <i class="fa fa-trash mr-1"></i> Eliminar imagen
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtCommentUpdate">Comentario
                                        <span class="text-muted font-weight-normal">(opcional)</span>
                                    </label>
                                    <textarea class="form-control" type="text" id="txtCommentUpdate" name="txtCommentUpdate" placeholder="Ingrese su comentario" maxlength="100" minlength="4" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{4,100}$"></textarea>
                                    <small class="form-text text-muted">
                                        El comentario debe tener al menos 4 caracteres y solo puede incluir letras,
                                        números, espacios, guiones altos y bajos.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtStatusUpdate">Estado
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control" id="txtStatusUpdate" name="txtStatusUpdate" required>
                                        <option value="ACTIVO">Activo</option>
                                        <option value="INACTIVO">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button class="btn btn-success btn-block" type="submit">
                                <i class="fa-solid fa-check-double"></i> Actualizar</button>
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
<!-- Modal de View -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title font-weight-bold" id="modalViewLabel">Vista de la Persona</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Contenedor principal con foto y datos -->
                <div class="d-flex justify-content-center  align-items-center">
                    <h3 class="text-uppercase font-weight-bold text-primary" id="txtFullView">Título del registro</h3>
                </div>
                <!-- Datos Personales -->
                <h6 class="text-uppercase font-weight-bold text-danger mt-4">Información de la persona</h6>
                <hr>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td><strong>Tipo de persona</strong></td>
                            <td id="txtTypePeopleView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Razón Social</strong></td>
                            <td id="txtCompanyNameView">#12345678</td>
                        <tr>
                            <td><strong>Código</strong></td>
                            <td id="txtIdView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>N° Doc</strong></td>
                            <td id="txtNumberDocumentView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha de Nacimiento</strong></td>
                            <td id="txtBirthdateView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Sexo</strong></td>
                            <td id="txtGenderView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Correo Electrónico</strong></td>
                            <td id="txtMailView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Teléfono</strong></td>
                            <td id="txtPhoneView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Dirección</strong></td>
                            <td id="txtAddressView">#12345678</td>
                        </tr>
                        <tr>
                            <td><strong>Estado</strong></td>
                            <td id="">
                                <h5 class="m-0">
                                    <badge id="txtStatusView" class="badge text-white">New!</badge>
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Imagen</strong></td>
                            <td><img class="img-view" id="txtImgView" src="" alt="Imagen de la persona"></td>
                        </tr>
                    </tbody>
                </table>
                <!-- Datos de registro: Fecha de registro y actualización -->
                <div class="p-3 bg-light border rounded">
                    <p class="text-muted mb-1">
                        <strong>Fecha de registro:</strong> <span class="text-dark"
                            id="txtDateRegistrationView">29/01/2025</span>
                    </p>
                    <p class="text-muted mb-0">
                        <strong>Fecha de actualización:</strong> <span class="text-dark"
                            id="txtDateUpdateView">29/01/2025</span>
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