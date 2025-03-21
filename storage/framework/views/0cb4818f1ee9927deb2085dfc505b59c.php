

<?php $__env->startSection('title', 'Panier'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Mon panier</h1>

    <?php if(count($cart) > 0): ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Articles dans votre panier</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th class="text-end">Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if(isset($item['image']) && $item['image']): ?>
                                                        <img src="<?php echo e(asset('storage/' . $item['image'])); ?>" alt="<?php echo e($item['name']); ?>" class="me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="bg-light text-center me-2" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-hamburger text-muted" style="line-height: 50px;"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <span><?php echo e($item['name']); ?></span>
                                                </div>
                                            </td>
                                            <td><?php echo e(number_format($item['price'], 2)); ?> CFA</td>
                                            <td>
                                                <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="d-flex align-items-center">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                    <input type="hidden" name="burger_id" value="<?php echo e($id); ?>">
                                                    <input type="number" name="quantity" value="<?php echo e($item['quantity']); ?>" min="1" class="form-control form-control-sm" style="width: 60px;">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end"><?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?> CFA</td>
                                            <td>
                                                <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <input type="hidden" name="burger_id" value="<?php echo e($id); ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Récapitulatif</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                Sous-total
                                <span><?php echo e(number_format($totalPrice, 2)); ?> CFA</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                TVA (20%)
                                <span><?php echo e(number_format($totalPrice * 0.2, 2)); ?> CFA</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 fw-bold">
                                <div class="text-uppercase">Total</div>
                                <span><?php echo e(number_format($totalPrice, 2)); ?> CFA</span>
                            </li>
                        </ul>

                        <form action="<?php echo e(route('orders.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check"></i> Valider ma commande
                            </button>
                        </form>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="<?php echo e(route('burgers.catalog')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Continuer les achats
                            </a>
                            <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i> Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <p>Votre panier est vide.</p>
            <a href="<?php echo e(route('burgers.catalog')); ?>" class="btn btn-primary mt-2">
                <i class="fas fa-shopping-basket"></i> Parcourir le catalogue
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/cart/index.blade.php ENDPATH**/ ?>