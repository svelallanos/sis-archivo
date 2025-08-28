<?php
require('fpdf.php');

class ReportePeople extends FPDF
{
    private $people;
    private $headerData;

    public function __construct($people, $headerData)
    {
        parent::__construct();
        $this->people = $people;
        $this->headerData = $headerData;
    }

    function Header()
    {
        // Logo institucional
        if (!empty($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], 10, 10, 20);
        }

        // Título institucional
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 6, mb_convert_encoding($this->headerData['nombre_comite'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'RUC: ' . mb_convert_encoding($this->headerData['ruc'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 6, mb_convert_encoding($this->headerData['direccion'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 6, $this->headerData['telefono'] . ' - ' . $this->headerData['correo'], 0, 1, 'C');

        // Línea divisoria
        $this->Ln(8);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo(), "ISO-8859-1", "UTF-8"), 0, 0, 'C');
    }

    public function generarReporte()
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(0, 23, 82); //COLOR DEL TITULO
        $this->Cell(0, 10, mb_convert_encoding('REPORTE DE PERSONA', "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Ln(5);

        // Línea divisoria
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(2, 82, 0); //COLOR DE SUBTITULO
        $this->Cell(0, 8, mb_convert_encoding('1. DATOS PERSONALES', "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->Ln(1);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetFont('Arial', '', 12);
        // Datos de la persona
        if ($this->people['typePeople'] === 'NATURAL') {
            $nombreCompleto = $this->people['name'] . ' ' . $this->people['lastname'];
        } else {
            $nombreCompleto = $this->people['fullname'];
        }
        $this->SetTextColor(0, 0, 0);
        $this->agregarCampo('Nombre Completo:', $nombreCompleto);
        $this->agregarCampo('Código de Persona:', '#' . $this->people['id']);
        $this->agregarCampo('N° de Documento:', $this->people['numberDocument']);
        $this->agregarCampo('Tipo de Persona:', $this->people['typePeople']);
        $this->agregarCampo('Fecha de Nacimiento:', $this->people['birthdate']);
        $this->agregarCampo('Género:', $this->people['gender']);
        $this->agregarCampo('Correo electrónico:', $this->people['mail']);
        $this->agregarCampo('Teléfono:', $this->people['phone']);
        $this->agregarCampo('Dirección:', $this->people['address']);
        $this->agregarCampo('Estado:', $this->people['status']);
        $this->Ln(5);
        // Línea divisoria
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(2, 82, 0); //COLOR DE SUBTITULO
        $this->Cell(0, 8, mb_convert_encoding('2. FECHAS DEL SISTEMA', "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->Ln(1);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetTextColor(0, 0, 0);
        $this->agregarCampo('Fecha de registro:', $this->people['dateRegistration']);
        $this->agregarCampo('Fecha de actualización:', $this->people['dateUpdate']);
    }

    private function agregarCampo($label, $valor)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(60, 8, mb_convert_encoding($label, "ISO-8859-1", "UTF-8"), 0, 0);
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 8, mb_convert_encoding($valor, "ISO-8859-1", "UTF-8"), 0, 1);
    }

    public function outputPDF($nombre = 'reporte_people.pdf')
    {
        $this->Output('I', $nombre);
    }
}
