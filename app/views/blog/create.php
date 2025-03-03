<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>Create New Blog</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    
    <form action="/blog/public/blog/store" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($_SESSION['form_data']['title']) ? htmlspecialchars($_SESSION['form_data']['title']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo isset($_SESSION['form_data']['content']) ? htmlspecialchars($_SESSION['form_data']['content']) : ''; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create Blog</button>
        <a href="/blog/public/blog" class="btn btn-secondary">Cancel</a>
    </form>
    
    <?php 
        if (isset($_SESSION['form_data'])) {
            unset($_SESSION['form_data']);
        }
    ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>