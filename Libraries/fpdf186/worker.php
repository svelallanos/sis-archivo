<?php
require('fpdf.php');

class ReporteWorker extends FPDF
{
    private $worker;
    private $headerData;

    public function __construct($worker, $headerData)
    {
        parent::__construct();
        $this->worker = $worker;
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
        $this->Cell(0, 10, mb_convert_encoding('REPORTE DE TRABAJADORES', "ISO-8859-1", "UTF-8"), 0, 1, 'C');
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
        if ($this->worker['typePeople'] === 'NATURAL') {
            $nombreCompleto = $this->worker['name'] . ' ' . $this->worker['lastname'];
        } else {
            $nombreCompleto = $this->worker['fullname'];
        }

        $this->SetTextColor(0, 0, 0);
        $this->agregarCampo('Nombre Completo:', $nombreCompleto);
        $this->agregarCampo('Número de Documento:', $this->worker['numberDocument']);
        $this->agregarCampo('Teléfono:', $this->worker['phone']);
        //$this->agregarCampo('Código de Persona:', '#' . $this->worker['people_id']);
        $this->agregarCampo('Cargo en la empresa:', $this->worker['nameJob']);
        $this->agregarCampo('Código de Trabajador:', '#' . $this->worker['job_title_id']);
        $this->agregarCampo('Estado:', $this->worker['status']);
        $this->Ln(5);

        // Línea divisoria
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(2, 82, 0); //COLOR DE SUBTITULO
        $this->Cell(0, 8, mb_convert_encoding('2. DATOS BANCARIOS', "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->Ln(1);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetTextColor(0, 0, 0);
        $this->agregarCampo('Numero de Cuenta 1:', $this->worker['account_number']);
        $this->agregarCampo('Numero de Cuenta 2:', $this->worker['account_number2']);
        $this->agregarCampo('Numero de Cuenta 3:', $this->worker['account_number3']);
        $this->agregarCampo('Numero de Cuenta 4:', $this->worker['account_number4']);
        $this->Ln(5);

        // Línea divisoria
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(2, 82, 0); //COLOR DE SUBTITULO
        $this->Cell(0, 8, mb_convert_encoding('3. FECHAS DEL SISTEMA', "ISO-8859-1", "UTF-8"), 0, 1, 'L');
        $this->Ln(1);
        $this->SetDrawColor(0, 0, 0);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);

        $this->SetTextColor(0, 0, 0);
        $this->agregarCampo('Fecha de registro:', $this->worker['dateRegistration']);
        $this->agregarCampo('Fecha de actualización:', $this->worker['dateUpdate']);
    }

    private function agregarCampo($label, $valor)
    {
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(60, 8, mb_convert_encoding($label, "ISO-8859-1", "UTF-8"), 0, 0);
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 8, mb_convert_encoding($valor, "ISO-8859-1", "UTF-8"), 0, 1);
    }

    public function outputPDF($nombre = 'reporte_worker.pdf')
    {
        $this->Output('I', $nombre);
    }
}
