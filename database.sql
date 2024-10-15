create database pokemondb
    default character set utf8
    collate utf8_unicode_ci;

use pokemondb;

create table product (
  id bigint(20) not null auto_increment primary key,
  name varchar(100) not null unique,
  weight float not null,
  height float not null,
  type enum('normal', 'fire', 'water', 'grass', 'electric', 'ice', 'fighting', 'poison', 'ground', 'flying', 'psychic', 'bug', 'rock', 'ghost', 'dragon', 'dark', 'steel', 'fairy') not null,
  evolution int not null
) engine=innodb default charset=utf8 collate=utf8_unicode_ci;

create user pokemonuser@localhost
    identified by 'pokemonpassword';

grant all
    on pokemondb.*
    to pokemonuser@localhost;

flush privileges;