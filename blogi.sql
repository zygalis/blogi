drop database if exists blogi;

create database blogi;

use blogi;

create table kayttaja (
    id int primary key auto_increment,
    sukunimi varchar(50) not null,
    etunimi varchar(50) not null,
    tunnus varchar(50) not null,
    salasana varchar(255) not null,
    email varchar(100) not null
);

create table kirjoitus (
    id int primary key auto_increment,
    otsikko varchar(50) not null,
    teksti text not null,
    kayttaja_id int not null,
    foreign key (kayttaja_id) references kayttaja(id)
    on delete restrict,
    paivays timestamp default current_timestamp
    on update current_timestamp
);

create table kommentti (
    id int primary key auto_increment,
    teksti text not null, 
    paivays timestamp default current_timestamp
    on update current_timestamp,
    kirjoitus_id int not null,
    foreign key (kirjoitus_id) references kirjoitus(id)
    on delete restrict,
    kayttaja_id int not null,
    foreign key (kayttaja_id) references kayttaja(id)
    on delete restrict
);

insert into kayttaja (sukunimi, etunimi, tunnus, salasana, email) values ('Eerika','Leppänen','n5leee00',md5('testi123'),'n5leee00@students.oamk.fi');
insert into kirjoitus (otsikko,teksti,kayttaja_id) values ('Testi','Tekstiä tekstiä', 1);
insert into kommentti (id, teksti, paivays, kirjoitus_id, kayttaja_id) values ('1', 'Testi kommentti', CURRENT_TIMESTAMP, '1', '1');
