<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #003897;
            --primary-dark: #002b7a;
            --primary-light: #4d6fb8;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-radius: 12px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #003897 0%, #0066cc 100%);
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            line-height: 1.6;
        }

        .auth-container {
            width: 100%;
            max-width: 1200px;
            min-height: 90vh;
            display: flex;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-form {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            position: relative;
        }

        .auth-image {
            flex: 1;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 40px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .auth-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23002b7a' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.1;
        }

        .auth-image img {
            max-width: 220px;
            height: auto;
            margin-bottom: 30px;
            opacity: 0.95;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
            z-index: 1;
            position: relative;
            transition: var(--transition);
        }

        .auth-image:hover img {
            transform: translateY(-5px);
        }

        .auth-image p {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            line-height: 1.6;
            margin: 0;
            font-weight: 500;
            z-index: 1;
            position: relative;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .form-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            border-radius: 3px;
        }

        .form-subtitle {
            color: var(--secondary-color);
            font-size: 1rem;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--dark-color);
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .input-group {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .input-group:focus-within {
            box-shadow: 0 5px 15px rgba(0, 56, 151, 0.1);
            transform: translateY(-2px);
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
            background: #fff;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 56, 151, 0.15);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-right: none;
            border-radius: var(--border-radius) 0 0 var(--border-radius);
            padding: 15px 15px;
            color: var(--secondary-color);
            transition: var(--transition);
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
        }

        .btn-outline-secondary {
            border: 2px solid #e9ecef;
            border-left: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            padding: 15px 15px;
            background: #f8f9fa;
            color: var(--secondary-color);
            transition: var(--transition);
        }

        .btn-outline-secondary:hover {
            background: #e9ecef;
            color: var(--dark-color);
        }

        .btn-primary-custom {
            background: linear-gradient(to right, var(--primary-color), var(--primary-light));
            border: none;
            border-radius: var(--border-radius);
            padding: 15px 20px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 56, 151, 0.3);
        }

        .btn-primary-custom:hover::before {
            left: 100%;
        }

        .btn-google {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            padding: 15px 20px;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-google:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }

        .divider span {
            padding: 0 15px;
            color: var(--secondary-color);
            font-size: 0.85rem;
        }

        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .auth-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .auth-link:hover {
            color: var(--primary-dark);
            text-decoration: none;
        }

        .auth-link:hover::after {
            width: 100%;
        }

        .alert {
            border-radius: var(--border-radius);
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            font-weight: 500;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .invalid-feedback {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: var(--danger-color);
            font-weight: 500;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
                max-width: 600px;
            }

            .auth-form {
                padding: 40px 30px;
                order: 2;
            }

            .auth-image {
                order: 1;
                padding: 30px;
            }

            .auth-image img {
                max-width: 150px;
                margin-bottom: 20px;
            }

            .auth-image p {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .auth-form {
                padding: 30px 20px;
            }

            .form-title {
                font-size: 1.75rem;
            }
        }

        /* Loading animation for form submission */
        .btn-loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from { transform: rotate(0turn); }
            to { transform: rotate(1turn); }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Toggle password visibility
            document.querySelectorAll(".togglePassword").forEach(button => {
                button.addEventListener("click", function () {
                    const input = this.closest(".input-group").querySelector("input[type='password'], input[type='text']");
                    const icon = this.querySelector("i");

                    if (input.type === "password") {
                        input.type = "text";
                        icon.classList.replace("fa-eye", "fa-eye-slash");
                    } else {
                        input.type = "password";
                        icon.classList.replace("fa-eye-slash", "fa-eye");
                    }
                });
            });

            // Form validation and submission feedback
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');

                    // Add loading state to button
                    if (submitButton) {
                        submitButton.classList.add('btn-loading');
                        submitButton.disabled = true;
                    }

                    // Re-enable button after 3 seconds (in case of error)
                    setTimeout(() => {
                        if (submitButton) {
                            submitButton.classList.remove('btn-loading');
                            submitButton.disabled = false;
                        }
                    }, 3000);
                });
            });

            // Real-time validation for better UX
            const emailInputs = document.querySelectorAll('input[type="email"]');
            emailInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value.trim() !== '') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(this.value.trim())) {
                            this.classList.add('is-invalid');
                            let feedback = this.parentNode.querySelector('.invalid-feedback');
                            if (!feedback) {
                                feedback = document.createElement('div');
                                feedback.className = 'invalid-feedback';
                                this.parentNode.appendChild(feedback);
                            }
                            feedback.textContent = 'Format email tidak valid';
                        } else {
                            this.classList.remove('is-invalid');
                            const feedback = this.parentNode.querySelector('.invalid-feedback');
                            if (feedback) feedback.remove();
                        }
                    }
                });
            });

            // Password strength indicator for register form
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const value = this.value;
                    let strength = 0;

                    if (value.length >= 8) strength++;
                    if (/[A-Z]/.test(value)) strength++;
                    if (/[0-9]/.test(value)) strength++;
                    if (/[^A-Za-z0-9]/.test(value)) strength++;

                    // Visual feedback could be added here
                });
            }
        });
    </script>
</body>
</html>
