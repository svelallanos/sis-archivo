<?php
require('fpdf.php');

class PartnerPDF extends FPDF
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
            $this->Image($this->headerData['logo'], 10, 6, 20);
        }

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0, 102, 204);
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['nombre_comite'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0);
        $this->Cell(0, 5, mb_convert_encoding('RUC: ' . $this->headerData['ruc'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['direccion'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['telefono'] . ' - ' . $this->headerData['correo'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');

        $this->Ln(3);
        $this->SetDrawColor(0, 102, 204);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo(), "ISO-8859-1", "UTF-8"), 0, 0, 'C');
    }

    public function generarReportePartner($datos)
    {
        $this->AddPage();

        if (!empty($datos['foto'])) {
            $this->Image($datos['foto'], 160, 35, 20);
        }

        // Título
        $this->SetFont('Arial', 'B', 14);
        $this->SetTextColor(0, 51, 102);
        $this->Cell(0, 10, mb_convert_encoding('Ficha de Usuario', "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->Ln(3);

        // Nombre
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0);
        $this->Cell(0, 8, mb_convert_encoding($datos['nombre'], "ISO-8859-1", "UTF-8"), 0, 1);

        // Datos Personales
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(230, 230, 250);
        $this->Cell(0, 8, mb_convert_encoding('Datos Personales', "ISO-8859-1", "UTF-8"), 0, 1, 'L', true);

        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 6, mb_convert_encoding('Código: ' . $datos['codigo'], "ISO-8859-1", "UTF-8"), 0, 0);
        $this->Cell(60, 6, mb_convert_encoding('DNI/RUC: ' . $datos['dni'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->Cell(60, 6, mb_convert_encoding('Fecha nacimiento: ' . $datos['fecha_nacimiento'], "ISO-8859-1", "UTF-8"), 0, 0);
        $this->Cell(60, 6, mb_convert_encoding('Género: ' . $datos['genero'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->Cell(60, 6, mb_convert_encoding('Estado civil: ' . $datos['estado_civil'], "ISO-8859-1", "UTF-8"), 0, 1);

        $this->Ln(2);

        // Contacto
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(230, 230, 250);
        $this->Cell(0, 8, mb_convert_encoding('Datos de Contacto', "ISO-8859-1", "UTF-8"), 0, 1, 'L', true);

        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 6, mb_convert_encoding('Celular: ' . $datos['celular'], "ISO-8859-1", "UTF-8"), 0, 0);
        $this->Cell(60, 6, mb_convert_encoding('Whatsapp: ' . $datos['whatsapp'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->Cell(60, 6, mb_convert_encoding('Email: ' . ($datos['email'] ?: '-'), "ISO-8859-1", "UTF-8"), 0, 1);
        $this->MultiCell(0, 6, mb_convert_encoding('Dirección: ' . $datos['direccion'], "ISO-8859-1", "UTF-8"));
        $this->Cell(60, 6, mb_convert_encoding('Estado: ' . $datos['estado'], "ISO-8859-1", "UTF-8"), 0, 1);

        // Código QR
        if (!empty($datos['qr'])) {
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(230, 230, 250);
            $this->Cell(0, 8, mb_convert_encoding('Código QR', "ISO-8859-1", "UTF-8"), 0, 1, 'L', true);
            $this->Image($datos['qr'], $this->GetX(), $this->GetY(), 20);
            $this->Ln(35);
        }

        // Fechas
        $this->Ln(5);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, mb_convert_encoding('Fecha de registro: ' . $datos['fecha_registro'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->Cell(0, 6, mb_convert_encoding('Fecha de actualización: ' . $datos['fecha_actualizacion'], "ISO-8859-1", "UTF-8"), 0, 1);
    }
}


?>