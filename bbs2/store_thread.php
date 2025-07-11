<?php
session_start();
require_once(__DIR__ . '/../db.php');
require_once(__DIR__ . '/Classes/Threads.php');

use Pcopy\Bbs2\Validation\ValidatorFactory;


$title = $_POST['title'] ?? '';
$title = trim($title);

$errors = [];
$validator = ValidatorFactory::create('thread');
$validator->validate($title);

if ($validator->hasErrors()) {
  $_SESSION['errors'] = $validator->getErrors();
  header('Location: create_thread.php');
  exit;
}

$threads = new Threads($pdo);
$threads->create($title);

header('Location: index.php');
exit;
