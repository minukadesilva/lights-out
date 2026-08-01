<?php
declare(strict_types=1);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
?>

<main class="auth-page">

    <section class="auth-card">

        <h1>Create Account</h1>

        <p class="auth-subtitle">
            Join Lights Out and start publishing Formula One articles.
        </p>

        <form action="../actions/register_action.php"
              method="POST">

            <div class="form-group">

                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter your username"
                    required>

            </div>

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

            <div class="form-group">

                <label for="confirm_password">

                    Confirm Password

                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="Confirm your password"
                    required>

            </div>

            <button type="submit" class="btn full-width">

                Register

            </button>

        </form>

        <p class="auth-footer">

            Already have an account?

            <a href="login.php">Login</a>

        </p>

    </section>

</main>

<?php
require_once '../includes/footer.php';