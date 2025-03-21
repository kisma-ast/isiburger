

<?php $__env->startSection('title', 'Gestion des burgers'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-4">
        <!-- En-tête avec animation subtile -->
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
            <h1 class="fw-bold text-primary">
                <i class="fas fa-hamburger me-2"></i>Gestion des burgers
            </h1>
            <a href="<?php echo e(route('burgers.create')); ?>" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus me-1"></i> Ajouter un burger
            </a>
        </div>

        <!-- Notification avec animation -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Carte principale avec ombre et coins arrondis -->
        <div class="card shadow rounded-3 border-0 overflow-hidden">
            <!-- Formulaire de recherche avec style amélioré -->
            <div class="card-header bg-light">
                <form action="<?php echo e(route('burgers.index')); ?>" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="small text-muted mb-1"><i class="fas fa-search me-1"></i>Nom du burger</label>
                            <input type="text" class="form-control border-0 shadow-sm" name="search" placeholder="Rechercher un burger..." value="<?php echo e(request('search')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="small text-muted mb-1"><i class="fas fa-coins me-1"></i>Prix minimum</label>
                            <input type="number" step="0.01" class="form-control border-0 shadow-sm" name="min_price" placeholder="Prix min" value="<?php echo e(request('min_price')); ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="small text-muted mb-1"><i class="fas fa-coins me-1"></i>Prix maximum</label>
                            <input type="number" step="0.01" class="form-control border-0 shadow-sm" name="max_price" placeholder="Prix max" value="<?php echo e(request('max_price')); ?>">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary w-100 shadow-sm">
                                <i class="fas fa-filter me-1"></i>Filtrer
                            </button>
                        </div>
                        <?php if(request('search') || request('min_price') || request('max_price')): ?>
                            <div class="col-md-2">
                                <a href="<?php echo e(route('burgers.index')); ?>" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-undo me-1"></i>Réinitialiser
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <?php if($burgers->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $burgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $burger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($burger->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $burger->image)); ?>" alt="<?php echo e($burger->name); ?>" class="rounded shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded shadow-sm text-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-hamburger text-muted" style="line-height: 60px; font-size: 1.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-medium"><?php echo e($burger->name); ?></td>
                                    <td class="fw-bold text-primary"><?php echo e(number_format($burger->price, 2)); ?> CFA</td>
                                    <td>
                                        <?php if($burger->stock > 10): ?>
                                            <span class="badge bg-success rounded-pill px-3"><i class="fas fa-check-circle me-1"></i><?php echo e($burger->stock); ?></span>
                                        <?php elseif($burger->stock > 0): ?>
                                            <span class="badge bg-warning text-dark rounded-pill px-3"><i class="fas fa-exclamation-circle me-1"></i><?php echo e($burger->stock); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger rounded-pill px-3"><i class="fas fa-times-circle me-1"></i>Rupture</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($burger->is_archived): ?>
                                            <span class="badge bg-secondary rounded-pill px-3"><i class="fas fa-archive me-1"></i>Archivé</span>
                                        <?php else: ?>
                                            <span class="badge bg-success rounded-pill px-3"><i class="fas fa-check-circle me-1"></i>Actif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group d-flex justify-content-center">
                                            <a href="<?php echo e(route('burgers.show', $burger)); ?>" class="btn btn-sm btn-info text-white rounded-start" data-bs-toggle="tooltip" title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('burgers.edit', $burger)); ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if(!$burger->is_archived): ?>
                                                <form action="<?php echo e(route('burgers.archive', $burger)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir archiver ce burger ?')" data-bs-toggle="tooltip" title="Archiver">
                                                        <i class="fas fa-archive"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="<?php echo e(route('burgers.destroy', $burger)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger rounded-end" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce burger ? Cette action est irréversible.')" data-bs-toggle="tooltip" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination améliorée -->
                    <div class="mt-4 d-flex justify-content-center">
                        <?php echo e($burgers->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-info border-start border-info border-4 shadow-sm">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h5 class="mb-1">Aucun résultat</h5>
                                <p class="mb-0">Aucun burger ne correspond à vos critères de recherche.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statistiques rapides (nouvelle section) -->
        <div class="row mt-4 g-3">
            <div class="col-md-4">
                <div class="card border-0 bg-primary bg-opacity-10 rounded-3 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary p-3 me-3">
                                <i class="fas fa-hamburger text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Nombre de burgers</h6>
                                <h4 class="fw-bold mb-0"><?php echo e($burgers->total()); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-success bg-opacity-10 rounded-3 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-success p-3 me-3">
                                <i class="fas fa-check-circle text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Burgers actifs</h6>
                                <h4 class="fw-bold mb-0"><?php echo e($burgers->where('is_archived', false)->count()); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-warning bg-opacity-10 rounded-3 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-warning p-3 me-3">
                                <i class="fas fa-exclamation-triangle text-white fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1">Faible stock</h6>
                                <h4 class="fw-bold mb-0"><?php echo e($burgers->where('stock', '<=', 10)->where('stock', '>', 0)->count()); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Initialiser les tooltips Bootstrap
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/burgers/index.blade.php ENDPATH**/ ?>