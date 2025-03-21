

<?php $__env->startSection('title', 'Tableau de bord administrateur'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold">Tableau de bord administrateur</h1>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('burgers.create')); ?>" class="btn btn-primary d-flex align-items-center">
                    <i class="fas fa-plus me-2"></i> Nouveau burger
                </a>
                <button class="btn btn-light border" id="refreshDashboard">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Cartes statistiques avec design amélioré -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-semibold mb-1">Utilisateurs</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalUsers); ?></h2>
                            </div>
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded p-3">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-primary" style="width: 85%"></div>
                        </div>
                        <p class="text-muted mt-2 mb-0 small">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <span>+5% depuis le mois dernier</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-semibold mb-1">Produits</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalBurgers); ?></h2>
                            </div>
                            <div class="icon-shape bg-success bg-opacity-10 text-success rounded p-3">
                                <i class="fas fa-hamburger"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-success" style="width: 65%"></div>
                        </div>
                        <p class="text-muted mt-2 mb-0 small">
                            <i class="fas fa-plus-circle text-success me-1"></i>
                            <span>Burgers disponibles</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-semibold mb-1">En attente</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($pendingOrders); ?></h2>
                            </div>
                            <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded p-3">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-warning" style="width: <?php echo e(min(100, $pendingOrders * 5)); ?>%"></div>
                        </div>
                        <p class="text-muted mt-2 mb-0 small">
                            <i class="fas fa-exclamation-circle text-warning me-1"></i>
                            <span>Commandes à traiter</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-semibold mb-1">Commandes</h6>
                                <h2 class="fw-bold mb-0"><?php echo e($totalOrders); ?></h2>
                            </div>
                            <div class="icon-shape bg-info bg-opacity-10 text-info rounded p-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 4px;">
                            <div class="progress-bar bg-info" style="width: 78%"></div>
                        </div>
                        <p class="text-muted mt-2 mb-0 small">
                            <i class="fas fa-arrow-up text-success me-1"></i>
                            <span>+12% cette semaine</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section principale avec commandes et autres informations -->
        <div class="row g-4 mt-2">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Commandes récentes</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="orderFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-1"></i> Filtrer
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="orderFilterDropdown">
                                <li><a class="dropdown-item" href="#">Toutes les commandes</a></li>
                                <li><a class="dropdown-item" href="#">En attente</a></li>
                                <li><a class="dropdown-item" href="#">En préparation</a></li>
                                <li><a class="dropdown-item" href="#">Prêtes</a></li>
                                <li><a class="dropdown-item" href="#">Payées</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <?php if(count($recentOrders) > 0): ?>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase small fw-bold ps-4">ID</th>
                                        <th class="text-uppercase small fw-bold">Client</th>
                                        <th class="text-uppercase small fw-bold">Date</th>
                                        <th class="text-uppercase small fw-bold">Total</th>
                                        <th class="text-uppercase small fw-bold">Statut</th>
                                        <th class="text-uppercase small fw-bold text-end pe-4">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="fw-bold">#<?php echo e($order->id); ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2 bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center">
                                                        <span><?php echo e(substr($order->user->name, 0, 1)); ?></span>
                                                    </div>
                                                    <div><?php echo e($order->user->name); ?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <span><?php echo e($order->created_at->format('d/m/Y')); ?></span>
                                                <div class="small text-muted"><?php echo e($order->created_at->format('H:i')); ?></div>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?php echo e(number_format($order->total_amount, 2)); ?> €</span>
                                            </td>
                                            <td>
                                                <?php switch($order->status):
                                                    case ('en_attente'): ?>
                                                        <span class="badge rounded-pill bg-warning text-dark">En attente</span>
                                                        <?php break; ?>
                                                    <?php case ('en_preparation'): ?>
                                                        <span class="badge rounded-pill bg-info">En préparation</span>
                                                        <?php break; ?>
                                                    <?php case ('prete'): ?>
                                                        <span class="badge rounded-pill bg-success">Prête</span>
                                                        <?php break; ?>
                                                    <?php case ('payee'): ?>
                                                        <span class="badge rounded-pill bg-primary">Payée</span>
                                                        <?php break; ?>
                                                    <?php default: ?>
                                                        <span class="badge rounded-pill bg-secondary"><?php echo e($order->status); ?></span>
                                                <?php endswitch; ?>
                                            </td>
                                            <td class="pe-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Voir les détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Mettre à jour le statut">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <div class="text-muted small">Affichage de <?php echo e(count($recentOrders)); ?> commandes récentes</div>
                                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-outline-primary">
                                    Voir toutes les commandes <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info text-center m-3">
                                <i class="fas fa-info-circle me-2"></i> Aucune commande récente.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Actions rapides -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold py-3">
                        <h5 class="mb-0 fw-bold">Actions rapides</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('burgers.create')); ?>" class="btn btn-primary d-flex align-items-center justify-content-between">
                                <span><i class="fas fa-plus me-2"></i> Ajouter un burger</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="<?php echo e(route('statistics.index')); ?>" class="btn btn-info text-white d-flex align-items-center justify-content-between">
                                <span><i class="fas fa-chart-bar me-2"></i> Voir les statistiques</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <a href="<?php echo e(route('burgers.index')); ?>" class="btn btn-light border d-flex align-items-center justify-content-between">
                                <span><i class="fas fa-cog me-2"></i> Gérer les burgers</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Liens utiles & Activité récente -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold">Activité récente</h5>
                        <a href="#" class="btn btn-sm btn-light">Voir tout</a>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center p-3 border-start-0 border-end-0">
                                <div class="avatar bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                    <i class="fas fa-hamburger"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Nouveau burger ajouté</p>
                                    <small class="text-muted">Il y a 2 heures</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-start-0 border-end-0">
                                <div class="avatar bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <p class="mb-0">Nouveau client inscrit</p>
                                    <small class="text-muted">Il y a 3 heures</small>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center p-3 border-start-0 border-end-0">
                                <div class="avatar bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <p class="mb-0">3 nouvelles commandes</p>
                                    <small class="text-muted">Il y a 5 heures</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Liens rapides</h6>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="<?php echo e(route('burgers.catalog')); ?>" class="btn btn-sm btn-light border">
                                <i class="fas fa-hamburger me-1"></i> Catalogue
                            </a>
                            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-sm btn-light border">
                                <i class="fas fa-list me-1"></i> Commandes
                            </a>
                            <a href="#" class="btn btn-sm btn-light border">
                                <i class="fas fa-users me-1"></i> Clients
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        // Initialiser les tooltips Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // Bouton de rafraîchissement du tableau de bord
        document.getElementById('refreshDashboard').addEventListener('click', function() {
            location.reload();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/dashboard/gestionnaire.blade.php ENDPATH**/ ?>