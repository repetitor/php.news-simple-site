<?php include_once 'helper-old.php'; ?>

<div> <?php include 'header.php'; ?> </div>

<?php
$result = getNewsItem($_GET['id']);
echo '<h1>'. $result['title'] .'</h1>';
echo '<p>'. $result['created_at'] .'</p>';
echo '<p>'. $result['author'] .'</p>';
echo '<p>'. $result['description'] .'</p>';
?>

<div> <?php include 'footer.php'; ?> </div>
