<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
<h2>Home</h2>
<?php if (!empty($invoice)) { ?>
    <?php echo $invoice['full_name'];?> <br>
    <?php echo $invoice['email'];?> <br>
    <?php echo $invoice['amount'];?> <br>
<?php } ;?>

</body>
</html>