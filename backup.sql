create database bypass;
use bypass;

create table users(
        id int(20) not null auto_increment primary key,
        name varchar(20) not null,
        password varchar(20) not null
);

insert into users(name, password) values('admin', '123456');
insert into users(name, password) values('test', '222222');
insert into users(name, password) values('steve', 'steve');
insert into users(name, password) values('alice', '123456');