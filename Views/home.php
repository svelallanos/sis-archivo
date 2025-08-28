<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema de Archivo - Municipalidad Distrital Elías Soplin Vargas</title>

    <!-- SEO -->
    <meta name="description"
          content="Sistema de gestión de archivos de la Municipalidad Distrital de Elías Soplin Vargas. Administra y consulta documentos de manera eficiente.">
    <meta name="keywords"
          content="archivo municipal, gestión documental, Municipalidad Elías Soplin Vargas, sistema de archivos">
    <meta name="author" content="Oficina de Tecnologías de la Información y Comunicaciones">
    <meta name="robots" content="index, follow">

    <style>
        :root {
            --color-primary: #0B6E4F;
            --color-secondary: #F4D35E;
            --color-white: #ffffff;
            --color-black: #000000;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--color-primary);
            color: var(--color-white);
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        .container {
            height: 100vh;
            width: 100vw;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            animation: fadeIn 2s ease-in-out;
        }

        h1 {
            font-size: 3rem;
            color: var(--color-secondary);
            margin-bottom: 1rem;
            animation: slideDown 1s ease-out;
        }

        p {
            font-size: 1.2rem;
            max-width: 650px;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: slideUp 1.5s ease-out;
        }

        .btn {
            background-color: var(--color-secondary);
            color: var(--color-black);
            padding: 0.9rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.3s, background-color 0.3s;
            animation: fadeInButton 2s ease-in-out;
            margin: 0.5rem;
            display: inline-block;
        }

        .btn:hover {
            background-color: #e6c34e;
            transform: scale(1.05);
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
            background-color: rgba(0, 0, 0, 0.2);
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.98);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInButton {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 2.2rem;
            }

            p {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.7rem 1.5rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }

            p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Sistema de Archivo Municipal</h1>
    <p>Bienvenido al sistema de gestión documental de la Municipalidad Distrital de Elías Soplin Vargas. Aquí podrás
        registrar, organizar y consultar los archivos institucionales de manera rápida y segura.</p>
    <a href="login" class="btn">Ingresar al Sistema</a>
</div>

<footer>
    &copy; 2025 Municipalidad Distrital de Elías Soplin Vargas - Oficina de TICs
</footer>

</body>

</html>
