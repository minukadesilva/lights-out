<nav class="navbar">

    <div class="container">

        <a href="/lights-out/index.php" class="logo">
            🏎️ Lights Out
        </a>

        <ul class="nav-links">

            <li>
                <a href="/lights-out/index.php">Home</a>
            </li>

            <?php if (isset($_SESSION['user_id'])): ?>

                <li>
                    <a href="/lights-out/dashboard.php">Dashboard</a>
                </li>

                <li>
                    <a href="/lights-out/actions/logout_action.php">Logout</a>
                </li>

            <?php else: ?>

                <li>
                    <a href="/lights-out/auth/login.php">Login</a>
                </li>

                <li>
                    <a href="/lights-out/auth/register.php">Register</a>
                </li>

            <?php endif; ?>

        </ul>

    </div>

</nav>