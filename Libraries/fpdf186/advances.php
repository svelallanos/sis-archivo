<?php
require('fpdf.php');

class ReporteAdvances extends FPDF
{
    private $advances;
    private $headerData;

    public function __construct($advances, $headerData)
    {
        parent::__construct();
        $this->advances = $advances;
        $this->headerData = $headerData;
        $this->SetMargins(15, 15, 15);
    }

    function Header()
    {
        // Logo
        if (!empty($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], 15, 10, 20);
        }

        // Encabezado Institucional
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(0, 12);
        $this->Cell(0, 6, mb_convert_encoding($this->headerData['nombre_comite'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, 'RUC: ' . mb_convert_encoding($this->headerData['ruc'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['direccion'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 5, $this->headerData['telefono'] . ' - ' . $this->headerData['correo'], 0, 1, 'C');

        $this->Ln(6);
        $this->SetDrawColor(100, 100, 100);
        $this->SetLineWidth(0.3);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(8);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo(), "ISO-8859-1", "UTF-8"), 0, 0, 'C');
    }

    public function generarReporte()
    {
        $this->AddPage();

        // Título del reporte
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(0, 70, 130);
        $this->Cell(0, 10, mb_convert_encoding('REPORTE DEL ADELANTO', "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->Ln(5);

        // Datos de la persona
        if ($this->advances['typePeople'] === 'NATURAL') {
            $nombreCompleto = $this->advances['name'] . ' ' . $this->advances['lastname'];
        } else {
            $nombreCompleto = $this->advances['fullname'];
        }

        // --------- DATOS DEL CLIENTE ---------
        $this->encabezadoSeccion("1. DATOS DEL CLIENTE");
        $this->agregarCampo('Nombre completo:', $nombreCompleto);
        $this->agregarCampo('Código del cliente:', '#' . $this->advances['customer_id']);
        $this->Ln(3);

        // --------- DETALLES DEL PRÉSTAMO ---------
        $this->encabezadoSeccion("2. DETALLES DEL ADELANTO");
        $this->agregarCampo('Código del préstamo:', '#' . $this->advances['id']);

        $this->resaltarCampo('Monto:',   $this->advances['amount'], [0, 102, 0]);

        $this->agregarCampo('Fecha de inicio:', $this->advances['dateStart']);
        $this->agregarCampo('Fecha de fin:', $this->advances['dateEnd']);

        //$this->resaltarCampo('Interés:', $this->advances['interest'] , [180, 0, 0]);
        $this->Ln(3);

        // --------- ESTADO Y OBSERVACIONES ---------
        $this->encabezadoSeccion("3. ESTADO Y OBSERVACIONES");
        $this->resaltarCampo('Estado:', $this->advances['status'], [0, 0, 150]);
        $this->agregarCampo('Observaciones:', $this->advances['observations']);
        $this->Ln(3);

        // --------- FECHAS DEL SISTEMA ---------
        $this->encabezadoSeccion("4. FECHAS DEL SISTEMA");
        $this->agregarCampo('Fecha de registro:', $this->advances['dateRegistration']);
        $this->agregarCampo('Fecha de actualización:', $this->advances['dateUpdate']);
    }

    private function encabezadoSeccion($titulo)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(60, 60, 60);
        $this->Cell(0, 8, mb_convert_encoding($titulo, "ISO-8859-1", "UTF-8"), 0, 1);
        $this->SetDrawColor(180, 180, 180);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(4);
        $this->SetTextColor(0, 0, 0);
    }

    private function agregarCampo($label, $valor)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(55, 7, mb_convert_encoding($label, "ISO-8859-1", "UTF-8"), 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 7, mb_convert_encoding($valor, "ISO-8859-1", "UTF-8"), 0, 'L');
    }

    private function resaltarCampo($label, $valor, $rgb = [0, 0, 0])
    {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(55, 7, mb_convert_encoding($label, "ISO-8859-1", "UTF-8"), 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor($rgb[0], $rgb[1], $rgb[2]);
        $this->MultiCell(0, 7, mb_convert_encoding($valor, "ISO-8859-1", "UTF-8"), 0, 'L');
        $this->SetTextColor(0, 0, 0); // Reset
    }

    public function outputPDF($nombre = 'reporte_advances.pdf')
    {
        $this->Output('I', $nombre);
    }
}
