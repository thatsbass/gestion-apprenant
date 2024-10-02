<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <style>
        /* CSS défini ici */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            background-color: #3498db;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        h1 {
            color: #3498db;
            text-align: center;
        }
        footer {
            background-color: #3498db;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        table {
            border-color: 1px #333;
            font-size: 90%;
        }
        th {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            text-align: left;
            padding: auto;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:nth-child(odd) {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <header>
        <h1>@yield('title')</h1>
    </header>
    <div class="container">
        @yield('content')
    </div>
    <footer>
    </footer>

    <script>
        // JavaScript défini ici
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page chargée');
        });
    </script>
</body>
</html>
