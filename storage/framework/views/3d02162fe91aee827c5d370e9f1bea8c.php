<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de commande</title>
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
            line-height: 1.6;
            color: var(--dark);
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }

        .header::after {
            content: "🍔";
            position: absolute;
            font-size: 30px;
            top: 10px;
            right: 20px;
            transform: rotate(15deg);
        }

        .logo {
            font-weight: 800;
            font-size: 20px;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-weight: 800;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .content {
            padding: 30px;
            background-color: white;
            position: relative;
        }

        .content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ff6b6b' fill-opacity='0.03' fill-rule='evenodd'%3E%3Cpath d='M20 0a20 20 0 1 0 0 40 20 20 0 0 0 0-40zm0 30a10 10 0 1 1 0-20 10 10 0 0 1 0 20z'/%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
            opacity: 0.2;
        }

        .content > * {
            position: relative;
            z-index: 1;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .order-info {
            background-color: var(--light);
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid var(--primary);
        }

        .order-title {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-size: 16px;
        }

        ul.order-items {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        ul.order-items li {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        ul.order-items li:last-child {
            border-bottom: none;
        }

        .order-total {
            font-weight: 700;
            color: var(--primary);
            font-size: 18px;
            margin-top: 10px;
            text-align: right;
        }

        .status-badge {
            display: inline-block;
            background-color: var(--secondary);
            color: var(--dark);
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .message {
            background-color: #fff9e6;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
            border-left: 4px solid var(--secondary);
        }

        .thanks {
            font-weight: 600;
            font-size: 18px;
            text-align: center;
            margin-top: 30px;
            color: var(--primary);
        }

        .button-container {
            text-align: center;
            margin: 25px 0;
        }

        .button {
            display: inline-block;
            background-color: var(--primary);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(255, 107, 107, 0.3);
            transition: all 0.3s;
        }

        .button:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(255, 107, 107, 0.4);
        }

        .footer {
            background: linear-gradient(135deg, var(--dark) 0%, #1e272e 100%);
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary), var(--secondary), var(--primary));
        }

        .social-icons {
            margin-bottom: 15px;
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

        .copyright {
            margin-top: 15px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">|S|BURGER</div>
        <h1>Commande confirmée !</h1>
    </div>
    <div class="content">
        <p class="greeting">Bonjour <?php echo e($order->user->name); ?>,</p>
        <p>Merci d'avoir commandé chez ISI BURGER. Votre commande a été enregistrée avec succès et nous la préparons avec passion.</p>

        <div class="order-info">
            <p class="order-title">Récapitulatif de la commande #<?php echo e($order->id); ?> :</p>
            <ul class="order-items">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($item->quantity); ?>x <?php echo e($item->burger->name); ?> - <?php echo e(number_format($item->price, 2)); ?> €</li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <p class="order-total">Total : <?php echo e(number_format($order->total_amount, 2)); ?> €</p>
        </div>

        <p>Statut actuel : <span class="status-badge">En attente</span></p>

        <div class="message">
            <p>Vous recevrez un email avec votre facture lorsque votre commande sera prête.</p>
            <p>Nous préparons votre commande avec le plus grand soin pour vous offrir une expérience gustative exceptionnelle !</p>
        </div>

        <div class="button-container">
            <a href="<?php echo e(url('/orders/' . $order->id)); ?>" class="button">Suivre ma commande</a>
        </div>

        <p class="thanks">Merci d'avoir choisi ISI BURGER !</p>
    </div>
    <div class="footer">
        <div class="social-icons">
            <span>f</span>
            <span>in</span>
            <span>tw</span>
        </div>
        <div class="contact-info">
            <p>123 Avenue des Gourmets</p>
            <p>(01) 23 45 67 89</p>
            <p>contact@isiburger.com</p>
        </div>
        <div class="copyright">
            <p>&copy; <?php echo e(date('Y')); ?> ISI BURGER. Tous droits réservés.</p>
            <p>Le meilleur des burgers, préparés avec passion !</p>
        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\laragon\www\isi-burger\resources\views/emails/order-confirmation.blade.php ENDPATH**/ ?>