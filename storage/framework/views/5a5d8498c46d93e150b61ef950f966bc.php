

<?php $__env->startSection('title', 'Statistiques'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Tableau de bord statistiques</h1>
            <span class="text-muted"><?php echo e(date('d/m/Y')); ?></span>
        </div>

        <!-- Info Cards -->
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Commandes en cours</h6>
                                <h2 class="mb-0 text-primary"><?php echo e($todayOrders); ?></h2>
                                <p class="text-muted small mb-0">Aujourd'hui</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock text-primary fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Commandes validées</h6>
                                <h2 class="mb-0 text-success"><?php echo e($validatedOrders); ?></h2>
                                <p class="text-muted small mb-0">Aujourd'hui</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle text-success fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Recettes</h6>
                                <h2 class="mb-0 text-info"><?php echo e(number_format($dailyRevenue, 0, ',', ' ')); ?> <small>CFA</small></h2>
                                <p class="text-muted small mb-0">Aujourd'hui</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave text-info fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Évolution des commandes</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Ventes par produit</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="productChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        // Configuration des graphiques
        Chart.defaults.font.family = "'Poppins', 'Helvetica', 'Arial', sans-serif";
        Chart.defaults.color = '#6c757d';

        // Graphique des commandes par mois
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Nombre de commandes',
                    data: <?php echo json_encode($orderCounts); ?>,
                    backgroundColor: 'rgba(84, 140, 255, 0.5)',
                    borderColor: 'rgba(84, 140, 255, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end'
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        usePointStyle: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            borderDash: [2, 4]
                        }
                    }
                }
            }
        });

        // Graphique des produits vendus par mois
        const productCtx = document.getElementById('productChart').getContext('2d');

        // Configuration des données
        const datasets = [];
        const burgerNames = Object.keys(<?php echo json_encode($burgerData); ?>);
        const colors = [
            'rgba(59, 130, 246, 0.5)', 'rgba(16, 185, 129, 0.5)',
            'rgba(245, 158, 11, 0.5)', 'rgba(239, 68, 68, 0.5)',
            'rgba(139, 92, 246, 0.5)', 'rgba(236, 72, 153, 0.5)'
        ];

        burgerNames.forEach((name, index) => {
            const data = [];
            <?php echo json_encode($months); ?>.forEach(month => {
                const burgerData = <?php echo json_encode($burgerData); ?>[name];
                data.push(burgerData && burgerData[month] ? burgerData[month] : 0);
            });

            datasets.push({
                label: name,
                data: data,
                backgroundColor: colors[index % colors.length],
                borderColor: colors[index % colors.length].replace('0.5', '1'),
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 6
            });
        });

        new Chart(productCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end'
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        usePointStyle: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            borderDash: [2, 4]
                        }
                    }
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/statistics/index.blade.php ENDPATH**/ ?>