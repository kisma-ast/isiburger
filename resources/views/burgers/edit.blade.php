<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le burger - {{ $burger->name }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .burger-form {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #ff7700, #ff3300);
            color: white;
            padding: 30px;
            position: relative;
        }

        .burger-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2.5rem;
            opacity: 0.8;
        }

        .form-content {
            padding: 30px;
        }

        .custom-input {
            border: none;
            border-bottom: 2px solid #ddd;
            border-radius: 0;
            padding: 10px 5px;
            transition: all 0.3s;
        }

        .custom-input:focus {
            border-color: #ff5500;
            box-shadow: none;
        }

        .custom-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .required::after {
            content: "*";
            color: #ff3300;
            margin-left: 5px;
        }

        .preview-container {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
            position: relative;
            transition: all 0.3s;
        }

        .preview-container:hover {
            border-color: #ff5500;
        }

        .image-preview {
            max-height: 200px;
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .btn-burger-primary {
            background: linear-gradient(135deg, #ff7700, #ff3300);
            border: none;
            border-radius: 30px;
            padding: 10px 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-burger-primary:hover {
            background: linear-gradient(135deg, #ff3300, #ff7700);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 83, 0, 0.3);
        }

        .btn-burger-secondary {
            background-color: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 30px;
            padding: 10px 25px;
            color: #555;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-burger-secondary:hover {
            background-color: #eee;
            transform: translateY(-2px);
        }

        .stock-controls {
            display: flex;
            align-items: center;
        }

        .stock-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid #ddd;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.2s;
        }

        .stock-btn:hover {
            background-color: #f8f9fa;
        }

        .stock-input {
            width: 80px;
            text-align: center;
            margin: 0 10px;
        }

        .price-input-group {
            position: relative;
        }

        .price-input-group::after {
            content: "CFA";
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="burger-form">
                <div class="form-header">
                    <i class="fas fa-hamburger burger-icon"></i>
                    <h3 class="mb-0">Modifier le burger</h3>
                    <p class="mb-0 mt-2 opacity-75">{{ $burger->name }}</p>
                </div>

                <div class="form-content">
                    <form action="{{ route('burgers.update', $burger) }}" method="POST" enctype="multipart/form-data" id="burgerForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="custom-label required">Nom du burger</label>
                            <input type="text" class="form-control custom-input @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $burger->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="price" class="custom-label required">Prix</label>
                            <div class="price-input-group">
                                <input type="number" step="50" min="0" class="form-control custom-input @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price', $burger->price) }}" required>
                            </div>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="stock" class="custom-label required">Stock</label>
                            <div class="stock-controls">
                                <button type="button" class="stock-btn decrease-stock">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" min="0" class="form-control custom-input stock-input @error('stock') is-invalid @enderror"
                                       id="stock" name="stock" value="{{ old('stock', $burger->stock) }}" required>
                                <button type="button" class="stock-btn increase-stock">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="custom-label">Description</label>
                            <textarea class="form-control custom-input @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $burger->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="image" class="custom-label">Image</label>
                            <div class="preview-container" id="imagePreviewContainer">
                                @if($burger->image)
                                    <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->name }}"
                                         class="image-preview" id="imagePreview">
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">Cliquez ou glissez une image ici</p>
                                    </div>
                                @endif
                            </div>
                            <input type="file" class="form-control custom-input @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*" style="display: none;">
                            <div class="d-flex justify-content-center">
                                <button type="button" id="browseButton" class="btn btn-sm btn-burger-secondary">
                                    <i class="fas fa-folder-open me-2"></i>Parcourir
                                </button>
                            </div>
                            <div class="form-text text-center mt-2">
                                <small>Format recommandé : JPG, PNG. Taille max : 2MB</small>
                            </div>
                            @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-5">
                            <a href="{{ route('burgers.index') }}" class="btn btn-burger-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-burger-primary">
                                <i class="fas fa-save me-2"></i>Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Image preview
        $('#imagePreviewContainer').click(function() {
            $('#image').click();
        });

        $('#browseButton').click(function() {
            $('#image').click();
        });

        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if ($('#imagePreview').length) {
                        $('#imagePreview').attr('src', e.target.result);
                    } else {
                        $('#imagePreviewContainer').html('<img src="' + e.target.result + '" alt="Preview" class="image-preview" id="imagePreview">');
                    }
                }
                reader.readAsDataURL(file);
            }
        });

        // Stock controls
        $('.decrease-stock').click(function() {
            let currentValue = parseInt($('#stock').val());
            if (currentValue > 0) {
                $('#stock').val(currentValue - 1);
            }
        });

        $('.increase-stock').click(function() {
            let currentValue = parseInt($('#stock').val());
            $('#stock').val(currentValue + 1);
        });

        // Form validation
        $('#burgerForm').submit(function(e) {
            let valid = true;

            // Name validation
            if ($('#name').val().trim() === '') {
                $('#name').addClass('is-invalid');
                valid = false;
            } else {
                $('#name').removeClass('is-invalid');
            }

            // Price validation
            if ($('#price').val() <= 0) {
                $('#price').addClass('is-invalid');
                valid = false;
            } else {
                $('#price').removeClass('is-invalid');
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    });
</script>
</body>
</html>
