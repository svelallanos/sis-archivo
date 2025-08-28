<?php
require('fpdf.php');

class ReporteUsuario extends FPDF
{
    private $usuario;
    private $headerData;

    public function __construct($usuario, $headerData)
    {
        parent::__construct();
        $this->usuario = $usuario;
        $this->headerData = $headerData;
    }

    function Header()
    {
        // Logo
        if (!empty($this->headerData['logo'])) {
            $this->Image($this->headerData['logo'], 10, 10, 20);
        }

        // Encabezado institucional
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 6, mb_convert_encoding($this->headerData['nombre_comite'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'RUC: ' . mb_convert_encoding($this->headerData['ruc'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 6, mb_convert_encoding($this->headerData['direccion'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 6, $this->headerData['telefono'] . ' - ' . $this->headerData['correo'], 0, 1, 'C');

        // Línea separadora
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
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, mb_convert_encoding($this->usuario['nombres_completos'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Ln(8);

        // Foto de usuario
        if (!empty($this->usuario['foto']) && file_exists($this->usuario['foto'])) {
            $this->Image($this->usuario['foto'], 160, $this->GetY(), 30);
        }

        // Datos personales
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, mb_convert_encoding('Datos Personales', "ISO-8859-1", "UTF-8"), 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->agregarCampo('DNI:', $this->usuario['dni']);
        $this->agregarCampo('Género:', $this->usuario['genero']);

        $this->Ln(5);

        // Datos de la cuenta
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, mb_convert_encoding('Datos de la Cuenta', "ISO-8859-1", "UTF-8"), 0, 1);

        $this->SetFont('Arial', '', 11);
        $this->agregarCampo('Usuario:', $this->usuario['usuario']);
        $this->agregarCampo('Contraseña:', $this->usuario['contrasena']);
        $this->agregarCampo('Email:', $this->usuario['email']);
        $this->agregarCampo('Rol:', $this->usuario['rol']);

        $this->Ln(8);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 8, mb_convert_encoding('Fecha de registro: ' . $this->usuario['fecha_registro'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->Cell(0, 8, mb_convert_encoding('Fecha de actualización: ' . $this->usuario['fecha_actualizacion'], "ISO-8859-1", "UTF-8"), 0, 1);
    }

    private function agregarCampo($label, $valor)
    {
        $this->Cell(50, 8, mb_convert_encoding($label, "ISO-8859-1", "UTF-8"), 0, 0);
        $this->Cell(0, 8, mb_convert_encoding($valor, "ISO-8859-1", "UTF-8"), 0, 1);
    }

    public function outputPDF($nombre = 'reporte_usuario.pdf')
    {
        $this->Output('I', $nombre);
    }
}