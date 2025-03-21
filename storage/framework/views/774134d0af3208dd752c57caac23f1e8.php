

<?php $__env->startSection('title', 'Créer une Nouvelle Saveur'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Heading with icon -->
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-circle bg-warning p-3 me-3">
                        <i class="fas fa-plus text-white fa-lg"></i>
                    </div>
                    <div>
                        <h2 class="mb-0">Créer un nouveau burger</h2>
                        <p class="text-muted mb-0">Complétez le formulaire ci-dessous pour ajouter une nouvelle création à notre carte</p>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left side - Visual preview -->
                        <div class="col-md-4 bg-dark d-none d-md-block">
                            <div class="h-100 p-4 d-flex flex-column justify-content-between">
                                <div class="text-center mb-4">
                                    <div class="burger-preview-container mb-3">
                                        <div id="imagePreview" class="burger-preview-image bg-black rounded-4 mb-3 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-hamburger fa-5x text-warning"></i>
                                        </div>
                                    </div>
                                    <h5 class="text-white" id="previewName">Nouveau Burger</h5>
                                    <p class="badge bg-warning px-3 py-2 rounded-pill" id="previewPrice">0 CFA</p>
                                </div>

                                <div class="bg-dark-subtle p-3 rounded-3 mb-3">
                                    <p class="text-white-50 small mb-0" id="previewDescription">Ajoutez une description pour faire saliver vos clients...</p>
                                </div>

                                <div class="text-center text-white-50 small">
                                    <p class="mb-1"><i class="fas fa-info-circle me-1"></i> Cette prévisualisation se met à jour automatiquement</p>
                                    <div><span id="previewStock">0</span> unités en stock</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right side - Form -->
                        <div class="col-md-8">
                            <div class="card-body p-4 p-lg-5">
                                <form action="<?php echo e(route('burgers.store')); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>

                                    <div class="row g-4">
                                        <!-- Name Field -->
                                        <div class="col-md-12">
                                            <div class="form-floating mb-1">
                                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="name" name="name" value="<?php echo e(old('name')); ?>"
                                                       placeholder="Nom du burger" required>
                                                <label for="name">Nom du burger <span class="text-danger">*</span></label>
                                                <?php $__errorArgs = ['name'];
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
                                        </div>

                                        <!-- Price & Stock Fields -->
                                        <div class="col-md-6">
                                            <div class="form-floating mb-1">
                                                <input type="number" step="0.01" min="0"
                                                       class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="price" name="price" value="<?php echo e(old('price')); ?>"
                                                       placeholder="Prix" required>
                                                <label for="price">Prix (CFA) <span class="text-danger">*</span></label>
                                                <?php $__errorArgs = ['price'];
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
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-floating mb-1">
                                                <input type="number" min="0"
                                                       class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="stock" name="stock" value="<?php echo e(old('stock', 0)); ?>"
                                                       placeholder="Stock" required>
                                                <label for="stock">Stock <span class="text-danger">*</span></label>
                                                <?php $__errorArgs = ['stock'];
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
                                        </div>

                                        <!-- Description Field -->
                                        <div class="col-md-12">
                                            <div class="form-floating mb-1">
                                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                      id="description" name="description" rows="3"
                                                      style="height: 120px" placeholder="Description"><?php echo e(old('description')); ?></textarea>
                                                <label for="description">Description</label>
                                                <?php $__errorArgs = ['description'];
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
                                        </div>

                                        <!-- Image Field -->
                                        <div class="col-md-12">
                                            <label for="image" class="form-label">Image du burger</label>
                                            <div class="input-group mb-1">
                                                <span class="input-group-text"><i class="fas fa-image"></i></span>
                                                <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                       id="image" name="image" accept="image/*">
                                                <?php $__errorArgs = ['image'];
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
                                            <div class="form-text mb-3">Formats acceptés : JPG, PNG. Taille max : 2MB</div>
                                        </div>

                                        <!-- Category Field (New) -->
                                        <div class="col-md-12">
                                            <label class="form-label">Catégorie</label>
                                            <div class="d-flex flex-wrap gap-3 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="categoryClassic" value="classic" checked>
                                                    <label class="form-check-label" for="categoryClassic">
                                                        Classique
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="categorySignature" value="signature">
                                                    <label class="form-check-label" for="categorySignature">
                                                        Signature
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="category" id="categoryVeggie" value="veggie">
                                                    <label class="form-check-label" for="categoryVeggie">
                                                        Végétarien
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-md-12 mt-4">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                                <a href="<?php echo e(route('burgers.index')); ?>" class="btn btn-outline-secondary px-4">
                                                    <i class="fas fa-arrow-left me-2"></i> Retour
                                                </a>
                                                <button type="submit" class="btn btn-warning px-5">
                                                    <i class="fas fa-utensils me-2"></i> Créer le burger
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Section -->
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-body p-4">
                        <h5><i class="fas fa-lightbulb text-warning me-2"></i> Astuces pour un burger réussi</h5>
                        <div class="row g-3 mt-2">
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="badge bg-warning-subtle text-warning rounded-circle p-2 me-2">1</div>
                                    <p class="small mb-0">Choisissez un nom accrocheur qui évoque les saveurs principales</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="badge bg-warning-subtle text-warning rounded-circle p-2 me-2">2</div>
                                    <p class="small mb-0">Rédigez une description détaillée qui met l'eau à la bouche</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex">
                                    <div class="badge bg-warning-subtle text-warning rounded-circle p-2 me-2">3</div>
                                    <p class="small mb-0">Utilisez une photo de qualité professionnelle prise en lumière naturelle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-dark-subtle {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.2);
        }

        .burger-preview-container {
            position: relative;
        }

        .burger-preview-image {
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #ffc107;
        }

        .rounded-4 {
            border-radius: 0.75rem !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Live preview functionality
            const nameInput = document.getElementById('name');
            const priceInput = document.getElementById('price');
            const stockInput = document.getElementById('stock');
            const descriptionInput = document.getElementById('description');
            const imageInput = document.getElementById('image');

            const previewName = document.getElementById('previewName');
            const previewPrice = document.getElementById('previewPrice');
            const previewStock = document.getElementById('previewStock');
            const previewDescription = document.getElementById('previewDescription');
            const imagePreview = document.getElementById('imagePreview');

            // Update name preview
            nameInput.addEventListener('input', function() {
                previewName.textContent = this.value || 'Nouveau Burger';
            });

            // Update price preview
            priceInput.addEventListener('input', function() {
                previewPrice.textContent = this.value ? (this.value + ' CFA') : '0 CFA';
            });

            // Update stock preview
            stockInput.addEventListener('input', function() {
                previewStock.textContent = this.value || '0';
            });

            // Update description preview
            descriptionInput.addEventListener('input', function() {
                previewDescription.textContent = this.value || 'Ajoutez une description pour faire saliver vos clients...';
            });

            // Image preview
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.innerHTML = `<img src="${e.target.result}" class="img-fluid rounded-4" style="height: 180px; object-fit: cover;">`;
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\isi-burger\resources\views/burgers/create.blade.php ENDPATH**/ ?>