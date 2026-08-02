<?php
declare(strict_types=1);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<main class="auth-page">

    <section class="auth-card">

        <h1>Welcome Back</h1>

        <p class="auth-subtitle">
            Sign in to continue to Lights Out.
        </p>

        <?php if (isset($_SESSION['error'])): ?>

            <div class="alert error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>

            <div class="alert success">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>

        <form action="../actions/login_action.php"
              method="POST">

            <div class="form-group">

                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required>

            </div>

            <div class="form-group">

                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required>

            </div>

            <button
                type="submit"
                class="btn full-width">

                Login

            </button>

        </form>

        <p class="auth-footer">

            Don't have an account?

            <a href="register.php">

                Register

            </a>

        </p>

    </section>

</main>

<?php
require_once '../includes/footer.php';