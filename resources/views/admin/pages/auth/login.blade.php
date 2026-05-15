<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>Admin Portal - Secure Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Enterprise Admin Portal" />
    <meta name="author" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ admin_assets() }}/assets/images/favicon.ico">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/config.js"></script>

    <!-- Custom Enterprise Login Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.18);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 30px 80px rgba(0, 0, 0, 0.2);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* Age Verification Modal Styles */
        .age-verification-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.5s ease-out;
        }

        .age-verification-modal {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modal-icon {
            width: 100px;
            height: 100px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: pulse 2s infinite;
        }

        .modal-icon i {
            font-size: 3rem;
            color: white;
        }

        .age-verification-modal h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.75rem;
        }

        .age-verification-modal > p {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .verification-form {
            margin-top: 2rem;
        }

        .verification-input-group {
            margin-bottom: 1.5rem;
        }

        .verification-input-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .verification-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1.5rem;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.5rem;
            transition: all 0.3s ease;
            background: white;
        }

        .verification-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-verify {
            width: 100%;
            padding: 1.125rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: var(--primary-gradient);
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            margin-bottom: 1rem;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        .verification-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #94a3b8;
            margin-top: 1rem;
        }

        .verification-note i {
            font-size: 1rem;
        }

        /* Shake Animation for Wrong Code */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }

        .shake {
            animation: shake 0.5s;
        }

        /* Error State */
        .verification-input.error {
            border-color: #ef4444;
            animation: shake 0.5s;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        .enterprise-login-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            position: relative;
            overflow: hidden;
        }

        /* Animated Background Elements */
        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 20s infinite ease-in-out;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: white;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: white;
            bottom: -50px;
            right: 10%;
            animation-delay: 5s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            background: white;
            top: 50%;
            right: -50px;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-30px) rotate(180deg);
            }
        }

        /* Main Container */
        .login-container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        /* Glass Card */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            max-width: 1200px;
            width: 100%;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }

        /* Left Side - Form */
        .form-section {
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-logo {
            margin-bottom: 2.5rem;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        .brand-logo img {
            max-width: 200px;
            height: auto;
        }

        .welcome-text {
            animation: fadeIn 0.8s ease-out 0.3s both;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .welcome-text p {
            font-size: 1rem;
            color: #64748b;
            margin-bottom: 2rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Styles */
        .enterprise-form {
            animation: fadeIn 0.8s ease-out 0.4s both;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control-wrapper {
            position: relative;
        }

        .form-control-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.125rem;
            z-index: 1;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            color: #94a3b8;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .password-toggle i {
            font-size: 1.25rem;
            position: static;
            transform: none;
        }

        .password-input {
            padding-right: 3.5rem !important;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 1.125rem;
            height: 1.125rem;
            cursor: pointer;
        }

        .form-check-label {
            font-size: 0.875rem;
            color: #64748b;
            cursor: pointer;
        }

        /* Button */
        .btn-enterprise {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: var(--primary-gradient);
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .btn-enterprise:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }

        .btn-enterprise:active {
            transform: translateY(0);
        }

        /* Right Side - Visual */
        .visual-section {
            background: var(--primary-gradient);
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .visual-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .visual-icon {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            backdrop-filter: blur(10px);
            animation: pulse 2s infinite;
        }

        .visual-icon i {
            font-size: 3.5rem;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 20px rgba(255, 255, 255, 0);
            }
        }

        .visual-content h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .visual-content p {
            font-size: 1.125rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 2rem 0 0;
            text-align: left;
        }

        .features-list li {
            padding: 0.75rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.95rem;
        }

        .features-list li i {
            font-size: 1.25rem;
            color: #4ade80;
        }

        /* Security Badge */
        .security-badge {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .security-badge i {
            color: #4ade80;
        }

        /* Responsive Design - All Devices */
        
        /* Large Desktop (1400px and above) */
        @media (min-width: 1400px) {
            .glass-card {
                max-width: 1400px;
            }

            .form-section {
                padding: 5rem 4rem;
            }

            .visual-section {
                padding: 5rem 4rem;
            }

            .welcome-text h1 {
                font-size: 3rem;
            }
        }

        /* Desktop (1200px - 1399px) */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .glass-card {
                max-width: 1200px;
            }

            .form-section {
                padding: 4rem 3rem;
            }

            .visual-section {
                padding: 4rem 3rem;
            }
        }

        /* Laptop/Tablet Landscape (992px - 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .glass-card {
                max-width: 1000px;
            }

            .form-section {
                padding: 3.5rem 2.5rem;
            }

            .visual-section {
                padding: 3.5rem 2.5rem;
            }

            .welcome-text h1 {
                font-size: 2.25rem;
            }

            .visual-content h2 {
                font-size: 1.75rem;
            }

            .visual-icon {
                width: 100px;
                height: 100px;
            }

            .visual-icon i {
                font-size: 3rem;
            }
        }

        /* Tablet Portrait (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .login-content {
                grid-template-columns: 1fr;
            }

            .visual-section {
                display: none;
            }

            .glass-card {
                max-width: 700px;
            }

            .form-section {
                padding: 3rem 3rem;
            }

            .welcome-text h1 {
                font-size: 2.25rem;
            }

            .welcome-text p {
                font-size: 1rem;
            }

            .brand-logo img {
                max-width: 180px;
            }

            .form-control {
                padding: 1rem 1rem 1rem 3rem;
                font-size: 1rem;
            }

            .btn-enterprise {
                padding: 1.125rem;
                font-size: 1rem;
            }
        }

        /* Mobile Landscape (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .login-content {
                grid-template-columns: 1fr;
            }

            .visual-section {
                display: none;
            }

            .login-container {
                padding: 1.5rem;
            }

            .glass-card {
                max-width: 540px;
                border-radius: 20px;
            }

            .form-section {
                padding: 2.5rem 2rem;
            }

            .brand-logo {
                margin-bottom: 2rem;
            }

            .brand-logo img {
                max-width: 160px;
            }

            .welcome-text h1 {
                font-size: 2rem;
            }

            .welcome-text p {
                font-size: 0.95rem;
                margin-bottom: 1.5rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            .form-control {
                padding: 0.875rem 0.875rem 0.875rem 2.75rem;
                font-size: 0.95rem;
            }

            .form-control-wrapper i {
                left: 0.875rem;
                font-size: 1rem;
            }

            .btn-enterprise {
                padding: 1rem;
                font-size: 0.95rem;
            }

            .floating-shape {
                opacity: 0.08;
            }
        }

        /* Mobile Portrait (480px - 575px) */
        @media (min-width: 480px) and (max-width: 575px) {
            .login-content {
                grid-template-columns: 1fr;
            }

            .visual-section {
                display: none;
            }

            .login-container {
                padding: 1rem;
            }

            .glass-card {
                border-radius: 18px;
            }

            .form-section {
                padding: 2rem 1.75rem;
            }

            .brand-logo {
                margin-bottom: 1.75rem;
            }

            .brand-logo img {
                max-width: 150px;
            }

            .welcome-text h1 {
                font-size: 1.875rem;
                margin-bottom: 0.5rem;
            }

            .welcome-text p {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }

            .form-label {
                font-size: 0.8125rem;
                margin-bottom: 0.4rem;
            }

            .form-group {
                margin-bottom: 1.125rem;
            }

            .form-control {
                padding: 0.875rem 0.875rem 0.875rem 2.75rem;
                font-size: 0.9375rem;
                border-radius: 10px;
            }

            .form-control-wrapper i {
                left: 0.875rem;
                font-size: 1rem;
            }

            .btn-enterprise {
                padding: 0.95rem;
                font-size: 0.9rem;
                border-radius: 10px;
            }

            .form-check-label {
                font-size: 0.8125rem;
            }

            .floating-shape {
                opacity: 0.06;
            }

            .shape-1 {
                width: 200px;
                height: 200px;
            }

            .shape-2 {
                width: 150px;
                height: 150px;
            }

            .shape-3 {
                width: 100px;
                height: 100px;
            }
        }

        /* Small Mobile (375px - 479px) */
        @media (min-width: 375px) and (max-width: 479px) {
            .login-content {
                grid-template-columns: 1fr;
            }

            .visual-section {
                display: none;
            }

            .enterprise-login-wrapper {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .login-container {
                padding: 0.75rem;
                min-height: 100vh;
                display: flex;
                align-items: stretch;
            }

            .glass-card {
                border-radius: 16px;
                width: 100%;
            }

            .login-content {
                min-height: auto;
            }

            .form-section {
                padding: 1.75rem 1.5rem;
            }

            .brand-logo {
                margin-bottom: 1.5rem;
                text-align: center;
            }

            .brand-logo img {
                max-width: 140px;
            }

            .welcome-text {
                text-align: center;
            }

            .welcome-text h1 {
                font-size: 1.75rem;
                margin-bottom: 0.5rem;
            }

            .welcome-text p {
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
                line-height: 1.5;
            }

            .form-label {
                font-size: 0.75rem;
                margin-bottom: 0.4rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-control {
                padding: 0.8125rem 0.8125rem 0.8125rem 2.5rem;
                font-size: 0.9rem;
                border-radius: 10px;
            }

            .form-control-wrapper i {
                left: 0.8125rem;
                font-size: 0.95rem;
            }

            .btn-enterprise {
                padding: 0.875rem;
                font-size: 0.875rem;
                border-radius: 10px;
                letter-spacing: 0.5px;
            }

            .form-check {
                gap: 0.4rem;
            }

            .form-check-input {
                width: 1rem;
                height: 1rem;
            }

            .form-check-label {
                font-size: 0.8125rem;
            }

            .floating-shape {
                opacity: 0.05;
            }

            .shape-1 {
                width: 180px;
                height: 180px;
            }

            .shape-2 {
                width: 120px;
                height: 120px;
            }

            .shape-3 {
                width: 80px;
                height: 80px;
            }
        }

        /* Extra Small Mobile (320px - 374px) */
        @media (max-width: 374px) {
            .login-content {
                grid-template-columns: 1fr;
            }

            .visual-section {
                display: none;
            }

            .enterprise-login-wrapper {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .login-container {
                padding: 0.5rem;
                min-height: 100vh;
                display: flex;
                align-items: stretch;
            }

            .glass-card {
                border-radius: 14px;
                width: 100%;
            }

            .login-content {
                min-height: auto;
            }

            .form-section {
                padding: 1.5rem 1.25rem;
            }

            .brand-logo {
                margin-bottom: 1.25rem;
                text-align: center;
            }

            .brand-logo img {
                max-width: 120px;
            }

            .welcome-text {
                text-align: center;
            }

            .welcome-text h1 {
                font-size: 1.5rem;
                margin-bottom: 0.4rem;
                line-height: 1.3;
            }

            .welcome-text p {
                font-size: 0.8125rem;
                margin-bottom: 1.25rem;
                line-height: 1.4;
            }

            .form-label {
                font-size: 0.7rem;
                margin-bottom: 0.35rem;
                letter-spacing: 0.3px;
            }

            .form-group {
                margin-bottom: 0.875rem;
            }

            .form-control {
                padding: 0.75rem 0.75rem 0.75rem 2.25rem;
                font-size: 0.875rem;
                border-radius: 8px;
            }

            .form-control-wrapper i {
                left: 0.75rem;
                font-size: 0.9rem;
            }

            .btn-enterprise {
                padding: 0.8125rem;
                font-size: 0.8125rem;
                border-radius: 8px;
                letter-spacing: 0.3px;
            }

            .form-check {
                gap: 0.35rem;
            }

            .form-check-input {
                width: 0.95rem;
                height: 0.95rem;
            }

            .form-check-label {
                font-size: 0.75rem;
            }

            .floating-shape {
                opacity: 0.04;
            }

            .shape-1 {
                width: 150px;
                height: 150px;
            }

            .shape-2 {
                width: 100px;
                height: 100px;
            }

            .shape-3 {
                width: 70px;
                height: 70px;
            }
        }

        /* Landscape Orientation Fix for Mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            .login-container {
                padding: 1rem;
                align-items: flex-start;
            }

            .glass-card {
                margin: 1rem 0;
            }

            .form-section {
                padding: 1.5rem 2rem;
            }

            .brand-logo {
                margin-bottom: 1rem;
            }

            .brand-logo img {
                max-width: 120px;
            }

            .welcome-text h1 {
                font-size: 1.5rem;
                margin-bottom: 0.25rem;
            }

            .welcome-text p {
                font-size: 0.8125rem;
                margin-bottom: 1rem;
            }

            .form-group {
                margin-bottom: 0.75rem;
            }

            .form-control {
                padding: 0.625rem 0.625rem 0.625rem 2.25rem;
            }

            .btn-enterprise {
                padding: 0.75rem;
            }

            .floating-shape {
                display: none;
            }
        }

        /* High DPI Screens */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .glass-card {
                border-width: 0.5px;
            }

            .form-control {
                border-width: 1.5px;
            }
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .form-control {
                font-size: 16px !important; /* Prevents zoom on iOS */
            }

            .btn-enterprise {
                min-height: 48px; /* Better touch target */
            }

            .form-check-input {
                min-width: 20px;
                min-height: 20px;
            }

            .form-check-label {
                padding: 0.25rem 0;
            }
        }

        /* Loading State */
        .btn-enterprise.loading {
            position: relative;
            color: transparent;
        }

        .btn-enterprise.loading::after {
            content: "";
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Age Verification Modal -->
    <div class="age-verification-overlay" id="ageVerificationModal" style="display: {{ session('admin_verified') ? 'none' : 'flex' }};">
        <div class="age-verification-modal">
            <div class="modal-icon">
                <i class="ti ti-shield-lock"></i>
            </div>
            <h2>Access Verification Required</h2>
            <p>This is a restricted admin area. Please verify your authorization to continue.</p>
            
            <form id="ageVerificationForm" class="verification-form">
                @csrf
                <div class="verification-input-group">
                    <label for="verificationCode">Enter Verification Code</label>
                    <input 
                        type="password" 
                        id="verificationCode" 
                        name="verification_code"
                        class="verification-input" 
                        placeholder="Enter code"
                        maxlength="2"
                        autocomplete="off"
                        required
                    >
                </div>
                <button type="submit" class="btn-verify">Verify Access</button>
                <p class="verification-note">
                    <i class="ti ti-info-circle"></i>
                    Authorized personnel only
                </p>
            </form>
        </div>
    </div>

    <!-- Enterprise Login Wrapper -->
    <div class="enterprise-login-wrapper" id="loginWrapper" style="display: {{ session('admin_verified') ? 'block' : 'none' }};">

        <!-- Animated Background -->
        <div class="bg-animation">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
        </div>

        <!-- Login Container -->
        <div class="login-container">
            <div class="glass-card">
                <div class="login-content">
                    <!-- Left Side - Form Section -->
                    <div class="form-section">
                        <!-- Brand Logo -->
                        <div class="brand-logo">
                            <img src='{{ path() }}/vivaceLogo (1).png' alt="Company Logo" />
                        </div>

                        <!-- Welcome Text -->
                        <div class="welcome-text">
                            <h1>Welcome Back</h1>
                            <p>Sign in to access your admin dashboard and manage your platform</p>
                        </div>

                        <!-- Login Form -->
                        <form id="loginForm" class="enterprise-form">
                            <!-- Email Field -->
                            <div class="form-group">
                                <label class="form-label" for="example-email">Email Address</label>
                                <div class="form-control-wrapper">
                                    <i class="ti ti-mail"></i>
                                    <input 
                                        type="email" 
                                        id="example-email" 
                                        name="email" 
                                        class="form-control"
                                        placeholder="admin@company.com" 
                                        required 
                                        value="{{ Cookie::get('email', '') }}"
                                        autocomplete="email"
                                    >
                                </div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label class="form-label" for="example-password">Password</label>
                                <div class="form-control-wrapper password-wrapper">
                                    <i class="ti ti-lock"></i>
                                    <input 
                                        type="password" 
                                        id="example-password" 
                                        name="password" 
                                        class="form-control password-input"
                                        placeholder="Enter your password" 
                                        required 
                                        value="{{ Cookie::get('password', '') }}"
                                        autocomplete="current-password"
                                    >
                                    <button type="button" class="password-toggle" id="togglePassword">
                                        <i class="ti ti-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input 
                                        type="checkbox" 
                                        class="form-check-input" 
                                        id="checkbox-signin" 
                                        name="remember" 
                                        {{ Cookie::get('email') ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="checkbox-signin">
                                        Keep me signed in
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button class="btn-enterprise" type="submit" id="loginBtn">
                                    Sign In Securely
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Right Side - Visual Section -->
                    <div class="visual-section">
                        <div class="visual-content">
                            <!-- Icon -->
                            <div class="visual-icon">
                                <i class="ti ti-shopping-bag"></i>
                            </div>

                            <!-- Heading -->
                            <h2>Vivace Admin Portal</h2>
                            <p>Manage your fashion e-commerce platform with powerful tools and insights</p>

                            <!-- Features List -->
                            <ul class="features-list">
                                <li>
                                    <i class="ti ti-circle-check"></i>
                                    <span>Product & Inventory Management</span>
                                </li>
                                <li>
                                    <i class="ti ti-circle-check"></i>
                                    <span>Order & Customer Analytics</span>
                                </li>
                                <li>
                                    <i class="ti ti-circle-check"></i>
                                    <span>Brand & Collection Control</span>
                                </li>
                                <li>
                                    <i class="ti ti-circle-check"></i>
                                    <span>Real-time Sales Tracking</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Security Badge -->
                        <div class="security-badge">
                            <i class="ti ti-lock"></i>
                            <span>Secure Admin Access</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/vendor.js"></script>

    <!-- App Javascript (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/app.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Age Verification Script -->
    <script>
        $(document).ready(function() {
            const VERIFICATION_CODE = '18';
            const MAX_ATTEMPTS = 3;
            let attempts = 0;

            // Age Verification Form Handler
            $('#ageVerificationForm').on('submit', function(e) {
                e.preventDefault();
                
                const enteredCode = $('#verificationCode').val().trim();
                const input = $('#verificationCode');

                if (enteredCode === VERIFICATION_CODE) {
                    // Correct code - Save to server session
                    $.ajax({
                        url: '{{ route('admin.login.process') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            verification_only: true,
                            code: enteredCode
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Access Granted',
                                text: 'Welcome to the admin portal',
                                confirmButtonColor: '#667eea',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                $('#ageVerificationModal').fadeOut(300);
                                $('#loginWrapper').fadeIn(300);
                            });
                        },
                        error: function() {
                            // If AJAX fails, still allow access (fallback)
                            $('#ageVerificationModal').fadeOut(300);
                            $('#loginWrapper').fadeIn(300);
                        }
                    });
                } else {
                    // Wrong code
                    attempts++;
                    input.addClass('error');
                    
                    setTimeout(() => {
                        input.removeClass('error');
                    }, 500);

                    if (attempts >= MAX_ATTEMPTS) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Access Denied',
                            text: 'Too many failed attempts. Redirecting...',
                            confirmButtonColor: '#667eea',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(() => {
                            window.location.href = '/';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Code',
                            text: `Incorrect verification code. ${MAX_ATTEMPTS - attempts} attempt(s) remaining.`,
                            confirmButtonColor: '#667eea'
                        });
                    }
                    
                    input.val('');
                }
            });

            // Only allow numbers
            $('#verificationCode').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            // Auto-focus on verification input if modal is visible
            if ($('#ageVerificationModal').is(':visible')) {
                $('#verificationCode').focus();
            }
        });
    </script>
    
    <!-- Login Form Handler -->
    <script>
        $(document).ready(function () {
            const loginForm = $('#loginForm');
            const loginBtn = $('#loginBtn');
            const emailInput = $('#example-email');
            const passwordInput = $('#example-password');
            const togglePassword = $('#togglePassword');
            const eyeIcon = $('#eyeIcon');

            // Password Toggle Functionality
            togglePassword.on('click', function() {
                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);
                
                // Toggle eye icon
                if (type === 'text') {
                    eyeIcon.removeClass('ti-eye').addClass('ti-eye-off');
                } else {
                    eyeIcon.removeClass('ti-eye-off').addClass('ti-eye');
                }
            });

            // Form validation
            function validateForm() {
                const email = emailInput.val().trim();
                const password = passwordInput.val().trim();
                
                if (!email || !password) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Information',
                        text: 'Please fill in all required fields',
                        confirmButtonColor: '#667eea'
                    });
                    return false;
                }

                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Email',
                        text: 'Please enter a valid email address',
                        confirmButtonColor: '#667eea'
                    });
                    return false;
                }

                return true;
            }

            // Form submit handler
            loginForm.on('submit', function (e) {
                e.preventDefault();

                if (!validateForm()) {
                    return;
                }

                // Add loading state
                loginBtn.addClass('loading').prop('disabled', true);

                $.ajax({
                    url: '{{ route('admin.login.process') }}',
                    type: 'POST',
                    data: {
                        email: emailInput.val(),
                        password: passwordInput.val(),
                        remember: $('#checkbox-signin').is(':checked'),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome Back!',
                                text: response.message || 'Login successful. Redirecting to dashboard...',
                                confirmButtonColor: '#667eea',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.href = '{{ route('admin.dashboard') }}';
                            });
                        } else {
                            loginBtn.removeClass('loading').prop('disabled', false);
                            Swal.fire({
                                icon: 'error',
                                title: 'Authentication Failed',
                                text: response.message || 'Invalid credentials. Please try again.',
                                confirmButtonColor: '#667eea'
                            });
                        }
                    },
                    error: function (xhr) {
                        loginBtn.removeClass('loading').prop('disabled', false);
                        
                        let errorMessage = 'An unexpected error occurred. Please try again.';
                        
                        if (xhr.status === 401) {
                            errorMessage = 'Invalid email or password.';
                        } else if (xhr.status === 422) {
                            errorMessage = 'Please check your input and try again.';
                        } else if (xhr.status === 429) {
                            errorMessage = 'Too many login attempts. Please try again later.';
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Login Error',
                            text: errorMessage,
                            confirmButtonColor: '#667eea'
                        });
                    }
                });
            });

            // Enter key support
            emailInput.add(passwordInput).on('keypress', function(e) {
                if (e.which === 13) {
                    loginForm.submit();
                }
            });

            // Auto-focus on email field
            emailInput.focus();
        });
    </script>
</body>

</html>
