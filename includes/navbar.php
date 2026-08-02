<nav class="navbar">

    <div class="container">

<a href="/lights-out/index.php" class="logo">

    <img
        src="/lights-out/assets/images/logo.png"
        alt="Lights Out Logo"
        class="logo-image">

    <span>

        Lights Out

    </span>

</a>

        <ul class="nav-links">

            <li>
                <a href="/lights-out/index.php">Home</a>
            </li>

            <?php if (isset($_SESSION['user'])): ?>

                <li>
                    <a href="/lights-out/blog/create.php">New Article</a>
                </li>

                <li>
                    <a href="/lights-out/dashboard.php">Dashboard</a>
                </li>

                <li>
                    <span class="nav-user">
                        <?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </span>
                </li>

                <li>
                    <a href="/lights-out/actions/logout.php">Logout</a>
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