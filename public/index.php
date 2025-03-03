<?php
require_once __DIR__ . '/../routes/routes.php';

$uri = isset($_GET['url']) ? $_GET['url'] : '/';

route($uri);
?>