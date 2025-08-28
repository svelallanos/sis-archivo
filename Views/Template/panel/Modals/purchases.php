<!-- Sección de Modals -->
<!-- Modal para registrar una compra -->
<div class="modal fade" id="modalRegisterPurchase" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content shadow-sm elegant-style">
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 bg-blue py-3 px-4">
                <h5 class="modal-title text-white font-weight-bold mb-0">
                    Registrar Compra
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Cuerpo -->
            <div class="modal-body p-3">
                <div class="row">
                    <!-- Columna izquierda: resumen -->
                    <div class="col-md-9 overflow-auto" style="max-height: calc(100vh - 200px);">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtProduct"><i
                                                class="fa-solid fa-barcode"></i>&nbsp;Producto
                                    </label>
                                    <div class="input-group">
                                        <input disabled type="text" class="form-control bg-white" id="txtProduct"
                                               name="txtProduct" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-warning px-2" type="button" id="openModalProduct"><i
                                                        class="fa-solid fa-magnifying-glass"></i> Buscar
                                            </button>
                                            <button title="limpiar producto" onclick="cleanFormProduct()" type="button"
                                                    class="btn btn-dark text-danger"><i class="fa-solid fa-broom"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">
                                        Da click en BUSCAR un producto.
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="sku">Código (SKU)
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="text"
                                                   id="sku" name="sku">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="unit_of_measure">Unidad
                                                de Medida
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="text"
                                                   id="unit_of_measure" name="unit_of_measure">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="div_presentation">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="presentation">Presentación
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="text"
                                                   id="presentation" name="presentation">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="sack_count">Cant. de
                                                Sacos
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="number"
                                                   min="0" id="sack_count" name="sack_count">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="div_gross_weight">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="gross_weight">Peso
                                                (Kg)
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="number"
                                                   min="0" step="0.01" id="gross_weight" name="gross_weight">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="div_sack_weight">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="sack_weight">Tara x
                                                Saco (Kg)
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="number"
                                                   min="0" step="0.01" id="sack_weight" name="sack_weight">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group form-group-sm">
                                            <label class="control-label font-weight-bold mb-1" for="price">Precio S/
                                                <span class="text-danger">*</span></label>
                                            <input disabled class="bg-white form-control form-control-sm" type="number"
                                                   min="0" step="0.01" id="price" name="price">
                                        </div>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button disabled id="btnAddProducttable" class="btn btn-sm btn-success"
                                                    type="button"><i class="fa-solid fa-check-double"></i> Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-solid fa-truck-ramp-box"></i> CARRITO DE COMPRA:</strong> Lista
                                    de productos
                                    agregados a la compra.
                                </div>
                                <!-- Tabla de productos -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover" id="purchaseDetailTable">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Producto</th>
                                            <th>U.M.</th>
                                            <th>Presentación</th>
                                            <th>Precio</th>
                                            <th>Peso total</th>
                                            <th>Tara</th>
                                            <th>Cant. Sacos</th>
                                            <th>Peso Neto</th>
                                            <th>Total</th>
                                            <th>Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody id="purchaseTableBody"></tbody>
                                        <thead id="purchaseTableFooter" class="thead-light">
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>S/ 0.00</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="alert alert-info alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-solid fa-triangle-exclamation"></i> Nota:</strong> Agregue si
                                    tiene los gastos operativos de la compra.
                                </div>
                                <div class="border border-success rounded p-2 w-100">
                                    <button id="btn_add_fill_payment" class="btn btn-sm btn-warning" type="button">
                                        Agregar pago por llenada
                                    </button>
                                    <button id="btn_add_personal_payment" class="btn btn-sm btn-info" type="button">
                                        Agregar pago de personal
                                    </button>
                                    <button id="btn_add_other_payment" class="btn btn-sm btn-light border"
                                            type="button">Otros
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- Tabla de productos -->
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover table-bordered" id="purchaseDetailTable">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="col-9">Tipo de Gasto</th>
                                            <th class="col-2 text-center">Monto (S/)</th>
                                            <th class="col-1 text-center">Acción</th>
                                        </tr>
                                        </thead>
                                        <tbody id="operatingExpensesTableBody">
                                        </tbody>
                                        <thead id="operatingExpensesTableFooter" class="thead-light">
                                        <tr>
                                            <th>Total</th>
                                            <th>S/ 0.00</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12" id="div_tableLoans">
                                <div class="alert alert-warning alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-solid fa-triangle-exclamation"></i> Alerta:</strong> Este <b>proveedor</b>
                                    tiene préstamos pendientes, por favor verifique los montos y pagos.
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="col-1 text-center">
                                                ::.::
                                            </th>
                                            <th class="col-2">Monto</th>
                                            <th class="col-2">Fecha Prestamo</th>
                                            <th class="col-1">Meses</th>
                                            <th class="col-1">Días</th>
                                            <th class="col-1 text-center">TNA</th>
                                            <th class="col-2">Interes</th>
                                            <th class="col-2">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tableLoansBody">
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-check">
                                                    <input id="__checkAll" class="form-check-input position-static"
                                                           type="checkbox" aria-label="...">
                                                </div>
                                            </td>
                                            <td>S/ 100.00</td>
                                            <td>2025-12-25</td>
                                            <td>2</td>
                                            <td>18</td>
                                            <td class="text-center"><span class="badge badge-info">5%</span></td>
                                            <td>S/ 115.00</td>
                                            <td>S/ 115.00</td>
                                        </tr>
                                        </tbody>
                                        <thead id="tableLoansFooter" class="thead-light">
                                        <tr>
                                            <th class="col-1"></th>
                                            <th class="col-2">Total</th>
                                            <th class="col-2"></th>
                                            <th class="col-1"></th>
                                            <th class="col-1"></th>
                                            <th class="col-1 text-center"></th>
                                            <th class="col-2"></th>
                                            <th class="col-2">S/ 0.00</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Columana derecha: Proveedor  -->
                    <div class="col-md-3 overflow-auto" style="max-height: calc(100vh - 200px);">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-solid fa-chalkboard-user"></i> Proveedor :</strong> Información
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="txtNumberDocument">RUC/DNI
                                        (Proveedor)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" data-idcustomer=""
                                               id="txtNumberDocument" name="txtNumberDocument"
                                               placeholder="Ingrese número" aria-label="Ingrese número"
                                               aria-describedby="btnSearchSupplier" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-warning" type="button" id="btnSearchSupplier">
                                                Buscar
                                            </button>
                                            <button class="btn btn-danger px-2" type="button" id="openModalSupplier"><i
                                                        class="fa-solid fa-magnifying-glass"></i></button>
                                            <button title="limpiar proveedor" type="button"
                                                    onclick="cleanFormSupplier()" class="btn btn-dark text-danger"><i
                                                        class="fa-solid fa-broom"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="div_razon_social">
                                <div class="form-group mb-2">
                                    <label class="control-label font-weight-bold mb-1" for="razon_social">Razón Social
                                    </label>
                                    <input disabled type="text" class="form-control bg-white form-control-sm"
                                           name="razon_social" id="razon_social">
                                </div>
                            </div>
                            <div class="col-md-12" id="div_address">
                                <div class="form-group mb-2">
                                    <label class="control-label font-weight-bold mb-1" for="address">Dirección
                                    </label>
                                    <input disabled type="text" class="form-control bg-white form-control-sm"
                                           name="address" id="address">
                                </div>
                            </div>
                            <div class="col-md-12" id="div_account_number">
                                <div class="form-group mb-2">
                                    <label class="control-label font-weight-bold mb-1" for="account_number">Nro. Cuenta
                                        (CCI) <span class="text-muted">(Opcional)</span>
                                    </label>
                                    <input disabled type="text" class="form-control bg-white form-control-sm"
                                           name="account_number" id="account_number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-info alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-regular fa-file-lines"></i> Comprobante :</strong> Orden de
                                    Compra
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold mb-1" for="date_purchase">Fecha de
                                        Compra
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" class="form-control form-control-sm"
                                           name="date_purchase" id="date_purchase" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="border rounded border-success p-3">
                                    <div class="form-group">
                                        <label class="control-label font-weight-bold mb-1" for="total_to_pay">TOTAL A
                                            PAGAR
                                        </label>
                                        <input value="S/ 0.00" type="text"
                                               class="text-info font-weight-bold bg-white form-control form-control-lg"
                                               name="total_to_pay" id="total_to_pay" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- Comentario -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold" for="comment">Comentario
                                        <span class="text-muted">(Opcional)</span>
                                    </label>
                                    <textarea name="comment" id="comment" rows="2" class="form-control"
                                              placeholder="Notas u observaciones..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pie del modal -->
            <div class="modal-footer">
                <button type="button" id="btnRegisterPurchase" class="btn btn-success">
                    <i class="fa fa-save mr-1"></i> Guardar Compra
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para listar productos -->
<div class="modal fade" id="modalListProduct" tabindex="-1" aria-labelledby="modalListProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListProductLabel">Lista de Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                <div class="table-responsive">
                    <table id="tableProducts" class="table table-sm table-hover table-bordered w-100">
                        <thead>
                        <tr>
                            <th class="text-center">SKU</th>
                            <th>Producto</th>
                            <th class="text-center">U.M</th>
                            <th class="text-center">Presentación</th>
                            <th class="text-center">Acciones</th>
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
<!-- Modal para calcular pago de llenado de sacos -->
<div class="modal fade" id="modalFillSacks" tabindex="-1" aria-labelledby="modalFillSacksLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-blue text-white">
                <h5 class="modal-title" id="modalFillSacksLabel">Pago Llenado de Sacos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label font-weight-bold" for="sack_count_fill">Cantidad <span
                                    class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="sack_count_fill" id="sack_count_fill" min="0"
                               placeholder="Ingrese la cantidad de sacos">
                        <small class="form-text text-muted">
                            Ingrese la cantidad de sacos a calcular
                        </small>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label font-weight-bold mb-1" for="price_fill">Precio S/ <span
                                    class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="price_fill" id="price_fill" min="0" step="0.01"
                               placeholder="Ingrese el precio por saco">
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button id="add_fill_payment" type="button" class="btn btn-success"><i
                            class="fa-solid fa-angles-right"></i> Agregar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para calcular pago de personal -->
