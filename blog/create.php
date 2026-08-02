<?php

declare(strict_types=1);

require_once '../includes/header.php';
require_once '../includes/navbar.php';

if (!isset($_SESSION['user'])) {
    header("Location: /lights-out/auth/login.php");
    exit;
}
?>

<main class="editor-page">

    <div class="editor-container">

        <h1>Write a New Article</h1>

        <p class="editor-subtitle">
            Share your Formula One thoughts with the community.
        </p>

        <form action="../actions/create_blog.php" method="POST">

            <div class="form-group">

                <label for="title">Article Title</label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="e.g. Belgian GP Race Review"
                    required>

            </div>

            <div class="toolbar">

                <button type="button" onclick="insertMarkdown('bold')">
                    Bold
                </button>

                <button type="button" onclick="insertMarkdown('italic')">
                    Italic
                </button>

                <button type="button" onclick="insertMarkdown('h1')">
                    H1
                </button>

                <button type="button" onclick="insertMarkdown('h2')">
                    H2
                </button>

                <button type="button" onclick="insertMarkdown('list')">
                    List
                </button>

            </div>

            <div class="editor-grid">

                <textarea
                    id="content"
                    name="content"
                    placeholder="Write your article in Markdown..."
                    required></textarea>

                <div id="preview" class="preview">

                    Live Preview

                </div>

            </div>

            <button class="btn">

                Publish Article

            </button>

        </form>

    </div>

</main>

<script src="../assets/js/editor.js"></script>

<?php
require_once '../includes/footer.php';