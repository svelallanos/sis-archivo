<?php

class Loadfile extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Funcion que carga la imagen de perfil del usuario
     * @return void
     */
    public function profile()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Profile/Users/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["jpg", "jpeg", "png", "PNG", "JPG", "JPEG"])) {
                header("Content-Type: image/$fileType");
                readfile($filePath);
                exit;
            } else {
                echo "Imagen no encontrada.";
            }
        } else {
            echo "No se especificó ningún archivo.";
        }
    }
    /**
     * Funcion que carga la imagen del producto
     * @return void
     */
    public function product()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Product/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["jpg", "jpeg", "png", "PNG", "JPG", "JPEG"])) {
                header("Content-Type: image/$fileType");
                readfile($filePath);
                exit;
            } else {
                echo "Imagen no encontrada.";
            }
        } else {
            echo "No se especificó ningún archivo.";
        }
    }
    /**
     * Funcion que carga la imagen del producto
     * @return void
     */
    public function people()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "People/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["jpg", "jpeg", "png", "PNG", "JPG", "JPEG"])) {
                header("Content-Type: image/$fileType");
                readfile($filePath);
                exit;
            } else {
                //cargamos una imagen por defecto
                header("Content-Type: image/png");
                readfile(getRoute() . "People/Users/clientes.png");
            }
        } else {
            //cargamos una imagen por defecto
            header("Content-Type: image/png");
            readfile(getRoute() . "People/Users/clientes.png");
        }
    }
    /**
     * Funcion que carga la imagen de perfil del sistema
     * @return void
     */
    public function icon()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Profile/Logo/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["jpg", "jpeg", "png", "PNG", "JPG", "JPEG"])) {
                header("Content-Type: image/$fileType");
                readfile($filePath);
                exit;
            } else {
                echo "Imagen no encontrada.";
            }
        } else {
            echo "No se especificó ningún archivo.";
        }
    }
    /**
     * Metodo que abre pdf 
     * @return void
     */
    public function loanpdf()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Loan/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["PDF", "pdf"])) {
                header("Content-Type: application/$fileType");
                readfile($filePath);
                exit;
            } else {
                echo "Imagen no encontrada.";
            }
        } else {
            echo "No se especificó ningún archivo.";
        }
    }

    public function advancespdf()
    {
        if (isset($_GET['f'])) {
            $nameFile = $_GET['f'];
            $path = getRoute();
            $filePath = $path . "Advances/" . basename($nameFile);
            $fileType = pathinfo($filePath, PATHINFO_EXTENSION);
            if (file_exists($filePath) && in_array($fileType, ["PDF", "pdf"])) {
                header("Content-Type: application/$fileType");
                readfile($filePath);
                exit;
            } else {
                echo "Imagen no encontrada.";
            }
        } else {
            echo "No se especificó ningún archivo.";
        }
    }

}