<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>JNJ Ilonggo Inasal</title>
</head>
<body class="bg-gray-200">
    <nav class="bg-red-700 text-white flex justify-between p-4 items-center">
        <h1 class="text-2xl font-bold">J&J Ilonggo Inasal</h1>
        <div class="flex items-center gap-2">
            <?php if (isset($_SESSION['manager_id'])): ?>
            <form action="logout.php" method="POST">
                <button type="submit" class="bg-red-700 text-white p-1 rounded-lg hover:bg-red-600 duration-200 underline"> Logout </button>
            </form>
        <?php endif; ?>