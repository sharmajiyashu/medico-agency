<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .btn{
            background-color: #7070ec;
            color: white;
            min-width: 80%;
            border-color: white;
            padding: 6px;
        }
    </style>
</head>
<body style="text-align: center;">
    <div style="min-width: 60%">
        <h2>We got a request to reset your Medico password.</h2>
        <a href="{{ $testMailData['link'] }}"><button class="btn">Reset Password</button></a>
        <h3>If you ignore this message, your password will not be changed. </h3>
    </div>
    
</body>
</html>