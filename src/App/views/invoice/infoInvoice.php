<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Info about invoice</title>
</head>
<body>
<table>
    <tr>
        <th>Invoice #</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Email</th>
        <th>Status</th>
    </tr>
    <?php
    if (!empty($invoice)) : ?>
        <tr>
            <td style="width:15%; text-align:center;"><?php echo $invoice['invoice_id']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['full_name']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['amount']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['email']; ?></td>
            <td style="width:15%; text-align:center;"><?php echo $invoice['invoice_status']; ?></td>
        </tr>
    <?php endif;?>

</table>
</body>
</html>
