<?php
require('fpdf.php');

class ReciboPDF extends FPDF
{
    protected $headerData;

    public function __construct($headerData)
    {
        parent::__construct();
        $this->headerData = $headerData;
    }

    public function Header()
    {
        if (!empty($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], 10, 8, 20);
        }

        $this->SetFont('Arial', 'B', 11);
        $this->SetXY(40, 10);
        $this->Cell(0, 6, mb_convert_encoding($this->headerData['nombre_comite'], "ISO-8859-1", "UTF-8"), 0, 1, 'L');

        $this->SetFont('Arial', '', 9);
        $this->SetX(40);
        $this->Cell(0, 5, mb_convert_encoding('RUC: ' . $this->headerData['ruc'], "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->SetX(40);
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['direccion'], "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->SetX(40);
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['telefono'] . ' | ' . $this->headerData['correo'], "ISO-8859-1", "UTF-8"), 0, 1, 'L');

        $this->Ln(4);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-18);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120);
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo(), "ISO-8859-1", "UTF-8"), 0, 0, 'C');
    }

    public function generarRecibo($datos, $servicios)
    {
        $this->AddPage();
        $this->SetFont('Arial', '', 9);

        // Encabezado de datos del recibo
        $this->SetFillColor(245, 245, 245);
        $this->SetDrawColor(200, 200, 200);
        $this->Cell(95, 7, mb_convert_encoding('Recibo N°: ' . $datos['numero'], "ISO-8859-1", "UTF-8"), 1, 0, 'L', true);
        $this->Cell(95, 7, mb_convert_encoding('Usuario: ' . $datos['usuario'], "ISO-8859-1", "UTF-8"), 1, 1, 'L', true);
        $this->Cell(95, 7, mb_convert_encoding('Código de Usuario: ' . $datos['codigo_usuario'], "ISO-8859-1", "UTF-8"), 1, 0, 'L', true);
        $this->Cell(95, 7, mb_convert_encoding('N° de Áreas: ' . $datos['areas'], "ISO-8859-1", "UTF-8"), 1, 1, 'L', true);
        $this->Cell(95, 7, mb_convert_encoding('Campaña: ' . $datos['campania'], "ISO-8859-1", "UTF-8"), 1, 0, 'L', true);
        $this->Cell(95, 7, mb_convert_encoding('Periodo: ' . $datos['periodo'], "ISO-8859-1", "UTF-8"), 1, 1, 'L', true);

        $this->Ln(5);

        // Encabezado tabla de servicios
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(200, 230, 255);
        $this->SetDrawColor(180, 180, 180);
        $this->SetTextColor(0);

        $this->Cell(10, 7, '#', 1, 0, 'C', true);
        $this->Cell(25, 7, 'Cant. (Ha)', 1, 0, 'C', true);
        $this->Cell(65, 7, 'Servicio', 1, 0, 'C', true);
        $this->Cell(25, 7, 'Precio Unit.', 1, 0, 'C', true);
        $this->Cell(15, 7, 'Desc%', 1, 0, 'C', true);
        $this->Cell(15, 7, 'Mora%', 1, 0, 'C', true);
        $this->Cell(35, 7, 'Total Final', 1, 1, 'C', true);

        // Cuerpo tabla
        $this->SetFont('Arial', '', 8);
        foreach ($servicios as $i => $item) {
            $this->Cell(10, 6, $i + 1, 1);
            $this->Cell(25, 6, mb_convert_encoding($item['cantidad'], "ISO-8859-1", "UTF-8"), 1, 0, 'C');
            $this->Cell(65, 6, mb_convert_encoding($item['servicio'], "ISO-8859-1", "UTF-8"), 1);
            $this->Cell(25, 6, mb_convert_encoding($item['precio'], "ISO-8859-1", "UTF-8"), 1, 0, 'R');
            $this->Cell(15, 6, $item['desc'], 1, 0, 'C');
            $this->Cell(15, 6, $item['mora'], 1, 0, 'C');

            // Total calculado en columna final (con desc y mora)
            $final = getCurrency() . " " . number_format((float) $item['subtotal'], 2, '.', '');
            $this->Cell(35, 6, mb_convert_encoding($final, "ISO-8859-1", "UTF-8"), 1, 1, 'R');
        }

        // Totales
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(0);
        $this->SetFillColor(240, 240, 240);

        $this->Cell(135, 7, '', 0, 0);
        $this->Cell(30, 7, 'Subtotal:', 1, 0, 'R', true);
        $this->Cell(25, 7, mb_convert_encoding($datos['subtotal'], "ISO-8859-1", "UTF-8"), 1, 1, 'R');

        $this->SetTextColor(0, 100, 0);
        $this->Cell(135, 7, '', 0, 0);
        $this->Cell(30, 7, 'Total c/Descuento:', 1, 0, 'R', true);
        $this->Cell(25, 7, mb_convert_encoding($datos['total_desc'], "ISO-8859-1", "UTF-8"), 1, 1, 'R');

        $this->SetTextColor(180, 0, 0);
        $this->Cell(135, 7, '', 0, 0);
        $this->Cell(30, 7, 'Total c/Mora:', 1, 0, 'R', true);
        $this->Cell(25, 7, mb_convert_encoding($datos['total_mora'], "ISO-8859-1", "UTF-8"), 1, 1, 'R');
        // Leyenda final
        $this->Ln(10);
        $this->SetTextColor(0);
        $this->SetFont('Arial', 'I', 8);
        $this->MultiCell(0, 5, mb_convert_encoding(
            "* Nota: El total del recibo puede variar según el periodo de pago. Si el usuario realiza el pago dentro del periodo establecido, se aplicará el descuento correspondiente. En caso de realizar el pago fuera del periodo, se añadirá el recargo por mora.",
            "ISO-8859-1",
            "UTF-8"
        ), 0, 'J');
    }
}
