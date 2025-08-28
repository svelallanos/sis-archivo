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
<?= loadModalAdmin("management",$data) ?>
