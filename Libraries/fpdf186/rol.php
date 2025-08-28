<?php
require('fpdf.php');

class rol extends FPDF
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

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['nombre_comite'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, mb_convert_encoding('RUC: ' . $this->headerData['ruc'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['direccion'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Cell(0, 5, mb_convert_encoding($this->headerData['telefono'] . ' - ' . $this->headerData['correo'], "ISO-8859-1", "UTF-8"), 0, 1, 'C');
        $this->Ln(5);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->Ln(5);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, mb_convert_encoding('Página ' . $this->PageNo(), "ISO-8859-1", "UTF-8"), 0, 0, 'C');
    }

    public function generarReporteRol($rolData, $permisos)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, mb_convert_encoding('Rol: ' . $rolData['nombre'], "ISO-8859-1", "UTF-8"), 0, 1, 'L');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, mb_convert_encoding('Información del Rol', "ISO-8859-1", "UTF-8"), 0, 1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, mb_convert_encoding('Código: ' . $rolData['codigo'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->MultiCell(0, 6, mb_convert_encoding('Descripción: ' . $rolData['descripcion'], "ISO-8859-1", "UTF-8"));
        $this->SetFont('Arial', 'B', 10);

        $this->Cell(0, 6, mb_convert_encoding('Estado: ' . $rolData['estado'], "ISO-8859-1", "UTF-8"), 0, 1);

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 8, mb_convert_encoding('Detalle de permisos habilitados', "ISO-8859-1", "UTF-8"), 0, 1);

        // Encabezado de tabla
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(35, 7, mb_convert_encoding('Nombre', "ISO-8859-1", "UTF-8"), 1, 0, 'C', true);
        $this->Cell(30, 7, mb_convert_encoding('Ruta', "ISO-8859-1", "UTF-8"), 1, 0, 'C', true);
        $this->Cell(20, 7, mb_convert_encoding('Menú', "ISO-8859-1", "UTF-8"), 1, 0, 'C', true);
        $this->Cell(20, 7, mb_convert_encoding('Público', "ISO-8859-1", "UTF-8"), 1, 0, 'C', true);
        $this->Cell(25, 7, mb_convert_encoding('Nav. Menú', "ISO-8859-1", "UTF-8"), 1, 0, 'C', true);
        $this->Cell(60, 7, mb_convert_encoding('Descripción', "ISO-8859-1", "UTF-8"), 1, 1, 'C', true);

        // Filas de datos
        // Filas de datos
        $this->SetFont('Arial', '', 8);

        foreach ($permisos as $permiso) {
            // Guardamos la posición inicial
            $x = $this->GetX();
            $y = $this->GetY();

            // Convertir texto a ISO-8859-1
            $nombre = mb_convert_encoding($permiso['nombre'], "ISO-8859-1", "UTF-8");
            $ruta = mb_convert_encoding($permiso['ruta'], "ISO-8859-1", "UTF-8");
            $menu = mb_convert_encoding($permiso['menu'], "ISO-8859-1", "UTF-8");
            $publico = mb_convert_encoding($permiso['publico'], "ISO-8859-1", "UTF-8");
            $menu_nav = mb_convert_encoding($permiso['menu_nav'], "ISO-8859-1", "UTF-8");
            $descripcion = mb_convert_encoding($permiso['descripcion'], "ISO-8859-1", "UTF-8");

            // Definir los anchos de columna
            $w_nombre = 35;
            $w_ruta = 30;
            $w_menu = 20;
            $w_publico = 20;
            $w_menu_nav = 25;
            $w_descripcion = 60;
            $lineHeight = 5;

            // Calcular la cantidad de líneas necesarias por celda
            $nb = max(
                $this->NbLines($w_nombre, $nombre),
                $this->NbLines($w_ruta, $ruta),
                $this->NbLines($w_menu, $menu),
                $this->NbLines($w_publico, $publico),
                $this->NbLines($w_menu_nav, $menu_nav),
                $this->NbLines($w_descripcion, $descripcion)
            );

            // Altura máxima de la fila
            $h = $lineHeight * $nb;

            // Dibujar cada celda con altura uniforme
            $this->Rect($x, $y, $w_nombre, $h);
            $this->MultiCell($w_nombre, $lineHeight, $nombre, 0, 'L');
            $this->SetXY($x += $w_nombre, $y);

            $this->Rect($x, $y, $w_ruta, $h);
            $this->MultiCell($w_ruta, $lineHeight, $ruta, 0, 'L');
            $this->SetXY($x += $w_ruta, $y);

            $this->Rect($x, $y, $w_menu, $h);
            $this->MultiCell($w_menu, $lineHeight, $menu, 0, 'C');
            $this->SetXY($x += $w_menu, $y);

            $this->Rect($x, $y, $w_publico, $h);
            $this->MultiCell($w_publico, $lineHeight, $publico, 0, 'C');
            $this->SetXY($x += $w_publico, $y);

            $this->Rect($x, $y, $w_menu_nav, $h);
            $this->MultiCell($w_menu_nav, $lineHeight, $menu_nav, 0, 'C');
            $this->SetXY($x += $w_menu_nav, $y);

            $this->Rect($x, $y, $w_descripcion, $h);
            $this->MultiCell($w_descripcion, $lineHeight, $descripcion, 0, 'L');

            // Posicionarse al inicio de la siguiente fila
            $this->SetY($y + $h);
        }




        $this->Ln(5);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 6, mb_convert_encoding('Fecha de registro: ' . $rolData['fecha_registro'], "ISO-8859-1", "UTF-8"), 0, 1);
        $this->Cell(0, 6, mb_convert_encoding('Fecha de actualización: ' . $rolData['fecha_actualizacion'], "ISO-8859-1", "UTF-8"), 0, 1);
    }
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }


}
