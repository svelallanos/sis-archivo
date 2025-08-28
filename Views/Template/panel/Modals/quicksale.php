<!-- Sección de Modals -->
<!-- Modal de Add Product -->
<div class="modal fade" id="modalRegisterSales" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-blue text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Registrar Nueva Venta</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-2">
                <div class="row">
                    <div class="col-md-9 overflow-auto" style="max-height: calc(100vh - 200px);">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold" for="txtCodProduct"><i
                                                        class="fa-solid fa-barcode"></i>&nbsp;Producto
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="txtCodProduct"
                                                       name="txtCodProduct"
                                                       placeholder="Ingrese el código del producto"
                                                       aria-label="Ingrese el código del producto"
                                                       aria-describedby="btnSearchProduct" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning" type="button"
                                                            id="btnSearchProduct">Buscar
                                                    </button>
                                                    <button class="btn btn-danger px-3" type="button"
                                                            id="openModalProduct"><i
                                                                class="fa-solid fa-magnifying-glass"></i>
                                                    </button>
                                                    <button title="limpiar producto" type="button"
                                                            id="cleanProduct"
                                                            class="px-3 btn btn-dark text-danger"><i
                                                                class="fa-solid fa-broom"></i></button>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                Ingrese el lote o sku y luedo da click en buscar para buscar un
                                                producto.
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-group-sm">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtProduct">Producto
                                                    </label>
                                                    <input disabled
                                                           class="bg-white form-control form-control-sm"
                                                           type="text" id="txtProduct" name="txtProduct">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group form-group-sm">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtPresentation">Presentación
                                                    </label>
                                                    <input disabled
                                                           class="bg-white form-control form-control-sm"
                                                           type="text" id="txtPresentation"
                                                           name="txtPresentation">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-sm">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtSku">SKU
                                                    </label>
                                                    <input disabled
                                                           class="bg-white form-control form-control-sm"
                                                           type="text" id="txtSku" name="txtSku">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-group-sm">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtLote">Lote
                                                    </label>
                                                    <input disabled
                                                           class="bg-white form-control form-control-sm"
                                                           type="text" id="txtLote" name="txtLote">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtPrice">P. Compra S/
                                                    </label>
                                                    <input disabled style="text-align: center;"
                                                           class="bg-white form-control form-control-sm"
                                                           type="number" id="txtPricePurchase" name="txtPricePurchase"
                                                           required
                                                           min="1" step="0.01" max="10000">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtPrice">P. Venta S/ <span class="text-danger">*</span>
                                                    </label>
                                                    <input disabled style="text-align: center;"
                                                           class="bg-white form-control form-control-sm"
                                                           type="number" id="txtPrice" name="txtPrice" required
                                                           min="0" step="0.01" max="10000">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtDiscount">Descuento S/
                                                        <!-- <span class="text-danger">*</span> -->
                                                    </label>
                                                    <input disabled style="text-align: center;"
                                                           class="bg-white form-control form-control-sm"
                                                           type="number" id="txtDiscount" name="txtDiscount"
                                                           required min="1" step="0.01" max="10000">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtQuantity">Cantidad
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input disabled style="text-align: center;"
                                                           class="bg-white form-control form-control-sm"
                                                           type="number" id="txtQuantity" name="txtQuantity"
                                                           required min="1" max="10000">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtStock">Stock
                                                    </label>
                                                    <input disabled style="text-align: center;"
                                                           class="bg-white form-control form-control-sm"
                                                           type="number" id="txtStock" name="txtStock" required
                                                           min="1" max="10000">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold mb-0"
                                                           for="txtSupplier">Proveedor
                                                    </label>
                                                    <input disabled class="bg-white form-control form-control-sm"
                                                           type="text" id="txtSupplier" name="txtSupplier" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label font-weight-bold"
                                                           for="txtStore">Almacén
                                                    </label>
                                                    <p id="txtStore"><i class="text-muted">Sin especificar</i>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-end">
                                                <div class="form-group">
                                                    <button id="btnAddProducttable" class="btn btn-success"
                                                            type="button"><i
                                                                class="fa-solid fa-check-double"></i> Agregar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-success alert-dismissible fade show p-2" role="alert">
                                            <strong><i class="fa-solid fa-truck-ramp-box"></i> DETALLE DE
                                                VENTA:</strong> Lista de productos agregados para la venta.
                                        </div>
                                        <table class="table table-sm table-striped table-bordered">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th class="col-4">Producto</th>
                                                <th class="col-1">Lote</th>
                                                <th class="col-1">Compra</th>
                                                <th class="col-1">P. Venta</th>
                                                <!--                                                <th class="col-1">Desc.</th>-->
                                                <th class="col-1">Cantidad</th>
                                                <th class="col-2">Total</th>
                                                <th class="col-1">Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tableProduct">
                                            </tbody>
                                            <thead id="footTableProduct" class="thead-light">
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2 d-none" id="dataAdvances">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info alert-dismissible fade show p-2" role="alert">
                                            <strong><i class="fa-solid fa-triangle-exclamation"></i> NOTA:</strong> Este
                                            <b>cliente</b>
                                            tiene adelantos pendientes, puede agregar a la venta los productos
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="mb-0 table table-sm table-bordered">
                                            <thead class="thead-light">
                                            <tr>
                                                <th class="text-center" scope="col">
                                                    <div class="form-check">
                                                        <input id="__checkAll"
                                                               class="form-check-input position-static"
                                                               type="checkbox" aria-label="...">
                                                    </div>
                                                </th>
                                                <th scope="col">#</th>
                                                <th class="col-6 text-center">Producto</th>
                                                <th class="col-1 text-center">Presentación</th>
                                                <th class="col-1 text-center">Cantidad</th>
                                                <th class="col-2 text-center">Monto</th>
                                                <th class="col-2 text-center">Estado</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tableAdvances">
                                            </tbody>
                                            <thead id="footTableAdvances" class="thead-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th class="col-6">Total</th>
                                                <th class="col-1"></th>
                                                <th class="col-1">0</th>
                                                <th class="col-2">S/ 0.00</th>
                                                <th class="col-2"></th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 overflow-auto" style="max-height: calc(100vh - 200px);">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-solid fa-chalkboard-user"></i> Cliente :</strong> Información
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtNumberDocument">RUC/DNI
                                        (Cliente)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" data-idcustomer=""
                                               id="txtNumberDocument" name="txtNumberDocument"
                                               placeholder="Ingrese número" aria-label="Ingrese número"
                                               aria-describedby="btnSearchCustomer" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-warning" type="button"
                                                    id="btnSearchCustomer">Buscar
                                            </button>
                                            <button class="btn btn-danger px-2" type="button"
                                                    id="searchCustomer"><i
                                                        class="fa-solid fa-magnifying-glass"></i></button>
                                            <button title="limpiar cliente" type="button" id="cleanCustomer"
                                                    class="px-2 btn btn-dark text-danger"><i
                                                        class="fa-solid fa-broom"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Datos consultados del cliente -->
                            <div class="col-md-12 d-none" id="dataCompanyName">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtCompanyName">Razón
                                        Social
                                    </label>
                                    <h5 id="txtCompanyName" class="font-weight-bold text-muted"></h5>
                                </div>
                            </div>
                            <div class="col-md-12 d-none" id="dataAddress">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtAddressCustomer">Dirección
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="txtAddressCustomer"
                                           name="txtAddressCustomer"
                                           placeholder="Ingrese la dirección del cliente" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-regular fa-file-lines"></i> Comprobante :</strong> Datos
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtDocType">Tipo de
                                        Comprobante.
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control form-control" id="txtDocType" name="txtDocType"
                                            required>
                                        <option disabled>Seleccione tipo de comprobante.</option>
                                        <option value="RECIBO" selected>Recibo</option>
                                        <option value="FACTURA">Factura</option>
                                        <option value="BOLETA">Boleta</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtPaymentType">Forma de
                                        Pago
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control form-control" id="txtPaymentType"
                                            name="txtPaymentType" required>
                                        <option disabled>Seleccione forma de pago.</option>
                                        <option value="YAPE">Yape</option>
                                        <option value="PLIN">Plin</option>
                                        <option value="TRANSFERENCIA">Transferencia</option>
                                        <option value="EFECTIVO" selected>Efectivo</option>
                                        <option value="OTROS">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h5 class="control-label font-weight-bold">Total a pagar</h5>
                                <div class="card">
                                    <div class="card-body p-3">
                                        <h2 class="card-title text-primary" id="textAmount">S/ 0.00</h2>
                                        <div class="form-group">
                                            <label class="control-label font-weight-bold" for="amount">Con
                                                cuanto paga
                                                <span class="text-danger">*</span>
                                            </label>S/.
                                            <input disabled style="text-align: center;"
                                                   class="bg-white form-control form-control-lg" type="number"
                                                   id="amount" name="amount" required min="1" step="0.01"
                                                   max="10000">
                                        </div>
                                        <div class="form-group mb-0">
                                            <label class="control-label font-weight-bold">Vuelto
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div id="turned">
                                                <p class="mb-0"><i class="text-muted">Ingrese monto</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie del modal -->
            <div class="modal-footer">
                <?= csrf(); ?>
                <button type="button" id="saveSale" class="btn btn-success">
                    <i class="fa-solid fa-angles-right mr-1"></i> Generar venta
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Add Customers -->
<div class="modal fade" id="modalAddCustomer" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-light text-dark">
                <h5 class="modal-title" id="staticBackdropLabel">Buscar Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="inputSearchCustomer"
                                       placeholder="Buscar ..." aria-label="Recipient's username"
                                       aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-warning px-2" type="button" id="button-addon2"><i
                                                class="fa-solid fa-broom"></i></button>
                                </div>
                            </div>
                            <small id="emailHelp" class="form-text text-muted">Ingrese nombre del cliente.</small>
                        </div>
                    </div>
                    <div id="resultCustomer" class="col-md-12">
                        <p class="mb-0"><i class="text-muted">No se encontraron resultados</i></p>
                        <!-- <div class="card mb-2 __selectClient">
                            <div class="card-body p-2 d-flex">
                                <img src="<?= base_url() . "/loadfile/people/?f=clientes.png" ?>"
                                    alt="Avatar" class="" width="50" height="50">
                                <div class="ml-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-check text-success"></i>&nbsp;
                                        <h5 class="card-title mb-1"><i>Municipalidad Distrital De Elías Soplín Vargas</i></h5>
                                    </div>
                                    <p class="card-text mb-1"><i class="fa-solid fa-check text-success"></i>&nbsp;<i>20187362840</i></p>
                                    <small class="text-muted"><i class="fa-solid fa-phone text-success"></i>&nbsp;<i>924601283</i></small>
                                </div>p
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal list Product -->
<div class="modal fade" id="modalListProduct" tabindex="-1" aria-labelledby="modalListProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border: 2px solid #b49d02;">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalListProductLabel">Lista de Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                <div class="table-responsive">
                    <table id="table_product" class="table table-sm table-hover table-bordered w-100">
                        <thead>
                        <tr>
                            <th class="text-center">SKU</th>
                            <th>Producto</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">P. Compra</th>
                            <th class="text-center">P. Venta</th>
                            <th class="text-center">Lote</th>
                            <th>Proveedor</th>
                            <th>Almacén</th>
                            <th class="text-center">Acción</th>
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
<!-- Modal para ver el detalle de la venta-->
<div class="modal fade" id="modalViewDocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content shadow-sm elegant-style">
            <!-- Header -->
            <div class="modal-header border-bottom-0 bg-blue py-3 px-4">
                <h5 class="modal-title text-white font-weight-bold mb-0">
                    Venta <span class="text-primary" id="saleNumber">#000123</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Body -->
            <div class="modal-body p-4">
                <div class="row">
                    <!-- COL IZQUIERDA: Productos + Adelantos + Totales -->
                    <div class="col-md-9">
                        <!-- Productos -->
                        <div class="mb-4">
                            <h6 class="text-muted font-weight-bold mb-3">Productos</h6>
                            <div class="table-responsive">
                                <table id="detailsTable" class="table table-sm table-borderless">
                                    <thead class="thead-light">
                                    <tr class="text-uppercase small text-muted">
                                        <th>#</th>
                                        <th>Almacén</th>
                                        <th>Lote</th>
                                        <th>Producto</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-right">Precio</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <thead class="thead-light" id="detailsTableTotal">
                                    <tr class="text-uppercase small text-muted">
                                        <th>::::</th>
                                        <th>Total</th>
                                        <th class="text-center"></th>
                                        <th class="text-right"></th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- Adelantos -->
                        <div class="mb-4">
                            <h6 class="text-muted font-weight-bold mb-3">Adelantos</h6>
                            <div id="divAdvances" class="table-responsive">
                                <table id="advancesTable" class="table table-sm table-borderless">
                                    <thead class="thead-light">
                                    <tr class="text-uppercase small text-muted">
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th>Fecha</th>
                                        <th>Cantidad</th>
                                        <th>Monto</th>
                                        <th>Método</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                    <thead class="thead-light" id="advancesTableTotal">
                                    <tr class="text-uppercase small text-muted">
                                        <th>::::</th>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Método</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- Totales -->
                        <div class="text-right mt-4">
                            <h6 class="text-dark">
                                Sub Total: <span class="text-muted" id="totalAmount">S/ 500.00</span>
                            </h6>
                            <h6 class="text-dark">
                                Adelanto: <span id="adelantoTotal">S/ 990.00</span>
                            </h6>
                            <h6 class="text-dark">
                                Impuesto (IGV 18%): <span class="text-muted" id="">S/ 0.00</span>
                            </h6>
                            <h6 class="text-dark">
                                Descuento: <span class="text-muted" id="">S/ 0.00</span>
                            </h6>
                            <h5 class="text-dark">
                                Total a Pagar: <span class="text-info" id="importeTotal">S/ 990.00</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center p-2">
                                <img id="imgCustomer" src="<?= base_url() ?>/loadfile/people/?f=clientes.png"
                                     class="rounded-circle mb-3 shadow-sm border" width="80" height="80"
                                     alt="Foto cliente">

                                <h5 class="mb-0 font-weight-bold" id="customerName">Angelica Ramos</h5>
                                <small class="text-muted" id="customerComment">The Wiz</small><br>
                                <div id="customerStatus">
                                    <span class="badge badge-success">Cliente activo</span>
                                </div>
                                <div class="mt-2 text-left">
                                    <p class="mb-1" id="customerDocument"><i class="fa fa-id-card text-muted mr-2"></i>DNI:
                                        <span class="text-dark">48692713</span></p>
                                    <p class="mb-1" id="customerPhone"><i class="fa fa-phone text-muted mr-2"></i><span
                                                class="text-dark">+51 999 999 999</span></p>
                                    <p class="mb-1" id="customerEmail"><i
                                                class="fa fa-envelope text-muted mr-2"></i><span class="text-dark">angelica@ramos.com</span>
                                    </p>
                                    <p id="customerAddress"><i class="fa fa-map-marker-alt text-muted mr-2"></i><span
                                                class="text-dark">Av. Principal 123</span></p>
                                </div>

                                <hr>
                                <!-- Info Venta -->
                                <div class="text-left">
                                    <p class="mb-1"><i class="fa fa-calendar-alt text-muted mr-2"></i>Fecha: <span
                                                class="text-dark" id="saleDate">22/07/2025</span></p>
                                    <p class="mb-1"><i class="fa fa-credit-card text-muted mr-2"></i>Método de pago:
                                        <span class="text-dark" id="paymentMethod">Yape</span></p>
                                    <p class="mb-1"><i class="fa fa-file-invoice-dollar text-muted mr-2"></i>N°
                                        Documento: <span class="text-dark" id="documentNumber">F2025-00123</span></p>
                                    <div class="mb-3 text-center" id="saleStatus">
                                        <span class="badge badge-success">Cliente activo</span>
                                    </div>
                                </div>
                                <button type="button" data-document_id="" id="btnPrintVoucher"
                                        class="btn btn-outline-danger btn-sm">
                                    <i class="fa fa-print mr-1"></i> Imprimir recibo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para anular la venta-->
<div class="modal fade" id="modalCancelSale" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para imprimir el recibo -->
<div class="modal fade" id="modalPrintDocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font-weight-bold">Generar Comprobante</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body p-0" style="height: 85vh;">
                <iframe src="#" frameborder="0" style="width:100%; height:100%;" id="iframeComprobante"></iframe>
            </div>
        </div>
    </div>
</div>