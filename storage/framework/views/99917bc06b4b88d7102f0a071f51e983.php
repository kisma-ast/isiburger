<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture - ISI BURGER</title>
    <style>
        :root {
            --primary: #ff6b6b;
            --primary-dark: #ff5252;
            --secondary: #ffd166;
            --dark: #2d3436;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: var(--dark);
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            border-top: 3px solid var(--primary);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .logo {
            font-weight: 800;
            font-size: 28px;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .logo::after {
            content: "🍔";
            position: absolute;
            font-size: 18px;
            top: -10px;
            right: -25px;
            transform: rotate(15deg);
        }

        .invoice-title {
            font-size: 22px;
            margin-top: 10px;
            font-weight: 600;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .invoice-details {
            margin-bottom: 30px;
            padding: 20px;
            background: var(--light);
            border-radius: 10px;
            border-left: 4px solid var(--primary);
        }

        .invoice-details div {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .invoice-details strong {
            font-weight: 600;
            color: var(--primary-dark);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.03);
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        table th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        table tr:nth-child(even) {
            background-color: rgba(248, 249, 250, 0.5);
        }

        table tr:hover {
            background-color: rgba(255, 107, 107, 0.05);
        }

        .totals {
            text-align: right;
            padding: 20px;
            background: var(--light);
            border-radius: 10px;
            border-right: 4px solid var(--primary);
        }

        .totals div {
            margin-bottom: 8px;
            font-size: 15px;
        }

        .total {
            font-weight: 700;
            font-size: 20px;
            margin-top: 15px;
            color: var(--primary);
            padding-top: 10px;
            border-top: 2px dashed #eee;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 13px;
            color: #666;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .thankyou {
            margin-top: 30px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
            font-weight: 600;
            color: var(--dark);
            font-size: 16px;
            border-bottom: 3px solid var(--secondary);
        }

        .social-icons {
            margin-top: 15px;
        }

        .social-icons span {
            display: inline-block;
            margin: 0 5px;
            font-size: 16px;
        }

        .contact-info {
            margin-top: 10px;
            font-size: 12px;
        }

        .contact-info p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">|S|BURGER</div>
        <div class="invoice-title">FACTURE</div>
    </div>

    <div class="invoice-details">
        <div><strong>Facture N°:</strong> <?php echo e($order->id); ?></div>
        <div><strong>Date:</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?></div>
        <div><strong>Client:</strong> <?php echo e($order->user->name); ?></div>
        <div><strong>Email:</strong> <?php echo e($order->user->email); ?></div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->burger ? $item->burger->name : 'Burger indisponible'); ?></td>
                <td><?php echo e($item->quantity); ?></td>
                <td><?php echo e(number_format($item->price, 2)); ?> CFA</td>
                <td><?php echo e(number_format($item->price * $item->quantity, 2)); ?> CFA</td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="totals">
        <div><strong>Total HT:</strong> <?php echo e(number_format($order->total_amount / 1.2, 2)); ?> CFA</div>
        <div><strong>TVA (20%):</strong> <?php echo e(number_format($order->total_amount - ($order->total_amount / 1.2), 2)); ?> CFA</div>
        <div class="total">TOTAL TTC: <?php echo e(number_format($order->total_amount, 2)); ?> CFA</div>
    </div>

    <div class="thankyou">
        Merci pour votre commande !
    </div>

    <div class="footer">
        <div class="social-icons">
            <span>🔹</span>
            <span>🔹</span>
            <span>🔹</span>
        </div>
        <div class="contact-info">
            <p>📍 123 Avenue des Gourmets</p>
            <p>☎️ (01) 23 45 67 89</p>
            <p>✉️ contact@isiburger.com</p>
        </div>
        <p>&copy; <?php echo e(date('Y')); ?> ISI BURGER. Tous droits réservés.</p>
        <p>Le meilleur des burgers, préparés avec passion !</p>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\isi-burger\resources\views/pdf/invoice.blade.php ENDPATH**/ ?>