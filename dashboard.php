<?php
require_once __DIR__ . '/includes/header.php';

$pageTitle = 'Home';
$activePage = 'dashboard';

$userProfile = $_SESSION['userProfile'];

$model = new Model();

?>



<?php require_once __DIR__ . '/includes/footer.php'; ?>