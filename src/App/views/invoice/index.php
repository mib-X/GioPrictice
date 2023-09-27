<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoices</title>
</head>
<body>
<table>
    <tr>
        <th>Invoice #</th>
        <th>Amount</th>
        <th>Status</th>
    </tr>
    <?php
    if (!empty($invoices)) :
        foreach ($invoices as $invoice) : ?>
        <tr>
            <td style="width:33%; text-align:center;"><?php echo $invoice['id']; ?></td>
            <td style="width:33%; text-align:center;"><?php echo $invoice['amount']; ?></td>
            <td style="width:33%; text-align:center;"><?php echo $invoice['status']; ?></td>
        </tr>
        <?php endforeach;
    endif;?>

</table>
</body>
</html>