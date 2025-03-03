<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error']; 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <h1 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h1>
            <h6 class="card-subtitle mb-2 text-muted">By <?php echo htmlspecialchars($blog['username']); ?></h6>
            <p class="text-muted">Posted on <?php echo date('F j, Y', strtotime($blog['created_at'])); ?></p>
            
            <div class="mt-4">
                <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
            </div>
            
            <div class="mt-4">
                <a href="/blog/public/blog" class="btn btn-secondary">Back to All Blogs</a>
                
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $blog['user_id']): ?>
                    <a href="/blog/public/blog/edit/<?php echo $blog['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="/blog/public/blog/delete/<?php echo $blog['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

