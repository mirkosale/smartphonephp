-- *********************************************
-- * Standard SQL generation                   
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 14 2021              
-- * Generation date: Tue Apr  5 13:38:22 2022 
-- * LUN file: F:\01-Projets\042-P_GesProj2\Smartphone\db_smartphone.lun 
-- * Schema: db_smartphone/SQL 
-- ********************************************* 


-- Database Section
-- ________________ 

drop database if exists db_smartphone;
create database db_smartphone;
use db_smartphone;


-- Tables Section
-- _____________ 

drop table if exists t_smartphone;

create table t_smartphone (
     idSmartphone int auto_increment not null,
     smaFullName varchar(100) not null,
     smaBrand varchar(20) not null,
     smaReleaseDate date not null,
     smaBatteryCapacity decimal(6,2) not null,
     smaDisplaySize decimal(4,2) not null,
     smaOS varchar(10) not null,
     constraint ID_t_smartphone_ID primary key (idSmartphone));


-- Index Section
-- _____________ 

create unique index ID_t_smartphone_IND
     on t_smartphone (idSmartphone);


DROP USER IF EXISTS `dbUser_smartphone`@`localhost`;
CREATE USER `dbUser_smartphone`@`localhost` identified by '.Etml-';
GRANT INSERT, SELECT, DELETE, UPDATE ON `db_smartphone`.* TO `dbUser_smartphone`@`localhost`;
FLUSH PRIVILEGES;