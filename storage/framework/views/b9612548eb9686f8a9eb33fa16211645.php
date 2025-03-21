

<?php $__env->startSection('title', 'Enregistrer un paiement'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Enregistrer un paiement pour la commande #<?php echo e($order->id); ?></h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-4 shadow-sm">
                            <h6 class="fw-bold">Résumé de la commande</h6>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><i class="fas fa-user me-2"></i> <strong>Client:</strong> <?php echo e($order->user->name); ?></p>
                                    <p><i class="fas fa-calendar me-2"></i> <strong>Date:</strong> <?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="fas fa-money-bill me-2"></i> <strong>Montant total:</strong>
                                        <span class="badge bg-success fs-6"><?php echo e(number_format($order->total_amount, 2)); ?> CFA</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="<?php echo e(route('payments.store', $order)); ?>" method="POST">
                            <?php echo csrf_field(); ?>

                            <div class="mb-4">
                                <label for="amount" class="form-label fw-bold">Montant payé (CFA) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                    <input type="number" step="0.01" min="<?php echo e($order->total_amount); ?>" class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="amount" name="amount" value="<?php echo e(old('amount', $order->total_amount)); ?>" required>
                                    <span class="input-group-text">CFA</span>
                                </div>
                                <div class="form-text text-muted"><i class="fas fa-info-circle me-1"></i> Le montant doit être au moins égal au total de la commande.</div>
                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Méthode de paiement</label>
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="method" id="methodCash" value="especes" checked>
                                            <label class="form-check-label" for="methodCash">
                                                <i class="fas fa-money-bill-wave me-2 text-success"></i> Espèces
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Annuler
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle me-2"></i> Confirmer le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/payments/create.blade.php ENDPATH**/ ?>