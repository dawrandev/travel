<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отзыв о туре - Toqtarbay Tours</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 600px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 30px 20px;
            border: none;
        }
        .card-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control, .form-control:focus {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px 12px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        .stars {
            font-size: 32px;
            color: #ffc107;
            cursor: pointer;
        }
        .star {
            transition: all 0.2s;
            margin-right: 5px;
        }
        .star:hover {
            transform: scale(1.2);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .alert {
            border-radius: 5px;
            border: none;
        }
        .spinner-border {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
        .rating-input {
            display: none;
        }
        .form-text {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Оставить отзыв о туре</h2>
                <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Поделитесь своим мнением о вашем путешествии</p>
            </div>
            <div class="card-body" style="padding: 30px;">
                <!-- Success Alert -->
                <div id="successAlert" class="alert alert-success alert-dismissible fade" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Спасибо!</strong> Ваш отзыв успешно отправлен. Он будет опубликован после модерации.
                </div>

                <!-- Error Alert -->
                <div id="errorAlert" class="alert alert-danger alert-dismissible fade" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Ошибка!</strong> <span id="errorMessage"></span>
                </div>

                <form id="reviewForm">
                    @csrf

                    <!-- Tour Selection -->
                    <div class="form-group">
                        <label for="tour_id">Выберите тур <span style="color: red;">*</span></label>
                        <select class="form-control" id="tour_id" name="tour_id" required>
                            <option value="">-- Выберите тур --</option>
                            @foreach($tours as $tour)
                            <option value="{{ $tour->id }}">{{ $tour->translations->first()->title ?? 'Без названия' }}</option>
                            @endforeach
                        </select>
                        <small class="form-text">Выберите тур, по которому вы хотите оставить отзыв</small>
                    </div>

                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Ваше имя <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя" required maxlength="255">
                        <small class="form-text">Минимум 2 символа</small>
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">Ваш email <span style="color: red;">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" required maxlength="255">
                        <small class="form-text">Мы не будем делиться вашим email</small>
                    </div>

                    <!-- Rating Field -->
                    <div class="form-group">
                        <label>Ваша оценка <span style="color: red;">*</span></label>
                        <div class="stars" id="ratingStars">
                            <span class="star" data-value="1" style="color: #ccc;">★</span>
                            <span class="star" data-value="2" style="color: #ccc;">★</span>
                            <span class="star" data-value="3" style="color: #ccc;">★</span>
                            <span class="star" data-value="4" style="color: #ccc;">★</span>
                            <span class="star" data-value="5" style="color: #ccc;">★</span>
                        </div>
                        <input type="hidden" id="rating" name="rating" value="0" required>
                        <small class="form-text d-block mt-2">Нажмите на звезду, чтобы оценить (от 1 до 5 звезд)</small>
                    </div>

                    <!-- Comment Field -->
                    <div class="form-group">
                        <label for="comment">Ваш отзыв <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="comment" name="comment" placeholder="Расскажите о вашем опыте путешествия..." required maxlength="1000"></textarea>
                        <small class="form-text">Максимум 1000 символов (<span id="charCount">0</span>/1000)</small>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit btn-block" id="submitBtn">
                        <span id="submitText">Отправить отзыв</span>
                    </button>
                </form>

                <div class="back-link">
                    <a href="javascript:history.back()">← Вернуться назад</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Rating stars interaction
        const stars = document.querySelectorAll('#ratingStars .star');
        const ratingInput = document.getElementById('rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;

                // Update stars color
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ccc';
                    }
                });
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const value = this.getAttribute('data-value');
                stars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.style.opacity = '0.7';
                    } else {
                        s.style.opacity = '1';
                    }
                });
            });
        });

        // Reset hover
        document.getElementById('ratingStars').addEventListener('mouseleave', function() {
            stars.forEach(s => {
                s.style.opacity = '1';
            });
        });

        // Character count
        document.getElementById('comment').addEventListener('input', function() {
            document.getElementById('charCount').textContent = this.value.length;
        });

        // Form submission
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');

            // Disable button and show loading
            submitBtn.disabled = true;
            submitText.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span>Отправка...';

            // Prepare data
            const formData = {
                tour_id: document.getElementById('tour_id').value,
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                rating: document.getElementById('rating').value,
                comment: document.getElementById('comment').value
            };

            // Validate rating
            if (!formData.rating || formData.rating < 1) {
                errorMessage.textContent = 'Пожалуйста, выберите оценку';
                errorAlert.style.display = 'block';
                submitBtn.disabled = false;
                submitText.innerHTML = 'Отправить отзыв';
                return;
            }

            // Send AJAX request
            $.ajax({
                url: '/api/reviews',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Accept-Language': 'ru'
                },
                data: JSON.stringify(formData),
                success: function(response) {
                    console.log('Success:', response);
                    successAlert.style.display = 'block';
                    document.getElementById('reviewForm').reset();
                    ratingInput.value = 0;
                    stars.forEach(s => s.style.color = '#ccc');
                    document.getElementById('charCount').textContent = '0';

                    // Hide alerts after 5 seconds
                    setTimeout(() => {
                        successAlert.style.display = 'none';
                    }, 5000);
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    let message = 'Ошибка при отправке отзыва. Попробуйте снова.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        const firstError = Object.values(errors)[0];
                        if (Array.isArray(firstError)) {
                            message = firstError[0];
                        } else {
                            message = firstError;
                        }
                    }

                    errorMessage.textContent = message;
                    errorAlert.style.display = 'block';
                },
                complete: function() {
                    submitBtn.disabled = false;
                    submitText.innerHTML = 'Отправить отзыв';
                }
            });
        });
    </script>
</body>
</html>
