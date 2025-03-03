<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-4">
    <h1>My Blogs</h1>
    
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
    
    <a href="/blog/public/blog/create" class="btn btn-primary mb-3">Create New Blog</a>
    
    <?php if (empty($blogs)): ?>
        <div class="alert alert-info">You haven't created any blogs yet.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($blogs as $blog): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                            <p class="card-text"><?php echo substr(htmlspecialchars($blog['content']), 0, 100); ?>...</p>
                            <p class="text-muted">Posted on <?php echo date('F j, Y', strtotime($blog['created_at'])); ?></p>
                            <a href="/blog/public/blog/show/<?php echo $blog['id']; ?>" class="btn btn-sm btn-primary">Read</a>
                            <a href="/blog/public/blog/edit/<?php echo $blog['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="/blog/public/blog/delete/<?php echo $blog['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>