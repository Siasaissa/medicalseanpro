<?php
    $logoBase64 = null;
    $logoPath = public_path('img/greatcare-logo-02.png');

    if (file_exists($logoPath)) {
        $imageData = file_get_contents($logoPath);
        $logoBase64 = 'data:image/png;base64,' . base64_encode($imageData);
    }
?>



<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> INVOICE <?php echo e($invoice->customer_name); ?></title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    font-size: 9px;
    color: #000;
    padding: 15px;
    background: #fff;
}

.invoice-wrapper {
    max-width: 210mm;
    margin: 0 auto;
}

/* Header Section with Logo and Bill To side by side */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #000;
}

.header-left {
    flex: 1;
    padding-right: 20px;
}

.logo-placeholder {
    width: 80px;
    height: 80px;
    background-color: #e0e0e0;
    border: 1px solid #999;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 8px;
    color: #666;
    margin-bottom: 10px;
}

.company-info {
    font-size: 8px;
    line-height: 1.5;
}

.company-name {
    font-weight: bold;
    font-size: 10px;
    margin-bottom: 3px;
}

.header-right {
    flex: 1;
}

.bill-to-label {
    font-weight: bold;
    font-size: 9px;
    margin-bottom: 5px;
}

.customer-info {
    font-size: 9px;
    line-height: 1.5;
}

/* Invoice Title */
.invoice-title {
    text-align: center;
    font-size: 14px;
    font-weight: bold;
    margin: 10px 0;
    padding: 5px 0;
}

/* Meta Table - 2 rows x 3 columns */
.meta-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
    font-size: 9px;
}

.meta-table td {
    border: 1px solid #000;
    padding: 5px 8px;
}

.meta-label {
    font-weight: bold;
}

/* Items Table */
.items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
    font-size: 8px;
}

.items-table th {
    background-color: transparent;
    border: 1px solid #000;
    padding: 5px 3px;
    font-weight: bold;
    font-size: 8px;
}

