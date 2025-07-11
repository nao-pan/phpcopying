<?php
session_start();
require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/classes/Threads.php');
require_once(__DIR__ . '/classes/Validator.php');

$title = $_POST['title'] ?? '';
$title = trim($title);

$errors = [];
$validator = new Validator();
$validator->validateThreadTitle($title);

if ($validator->hasErrors()) {
  $_SESSION['errors'] = $validator->getErrors();
  header('Location: create_thread.php');
  exit;
}

$threads = new Threads($pdo);
$threads->create($title);

header('Location: index.php');
exit;
