<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Slim 3</title>
    <link href='//fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <style>
        body {
            margin: 50px 0 0 0;
            padding: 0;
            width: 100%;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            text-align: center;
            color: #aaa;
            font-size: 18px;
        }

        h1 {
            color: #719e40;
            letter-spacing: -3px;
            font-family: 'Lato', sans-serif;
            font-size: 100px;
            font-weight: 200;
            margin-bottom: 0;
        }
        @php
          echo $debugbarRenderer->dumpCssAssets();
        @endphp

    </style>
    <script type="text/javascript">
        @php
          echo $debugbarRenderer->dumpJsAssets()
        @endphp
    </script>
</head>
<body>
<h1>Slim</h1>
<div>a microframework for PHP</div>
<p>Try <a href="http://www.slimframework.com">SlimFramework</a></p>
@php
  echo $debugbarRenderer->render();
@endphp
</body>
</html>