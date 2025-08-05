<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Número da Sacola</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .logo {
            float: left;
            width: 20%;
        }

        .logo img {
            height: 100px;
        }

        .titulo {
            float: left;
            width: 80%;
            line-height: 100px;
            font-size: 30px;
            margin: 0;
            margin-left: 15%
        }

        .numero {
            text-align: center;
            font-size: 100px;
            margin-top: 50px;
        }

        .data {
            text-align: right;
            font-size: 25px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ public_path('images/logo.jpg') }}" alt="logo">
        </div>
        <div class="titulo">
            Número da Sacola
        </div>
    </div>
    <div class="numero">
        <p>{{ $documento->numero }}</p>
    </div>
    <div class="data">
        <p>{{ \Carbon\Carbon::parse($documento->dt_doc)->format('d/m/Y') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
