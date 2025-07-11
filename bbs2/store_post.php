<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/classes/Posts.php';

use Pcopy\Bbs2\Validation\ValidatorFactory;


session_start();


$thread_id = trim($_POST['thread_id'] ?? '');
$name = trim($_POST['name'] ?? '名無しさん');
$body = trim($_POST['body'] ?? '');

$validator = ValidatorFactory::create('post');
$validator->validate($_POST);
if ($validator->hasErrors()) {
  $_SESSION['errors'] = $validator->getErrors();
  header("Location: thread.php?id={$threadId}");
  exit;
}

$post = new Posts($pdo);
$post->save($thread_id, $name, $body);

header("Location: thread.php?id={$threadId}");
exit;
