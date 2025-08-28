<?php
require('fpdf.php');

class reporteSale extends FPDF
{
    public $datos_comprobante = [];
    public $cliente = [];
    public $productos = [];
    public $adelantos = [];
    public $total_sale = 0;
    public $total_advance = 0;

    function Header()
    {
        if (!empty($this->datos_comprobante['logo'])) {
            $this->Image($this->datos_comprobante['logo'], 10, 8, 30);
        }

        $this->SetFont('Arial', 'B', 13);
        $this->SetXY(45, 10);
        $this->Cell(120, 6, utf8_decode($this->datos_comprobante['empresa']), 0, 2, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(120, 5, utf8_decode('RUC: ' . $this->datos_comprobante['ruc']), 0, 2, 'C');
        $this->Cell(120, 5, utf8_decode($this->datos_comprobante['direccion']), 0, 2, 'C');
        $this->Cell(120, 5, utf8_decode($this->datos_comprobante['telefono'] . ' - ' . $this->datos_comprobante['email']), 0, 2, 'C');

        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(155, 10);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(45, 6, utf8_decode($this->datos_comprobante['typeDocument']), 1, 2, 'C', true);
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 6, utf8_decode("Serie: " . $this->datos_comprobante['serie']), 1, 2, 'C');
        $this->Cell(45, 6, utf8_decode("Año: " . $this->datos_comprobante['anio']), 1, 2, 'C');
        $this->Cell(45, 6, utf8_decode("N°: " . $this->datos_comprobante['numero']), 1, 2, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-30);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 6, utf8_decode('Gracias por su compra. ¡Vuelva pronto!'), 0, 1, 'C');
        $this->Cell(0, 6, utf8_decode('Documento generado automáticamente.'), 0, 1, 'C');
        $this->SetFont('Arial', '', 7);
        $this->Cell(0, 6, utf8_decode('Verifique autenticidad en: ' . $this->datos_comprobante['verificacion']), 0, 0, 'C');
    }

    function DatosCliente()
    {
        $this->Ln(3);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(220, 220, 220);
        $this->Cell(0, 7, utf8_decode('Datos del Usuario'), 1, 1, 'L', true);

        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 7, utf8_decode("Nombre: " . $this->cliente['nombre']), 1);
        $this->Cell(45, 7, utf8_decode("DNI/RUC: " . $this->cliente['dni']), 1);
        $this->Cell(45, 7, utf8_decode("Fecha: " . (new DateTime($this->datos_comprobante['fecha']))->format('d-m-Y')), 1);
        $this->Ln();
        $this->Cell(190, 7, utf8_decode("Dirección: " . $this->cliente['direccion']), 1);
        $this->Ln(10);
    }

    function DetalleProductos()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(80, 8, utf8_decode('Descripción'), 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('Cantidad'), 1, 0, 'C', true);
        $this->Cell(40, 8, utf8_decode('Precio Unit.'), 1, 0, 'C', true);
        $this->Cell(40, 8, utf8_decode('Total'), 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        $total = 0;
        foreach ($this->productos as $item) {
            $subtotal = $item['cantidad'] * $item['precio'];
            $total += $subtotal;

            $this->Cell(80, 8, utf8_decode($item['descripcion']) . ' (' . $item['presentacion'] . ')', 1);
            $this->Cell(30, 8, $item['cantidad'], 1, 0, 'C');
            $this->Cell(40, 8, $this->datos_comprobante['currency'] . " " . number_format($item['precio'], 2), 1, 0, 'R');
            $this->Cell(40, 8, $this->datos_comprobante['currency'] . " " . number_format($subtotal, 2), 1, 1, 'R');
        }

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(150, 8, utf8_decode('SUBTOTAL'), 1, 0, 'R');
        $this->SetFillColor(255, 255, 200);
        $this->Cell(40, 8, $this->datos_comprobante['currency'] . " " . formatearMoney($total), 1, 1, 'R', true);

        $this->SetFont('Arial', 'I', 9);
        $this->Cell(190, 6, utf8_decode('SON: ' . strtoupper(convertirNumeroLetras($total))), 0, 1, 'L');
    }

    function Adelantos()
    {
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(154, 209, 162);
        $this->Cell(190, 8, utf8_decode('ADELANTOS'), 1, 1, 'C', true);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(40, 8, utf8_decode('Fecha'), 1, 0, 'C', true);
        $this->Cell(70, 8, utf8_decode('Descripción'), 1, 0, 'C', true);
        $this->Cell(40, 8, utf8_decode('Cantidad'), 1, 0, 'C', true);
        $this->Cell(40, 8, utf8_decode('Monto'), 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        $total = 0;
        foreach ($this->adelantos as $item) {
            $total += $item['monto'];

            $this->Cell(40, 8, utf8_decode($item['fecha']), 1, 0, 'C');
            $this->Cell(70, 8, utf8_decode($item['descripcion']), 1);
            $this->Cell(40, 8, $item['cantidad'], 1, 0, 'C');
            $this->Cell(40, 8, $this->datos_comprobante['currency'] . " " . number_format($item['monto'], 2), 1, 1, 'R');
        }

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(150, 8, utf8_decode('SUBTOTAL'), 1, 0, 'R');
        $this->SetFillColor(255, 255, 200);
        $this->Cell(40, 8, $this->datos_comprobante['currency'] . " " . formatearMoney($total), 1, 1, 'R', true);

        $this->SetFont('Arial', 'I', 9);
        $this->Cell(190, 6, utf8_decode('SON: ' . strtoupper(convertirNumeroLetras($total))), 0, 1, 'L');
    }

    function Pay()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(120);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(40, 6, utf8_decode("SUBTOTAL"), 1, 0, 'L', true);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 6, $this->datos_comprobante['currency'] . " " . formatearMoney($this->total_sale), 1, 1, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(120);
        $this->Cell(40, 6, utf8_decode("ADELANTOS"), 1, 0, 'L', true);
        $this->SetFont('Arial', '', 10);
        if($this->total_advance > 0) {
            $this->SetFillColor(154, 209, 162);
        } else {
            $this->SetFillColor(240, 240, 240);
        }
        $this->Cell(40, 6, $this->datos_comprobante['currency'] . " " . formatearMoney($this->total_advance), 1, 1, 'R',true);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(120);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(40, 6, utf8_decode("IMPUESTO (IGV 18%)"), 1, 0, 'L', true);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 6, $this->datos_comprobante['currency'] . " " . formatearMoney(0), 1, 1, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(120);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(40, 6, utf8_decode("DESCUENTO"), 1, 0, 'L', true);
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 6, $this->datos_comprobante['currency'] . " " . formatearMoney(0), 1, 1, 'R');
        $this->SetFont('Arial', 'B', 10);
        $this->SetX(120);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(40, 6, utf8_decode("TOTAL A PAGAR"), 1, 0, 'L', true);
        $this->Cell(40, 6, $this->datos_comprobante['currency'] . " " . formatearMoney($this->datos_comprobante['total']), 1, 1, 'R');
        // if($this->datos_comprobante['total'] < 100){
        // }
        $this->SetX(50);
        $this->SetFont('Arial', 'I', 9);
        $this->Cell(190, 6, utf8_decode('SON: ' . strtoupper(convertirNumeroLetras($this->datos_comprobante['total']))), 0, 1, 'L');
    }
}
// $this->datos_comprobante['total']
function convertirNumeroLetras($numero)
{
    //necesita que se instale la libreria de phpintl para funcionar extension=intl
    $f = new NumberFormatter("es", NumberFormatter::SPELLOUT);
    return $f->format($numero) . " soles";
}

function formatearMoney($monto)
{
    return number_format($monto, 2, '.', ',');
}