<div class="modal fade" id="modalPersonalPayment" tabindex="-1" aria-labelledby="modalPersonalPaymentLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-blue text-white">
                <h5 class="modal-title text-white" id="modalPersonalPaymentLabel">Pago Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label font-weight-bold mb-1" for="people_count">Cantidad <span
                                    class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="people_count" id="people_count" min="0"
                               placeholder="Ingrese la cantidad de personas">
                        <small class="form-text text-muted">
                            Ingrese la cantidad de personas a pagar.
                        </small>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label font-weight-bold" for="people_price">Monto S/ <span
                                    class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="people_price" id="people_price" min="0"
                               step="0.01" placeholder="Ingrese el monto a pagar a cada persona">
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button id="add_personal_payment" type="button" class="btn btn-success"><i
                            class="fa-solid fa-angles-right"></i> Agregar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para agregar otros pagos -->
<div class="modal fade" id="modalOtherPayment" tabindex="-1" aria-labelledby="modalOtherPaymentLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-blue text-white">
                <h5 class="modal-title" id="modalOtherPaymentLabel">Otros Pagos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label font-weight-bold"
                                   for="other_description">Descripción</label>
                            <div class="form-floating">
                                <textarea name="other_description" id="other_description" class="form-control"
                                          placeholder="Descripción"
                                          style="height: 50px"></textarea>
                            </div>
                            <small class="form-text text-muted">
                                Agrega el motivo de pago
                            </small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="control-label font-weight-bold" for="other_price">Pago Total S/ <span
                                    class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="other_price" id="other_price" min="0"
                               step="0.01" placeholder="Ingrese el pago total a realizar">
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button id="add_other_payment" type="button" class="btn btn-success"><i
                            class="fa-solid fa-angles-right"></i> Agregar
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal para listar proveedores -->
<div class="modal fade" id="modalListSupplier" tabindex="-1" aria-labelledby="modalListSupplierLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalListSupplierLabel">Lista de Proveedores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                <div class="table-responsive">
                    <table id="tableSuppliers" class="table table-sm table-hover table-bordered w-100">
                        <thead>
                        <tr>
                            <th class="text-center">Documento</th>
                            <th>Razón Social</th>
                            <th class="text-center">Telefono</th>
                            <th class="text-center">Dirección</th>
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
<!-- Modal para registrar los pagos consecutivos de la compra-->
<div class="modal fade" id="modalPaymentPurchase" tabindex="-1" aria-labelledby="modalPaymentPurchaseLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: 2px solid #04a5e0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="modalPaymentPurchaseLabel">REGISTRAR PAGOS DE LA COMPRA: #001</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Columna izquierda: productos -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group form-group-sm">
                                    <label class="control-label font-weight-bold mb-1 text-black-50" for="amount_pay_typepurchase"><i class="fa-solid fa-truck"></i> Tipo de Compra</label>
                                    <input disabled class="bg-white form-control form-control-sm" type="text"
                                           id="amount_pay_typepurchase" name="amount_pay_typepurchase">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-sm">
                                    <label class="control-label font-weight-bold mb-1" for="amount_pay_purchase">Monto
                                        <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" min="0" step="0.1"
                                           type="number"
                                           id="amount_pay_purchase" name="amount_pay_purchase">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold mb-1" for="methodpayment_pay_purchase">Forma
                                        de
                                        Pago
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" id="methodpayment_pay_purchase"
                                            name="methodpayment_pay_purchase" required>
                                        <option disabled>Seleccione forma de pago.</option>
                                        <option value="YAPE">Yape</option>
                                        <option value="PLIN">Plin</option>
                                        <option value="TRANSFERENCIA">Transferencia</option>
                                        <option value="EFECTIVO" selected>Efectivo</option>
                                        <option value="OTROS">Otros</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold mb-1" for="date_pay_purchase">Fecha de
                                        Compra
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local" class="form-control form-control-sm"
                                           name="date_pay_purchase" id="date_pay_purchase" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label font-weight-bold mb-1" for="comment_pay_purchase">Comentario
                                        <span class="text-muted">(Opcional)</span>
                                    </label>
                                    <textarea name="comment_pay_purchase" id="comment_pay_purchase" rows="2"
                                              class="form-control"
                                              placeholder="Notas u observaciones..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <button class="btn btn-sm btn-success" id="btn_add_pay_purchase"><i
                                            class="fa-solid fa-check-double"></i> Agregar
                                    Pago
                                </button>
                            </div>
                            <div class="col-md-12 pt-2">
                                <div class="alert alert-primary alert-dismissible fade show p-2" role="alert">
                                    <strong><i class="fa-solid fa-list-check"></i> DETALLE</strong> Lista de pagos.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-sm table-bordered">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Comentario</th>
                                        <th>Fecha</th>
                                        <th>F. Pago</th>
                                        <th>Monto</th>
                                        <th>Acción</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_payment_purchase">
                                    </tbody>
                                    <thead id="table_payment_purchase_footer" class="thead-light">
                                    <tr>
                                        <th colspan="3" class="text-right">SUBTOTAL</th>
                                        <th>S/ 4,000.00</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Columna derecha: resumen -->
                    <div class="col-md-4">
                        <div class="card shadow-sm resumen-card">
                            <div class="card-body text-center">
                                <img id="payPurchase_Img" src=""
                                     class="rounded-circle mb-2" width="80" alt="Proveedor">
                                <h6 id="payPurchase_fullname" class="mb-0">Molino Industrial Selva SA</h6>
                                <small id="payPurchase_comment" class="text-muted">Sin comentarios</small>
                                <div id="payPurchase_status" class="mt-2">
                                    <span class="badge badge-success">Cliente activo</span>
                                </div>
                                <hr>
                                <p id="payPuchase_numberdocument" class="mb-1"><span
                                            class="badge badge-warning">RUC</span> 20493917651</p>
                                <p id="payPuchase_phone" class="mb-1 text-info">942691290</p>
                                <p id="payPuchase_address" class="mb-1"><i class="fas fa-map-marker-alt"></i> Rioja San
                                    Martín</p>
                                <hr>
                                <div>
                                    <label class="h6 text-primary">Número de cuentas <b>(CCI)</b>:</label>
                                    <p class="mb-1" id="payPurchase_account1"></p>
                                    <p id="payPurchase_account2"></p>
                                </div>
                                <hr>
                                <p id="payPuchase_date" class="mb-1">2025-08-19</p>
                                <div class="text-right">
                                    <label class="h5 text-primary">Total a Pagar:</label>
                                    <p id="payPurchase_amount" class="h4 text-muted">S/ 0.00</p>
                                </div>
                                <div id="payPuchase_statuspay">
                                    <span style="font-size: 12px" class="col-12 py-2 badge badge-success">Pagado</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para imprimir la Orden de Compra-->
<div class="modal fade" id="modalPrintDocument" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
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
<!-- CODIGO SMITH -->