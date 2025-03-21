

<?php $__env->startSection('title', Auth::user()->isGestionnaire() ? 'Tableau de bord - Commandes' : 'Suivi de commandes'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4 py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-shopping-bag me-2"></i>
                <?php echo e(Auth::user()->isGestionnaire() ? 'Tableau de bord des commandes' : 'Suivi de mes commandes'); ?>

            </h1>

            <?php if(!Auth::user()->isGestionnaire()): ?>
                <a href="<?php echo e(route('burgers.catalog')); ?>" class="btn btn-primary rounded-pill">
                    <i class="fas fa-plus me-1"></i> Nouvelle commande
                </a>
            <?php endif; ?>
        </div>

        <?php if(Auth::user()->isGestionnaire()): ?>
            <!-- Statistiques des commandes -->
            <div class="row g-4 mb-5">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-2">En attente</h6>
                                    <h2 class="mb-0 display-5"><?php echo e($orders->where('status', 'en_attente')->count()); ?></h2>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 5px;">
                                <div class="progress-bar bg-warning" style="width: 100%"></div>
                            </div>
                        </div>
                        <a href="<?php echo e(route('orders.index', ['status' => 'en_attente'])); ?>" class="text-decoration-none">
                            <div class="card-footer bg-warning bg-opacity-10 border-0 py-2">
                                <span class="text-warning small">Voir toutes <i class="fas fa-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-2">En préparation</h6>
                                    <h2 class="mb-0 display-5"><?php echo e($orders->where('status', 'en_preparation')->count()); ?></h2>
                                </div>
                                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                    <i class="fas fa-blender fa-2x text-info"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 5px;">
                                <div class="progress-bar bg-info" style="width: 100%"></div>
                            </div>
                        </div>
                        <a href="<?php echo e(route('orders.index', ['status' => 'en_preparation'])); ?>" class="text-decoration-none">
                            <div class="card-footer bg-info bg-opacity-10 border-0 py-2">
                                <span class="text-info small">Voir toutes <i class="fas fa-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-2">Prêtes</h6>
                                    <h2 class="mb-0 display-5"><?php echo e($orders->where('status', 'prete')->count()); ?></h2>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            </div>
                        </div>
                        <a href="<?php echo e(route('orders.index', ['status' => 'prete'])); ?>" class="text-decoration-none">
                            <div class="card-footer bg-success bg-opacity-10 border-0 py-2">
                                <span class="text-success small">Voir toutes <i class="fas fa-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden">
                        <div class="card-body position-relative">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-uppercase text-muted mb-2">Payées</h6>
                                    <h2 class="mb-0 display-5"><?php echo e($orders->where('status', 'payee')->count()); ?></h2>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="fas fa-money-bill-wave fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 5px;">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>
                        <a href="<?php echo e(route('orders.index', ['status' => 'payee'])); ?>" class="text-decoration-none">
                            <div class="card-footer bg-primary bg-opacity-10 border-0 py-2">
                                <span class="text-primary small">Voir toutes <i class="fas fa-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filtres -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="<?php echo e(route('orders.index')); ?>" method="GET" class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label for="status" class="form-label text-muted small text-uppercase">Statut</label>
                            <select name="status" id="status" class="form-select rounded-pill">
                                <option value="">Tous les statuts</option>
                                <option value="en_attente" <?php echo e(request('status') === 'en_attente' ? 'selected' : ''); ?>>En attente</option>
                                <option value="en_preparation" <?php echo e(request('status') === 'en_preparation' ? 'selected' : ''); ?>>En préparation</option>
                                <option value="prete" <?php echo e(request('status') === 'prete' ? 'selected' : ''); ?>>Prêtes</option>
                                <option value="payee" <?php echo e(request('status') === 'payee' ? 'selected' : ''); ?>>Payées</option>
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label for="date" class="form-label text-muted small text-uppercase">Date</label>
                            <input type="date" name="date" id="date" class="form-control rounded-pill" value="<?php echo e(request('date')); ?>">
                        </div>
                        <div class="col-lg-4 col-md-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fas fa-filter me-1"></i> Filtrer
                            </button>
                            <?php if(request('status') || request('date')): ?>
                                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-outline-secondary rounded-pill">
                                    <i class="fas fa-undo me-1"></i> Réinitialiser
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Liste des commandes -->
        <?php if($orders->count() > 0): ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <?php if(Auth::user()->isGestionnaire()): ?>
                                    <th>Client</th>
                                <?php endif; ?>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-bold">#<?php echo e($order->id); ?></td>
                                    <?php if(Auth::user()->isGestionnaire()): ?>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary bg-opacity-10 text-primary me-2">
                                                    <?php echo e(substr($order->user->name, 0, 1)); ?>

                                                </div>
                                                <?php echo e($order->user->name); ?>

                                            </div>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <div><?php echo e($order->created_at->format('d/m/Y')); ?></div>
                                        <small class="text-muted"><?php echo e($order->created_at->format('H:i')); ?></small>
                                    </td>
                                    <td class="fw-bold"><?php echo e(number_format($order->total_amount, 0, ',', ' ')); ?> CFA</td>
                                    <td>
                                        <?php switch($order->status):
                                            case ('en_attente'): ?>
                                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                    <i class="fas fa-clock me-1"></i> En attente
                                                </span>
                                                <?php break; ?>
                                            <?php case ('en_preparation'): ?>
                                                <span class="badge bg-info text-dark rounded-pill px-3 py-2">
                                                    <i class="fas fa-blender me-1"></i> En préparation
                                                </span>
                                                <?php break; ?>
                                            <?php case ('prete'): ?>
                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i> Prête
                                                </span>
                                                <?php break; ?>
                                            <?php case ('payee'): ?>
                                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                                    <i class="fas fa-money-bill-wave me-1"></i> Payée
                                                </span>
                                                <?php break; ?>
                                            <?php default: ?>
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                    <?php echo e($order->status); ?>

                                                </span>
                                        <?php endswitch; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="dropdown-item">
                                                        <i class="fas fa-eye text-primary me-2"></i> Détails
                                                    </a>
                                                </li>

                                                <?php if(Auth::user()->isGestionnaire() && $order->status === 'prete'): ?>
                                                    <li>
                                                        <a href="<?php echo e(route('payments.create', $order)); ?>" class="dropdown-item">
                                                            <i class="fas fa-money-bill text-success me-2"></i> Paiement
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php if($order->status === 'prete' || $order->status === 'payee'): ?>
                                                    <li>
                                                        <a href="<?php echo e(route('orders.invoice', $order)); ?>" class="dropdown-item">
                                                            <i class="fas fa-file-pdf text-danger me-2"></i> Facture
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <?php echo e($orders->links('pagination::bootstrap-5')); ?>

            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <div class="text-center">
                        <img src="<?php echo e(asset('images/empty-orders.svg')); ?>" alt="Aucune commande" class="img-fluid mb-3" style="max-height: 200px;">
                        <h3 class="h5 text-muted">
                            <?php if(Auth::user()->isGestionnaire()): ?>
                                Aucune commande trouvée
                            <?php else: ?>
                                Vous n'avez pas encore passé de commande
                            <?php endif; ?>
                        </h3>
                        <?php if(!Auth::user()->isGestionnaire()): ?>
                            <a href="<?php echo e(route('burgers.catalog')); ?>" class="btn btn-primary rounded-pill mt-3">
                                <i class="fas fa-hamburger me-2"></i> Découvrir notre menu
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <style>
        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/orders/index.blade.php ENDPATH**/ ?>