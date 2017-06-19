
create database laravel;
use laravel;
create table if not EXISTS member (
  id int PRIMARY key auto_increment,
  name VARCHAR(16) not null DEFAULT  '',
  age tinyint(2) not null DEFAULT  0,
  phone VARCHAR(12) not null DEFAULT  '',
  index(name)
)engine=innodb charset=utf8;