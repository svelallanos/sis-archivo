<?php
require('fpdf.php');

class voucherSale extends FPDF {
    function Header() {
        // Logo
        $this->Image('logo_empresa.png', 10, 10, 30); // Cambia a tu logo real
        // Título
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Comprobante de Venta',0,1,'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Gracias por su compra - '.date('Y'),0,0,'C');
    }
}

$pdf = new voucherSale();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);

// Datos de venta
$numero = "R2025-1";
$fecha = "2025-07-12 14:39:35";
$metodoPago = "EFECTIVO";

// Datos del cliente
$cliente = "Samuel Vela Llanos";
$dni = "71116734";
$telefono = "910367611";
$correo = "yeison@gmail.com";
$direccion = "Jron amazonas";

// Encabezado
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Venta N°: $numero",0,1,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"Fecha: $fecha",0,1,'L');
$pdf->Cell(0,6,"Método de pago: $metodoPago",0,1,'L');
$pdf->Ln(4);

// Datos del cliente
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Datos del Cliente",0,1);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,6,"Nombre: $cliente",0,1);
$pdf->Cell(0,6,"DNI: $dni",0,1);
$pdf->Cell(0,6,"Teléfono: $telefono",0,1);
$pdf->Cell(0,6,"Correo: $correo",0,1);
$pdf->Cell(0,6,"Dirección: $direccion",0,1);
$pdf->Ln(5);

// Productos
$productos = [
    ["Arroz conquista", 20, 30.00],
    ["Arroz esperanza", 20, 9.00]
];
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Detalle de Productos",0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,"#",1);
$pdf->Cell(80,8,"Producto",1);
$pdf->Cell(20,8,"Cant.",1,0,'C');
$pdf->Cell(30,8,"Precio",1,0,'R');
$pdf->Cell(30,8,"Subtotal",1,1,'R');

$pdf->SetFont('Arial','',10);
$i = 1;
$importe = 0;
foreach($productos as $p) {
    $sub = $p[1] * $p[2];
    $importe += $sub;
    $pdf->Cell(10,8,$i++,1);
    $pdf->Cell(80,8,$p[0],1);
    $pdf->Cell(20,8,$p[1],1,0,'C');
    $pdf->Cell(30,8,"S/ ".number_format($p[2],2),1,0,'R');
    $pdf->Cell(30,8,"S/ ".number_format($sub,2),1,1,'R');
}
$pdf->Ln(3);

// Adelantos
$adelantos = [
    ["5/7/2025", "Arroz conquista", 500, 200.00, "Transferencia"],
    ["5/7/2025", "Arroz esperanza", 200, 500.00, "Transferencia"]
];

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Adelantos",0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,"#",1);
$pdf->Cell(25,8,"Fecha",1);
$pdf->Cell(50,8,"Producto",1);
$pdf->Cell(25,8,"Cant.",1,0,'C');
$pdf->Cell(30,8,"Monto",1,0,'R');
$pdf->Cell(40,8,"Método",1,1);

$pdf->SetFont('Arial','',10);
$i = 1;
$adelanto = 0;
foreach($adelantos as $a) {
    $adelanto += $a[3];
    $pdf->Cell(10,8,$i++,1);
    $pdf->Cell(25,8,$a[0],1);
    $pdf->Cell(50,8,$a[1],1);
    $pdf->Cell(25,8,$a[2],1,0,'C');
    $pdf->Cell(30,8,"S/ ".number_format($a[3],2),1,0,'R');
    $pdf->Cell(40,8,$a[4],1,1);
}

$pdf->Ln(8);

// Totales
$total = $adelanto;
$pdf->SetFont('Arial','B',11);
$pdf->Cell(135);
$pdf->Cell(30,8,"Importe:",0,0,'R');
$pdf->Cell(30,8,"S/ ".number_format($importe,2),0,1,'R');

$pdf->Cell(135);
$pdf->Cell(30,8,"Adelanto:",0,0,'R');
$pdf->Cell(30,8,"S/ ".number_format($adelanto,2),0,1,'R');

$pdf->SetTextColor(0,128,0);
$pdf->Cell(135);
$pdf->Cell(30,8,"Total:",0,0,'R');
$pdf->Cell(30,8,"S/ ".number_format($total,2),0,1,'R');
$pdf->SetTextColor(0);

// Estado
$pdf->Ln(10);
$pdf->SetFont('Arial','I',10);
$pdf->SetTextColor(0,100,0);
$pdf->Cell(0,6,"Estado: Cliente activo",0,1,'C');

$pdf->Output();
