create database php_copying_app default character set utf8mb4;

use php_copying_app;

create table memos(
  id INT auto_increment primary key,
  content text not null,
  created_at datetime default current_timestamp,
  updated_at datetime default current_timestamp on update current_timestamp
  );

  CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  comment TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
