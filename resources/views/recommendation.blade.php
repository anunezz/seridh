
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />

    <title>Notice</title>

    <style>
        @font-face
        {
            font-family: "Montserrat";
            font-style: normal;
            font-weight: normal;
            src: url('{{storage_path()}}/fonts/Montserrat-Regular.ttf')  format('truetype');
        }
        @font-face
        {
            font-family: "Montserrat";
            font-style: normal;
            font-weight: bold;
            src: url('{{storage_path()}}/fonts/Montserrat-Bold.ttf')  format('truetype');

        }
        @font-face
        {
            font-family: "Montserrat";
            src: url('{{storage_path()}}/fonts/Montserrat-Italic.ttf')  format('truetype');
            font-style: italic;
        }
        @font-face
        {
            font-family: "Montserrat";
            src: url('{{storage_path()}}/fonts/Montserrat-BoldItalic.ttf')  format('truetype');
            font-weight: bold;
            font-style: italic;
        }
        html, body
        {
            font-family: 'Montserrat';
            font-style: normal;
            padding:0px 0px 0px 0px !important;
        }
        p, li
        {
            font-family: 'Montserrat';
            font-style: normal;
        }

        body
        {
            background-color: #ffffff;
            /*background:  url('/img/fondo.png') no-repeat;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;*/
        }
        table, td, th
        {
            border: 1px solid black;
        }

        table
        {
            border-collapse: collapse;
            width: 100%;
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: normal;
        }

        th
        {
            height: 50px;
        }

        #header
        {
            position: fixed;
            left: 0px;
            top: -180px;
            right: 0px;
            height: 150px;
            background-color: white;
            text-align: center;
        }

        #footer .page:after
        {
            content: counter(page, upper-roman);
        }
        .footer
        {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .footer
        {
            bottom: 0px;
        }

        .pagenum:before
        {
            content: counter(page);
        }

        .break-word
        {
            word-wrap:break-word;
            width:100%;
            display:block;
        }
        .header-logo
        {
            background-color: #f2f2f2;
            width: 100%;
            height: 30px;
            padding: 20px;
        }
        .header-logo-title
        {
            background-color: #c0c0c0;
            width: 100%;
            height: 30px;
            text-align: center;
            font-size: 15px;
        }
        .container-body
        {
            border: 0px solid black;
            padding: 0px 0px 0px 0px;
            position: absolute;
            width: 100%;
            font-size: 12px;

        }
        .center
        {
            text-align: center;
            font-weight: bold;
            padding: 10px;
        }

        .header-info
        {
            background-color: #c0c0c0;
            width: 100%;
            font-size: 12px;
        }
        .text-aling{
            padding: 100px 200px 100px 110px;
        }

        .body-requisitos
        {
            background-color: #f2f2f2;
            width: 100%;
            font-size: 12px;
            padding: 20px;
        }
        table tbody,tr,td
        {
            border: none !important;
        }
    </style>

</head>
<style>
</style>
<body>

<div class="header-logo">
    <img src="img/pdf/gobmx.png" width="100px" alt="GOBMX">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    <span style="font-size: 25px;"><strong>SERIDH</strong></span>
</div>

<div class="header-logo-title">
    <b>Secretaría de Relaciones Exteriores</b>
</div>




</div>

</body>
</html>
