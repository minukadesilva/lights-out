<?php

declare(strict_types=1);

require_once '../includes/header.php';
require_once '../includes/navbar.php';
require_once '../config/database.php';

if (!isset($_SESSION['user'])) {
    redirect("auth/login.php");
}

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("
SELECT *
FROM blogPost
WHERE id=?
");

$stmt->bind_param("i",$id);

$stmt->execute();

$result=$stmt->get_result();

if($result->num_rows===0){

    die("Article not found.");

}

$blog=$result->fetch_assoc();

if($blog['user_id']!=$_SESSION['user']['id']){

    die("Unauthorized.");

}
?>

<main class="editor-page">

<div class="editor-container">

<h1>Edit Article</h1>

<form
action="../actions/update_blog.php"
method="POST">

<input
type="hidden"
name="id"
value="<?= $blog['id'] ?>">

<div class="form-group">

<label>Title</label>

<input
type="text"
name="title"
value="<?= htmlspecialchars($blog['title']) ?>"
required>

</div>

<div class="editor-grid">

<textarea
id="content"
name="content"><?= htmlspecialchars($blog['content']) ?></textarea>

<div
id="preview"
class="preview">

</div>

</div>

<button
class="btn">

Update Article

</button>

</form>

</div>

</main>

<script src="../assets/js/editor.js"></script>

<?php
require_once '../includes/footer.php';