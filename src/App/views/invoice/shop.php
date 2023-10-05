<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shop</title>
</head>
<body>
<?php if (isset($amount) and isset($id)) {
    echo "Invoice with amount " . $amount . " добавлен под id = " . $id ;
} ?>
</body>
</html>
