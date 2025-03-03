<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>All Blogs</h1>
    
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
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="/blog/public/blog/create" class="btn btn-primary mb-3">Create New Blog</a>
    <?php endif; ?>
    
    <?php if (empty($blogs)): ?>
        <div class="alert alert-info">No blogs found.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">By <?php echo htmlspecialchars($blog['username']); ?></h6>
                            <p class="card-text"><?php echo substr(htmlspecialchars($blog['content']), 0, 100); ?>...</p>
                            <p class="text-muted">Posted on <?php echo date('F j, Y', strtotime($blog['created_at'])); ?></p>
                            <a href="/blog/public/blog/show/<?php echo $blog['id']; ?>" class="btn btn-sm btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>