.items-table td {
    border: 1px solid #000;
    padding: 4px 3px;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.text-left {
    text-align: left;
}

/* Bottom Section - Terms and Totals side by side */
.bottom-section {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.terms-section {
    flex: 1.5;
    padding-right: 20px;
    font-size: 7px;
    line-height: 1.6;
}

.terms-title {
    font-weight: bold;
    font-size: 8px;
    margin-bottom: 5px;
}

.totals-section {
    flex: 1;
    min-width: 250px;
}

.totals-table {
    width: 100%;
    font-size: 9px;
}

.totals-table td {
    padding: 4px 4px;
    border: 1px solid #000;
}

.totals-table .label {
    font-weight: bold;
    text-align: left;
}

.totals-table .value {
    text-align: right;
}

.total-row {
    border-top: 1px solid #000;
    font-weight: bold;
}

.bottom-print-table {
    width: 100%;
    margin-top: 15px;
    border-collapse: collapse;
}

.terms-cell {
    width: 65%;
    font-size: 7px;
    line-height: 1.6;
    vertical-align: top;
    padding-right: 15px;
}

.totals-cell {
    width: 35%;
    vertical-align: top;
}

.header-print-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.header-left-cell,
.header-right-cell {
    width: 50%;
    vertical-align: top;
    padding: 5px;
}

.header-right-cell {
    text-align: right;
}



@media print {
    body {
        padding: 5mm;
    }
}
</style>
</head>
<body>

<div class="invoice-wrapper">
    
    <table class="header-print-table">
    <tr>
        <!-- LEFT: Bill To -->
        <td class="header-left-cell">
            
<?php if($logoBase64): ?>
    <img src="<?php echo e($logoBase64); ?>" style="height:100px;width:auto;">
<?php else: ?>
    <div style="font-size:8px;color:red;">LOGO NOT FOUND</div>
<?php endif; ?>


            <div class="bill-to-label">BILL TO :</div>
            <div class="customer-info">
                <strong><?php echo e($invoice->customer_name); ?></strong><br>
                <?php echo e($invoice->customer_address); ?><br>
                <?php echo e($invoice->customer_phone); ?>

            </div>
        </td>

        <!-- RIGHT: Company Info -->
        <td class="header-right-cell">
            <?php if($logoBase64): ?>
                <img src="<?php echo e($logoBase64); ?>" style="height:100px;width:auto;">
            <?php endif; ?>
            
            <div class="company-name">GREATCARE MEDICS CO. LTD</div>
            <div class="company-info">
                Plot No. 123 Uhuru Road / Arusha Street<br>
                P.O. BOX 11110, Ilala, Amana, Dar es Salaam<br>
                +255 766 638 701 / +255 716 191 948<br>
                TIN : 136-605-623 | VRN : 40275917-H<br>
                info@greatcaremedics.co.tz | www.greatcare.co.tz
            </div>
        </td>
    </tr>
</table>


    <!-- INVOICE TITLE -->
    <div class="invoice-title"> INVOICE</div>

    <!-- META TABLE: 2 rows x 3 columns with borders -->
    <table class="meta-table">
        <tr>
            <td class="meta-label">Invoice # :  <?php echo e($invoice->invoice_number); ?></td>
            <td>REF # :</td>
            <td class="meta-label">Currency :   TZS</td>
        </tr>
        <tr>
            <td class="meta-label">Invoice Date :  <?php echo e($invoice->invoice_date->format('m-d-Y')); ?></td>
            <td>Customer TIN :</td>
            <td class="meta-label">Created By : Greatcare Medics</td>
        </tr>
    </table>

    <!-- ITEMS TABLE -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 40%;" class="text-left">Product</th>
                <th style="width: 8%;">Qty</th>
                <th style="width: 5%;">Rate</th>
                <th style="width: 14%;">Amount</th>

            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->product); ?></td>
                <td class="text-center"><?php echo e(number_format($item->qty, 2)); ?></td>
                <td class="text-center"><?php echo e(number_format($item->rate, 2)); ?></td>
                <td class="text-right"><?php echo e(number_format($item->amount, 2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- BOTTOM: Terms on Left, Totals on Right (Same Row) -->
    <table class="bottom-print-table">
    <tr>
        <td class="terms-cell">
            <div class="terms-title">TERMS:</div>
            1. All goods are supplied on GREATCARE MEDICS CO. LTD sale basis.<br>
            2. Account holder invoices is due strictly 30 days from the date of invoice.<br>
            3. All overdue accounts the company reserves right to charge interest at 3% rate of total.<br>
            4. All cash payment should be made directly by cash or through the following account;<br>
            5. ACCOUNT NAME; GREATCARE MEDICS CO. LTD, BANK NAME; UNITED BANK OF AFRICA (TZ) LTD (UBA)<br>
            ACCOUNT NO: 56010030007932<br>
            6. TIGO : LIPA NUMBER 7834898, GREATCARE MEDICS CO LTD.
        </td>

        <td class="totals-cell">
            <table class="totals-table">
                <tr>
                    <td class="label">Sub Total :</td>
                    <td class="value">Tsh <?php echo e(number_format($invoice->subtotal, 2)); ?></td>
                </tr>
                <tr>
                    <td class="label">VAT :</td>
                    <td class="value">0.00</td>
                </tr>
                <tr>
                    <td class="label">Transport :</td>
                    <td class="value">Tsh <?php echo e(number_format($invoice->shipping_charges, 2)); ?></td>
                </tr>
                <tr class="total-row">
                    <td class="label">Total :</td>
                    <td class="value">Tsh <?php echo e(number_format($invoice->balance, 2)); ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

    </div>

</div>

</body>
</html><?php /**PATH /Users/dope/Downloads/public_htm/resources/views/admin/Invoice/pdf.blade.php ENDPATH**/ ?>