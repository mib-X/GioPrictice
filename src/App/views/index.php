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
<table>
    <tr>
        <th>Invoice #</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Email</th>
        <th>Status</th>
    </tr>
    <?php
    if (!empty($invoices)) : ?>
    <?php foreach ($invoices as $invoice) : ?>
        <tr>
            <td style="width:15%; text-align:center;"><?php echo $invoice['id']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['full_name']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['amount']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['email']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['status']; ?></td>
        </tr>
    <?php endforeach; ?>
    <?php endif;?>

</table>

</body>
</html>