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



create table t_os (
     idOS int auto_increment not null,
	 osName varchar(15) not null
     constraint ID_t_os_ID primary key (idOS));

create table t_price (
     idPrice int auto_increment not null,
     priAmount decimal(7,2) not null,
     priDate date not null,
     fkSmartphone int not null,
     constraint ID_t_price_ID primary key (idPrice));

create table t_smartphone (
     idSmartphone int auto_increment not null,
     smaFullName varchar(100) not null,
     smaBrand varchar(20) not null,
     smaReleaseDate date not null,
     smaRAM int(2) not null,
     smaStorage int(3) not null,
     smaBatteryCapacity decimal(6,2) not null,
     smaBatteryLastedMinutes int(4) not null,
     smaDisplaySize decimal(4,2) not null,
     smaCPUCores int(2) not null,
     smaCPUClockSpeed decimal(6,1) not null,
	fkOS int not null,
     constraint ID_t_smartphone_ID primary key (idSmartphone));


-- Constraints Section
-- ___________________ 

alter table t_price add constraint EQU_t_pri_t_sma_FK
     foreign key (fkSmartphone)
     references t_smartphone(idSmartphone);

alter table t_smartphone add constraint ID_t_smartphone_CHK
     check(exists(select * from t_price
                  where t_price.idSmartphone = idSmartphone)); 

alter table t_smartphone add constraint REF_t_sma_t_os_FK
     foreign key (fkOS)
     references t_os(idOS);


-- Index Section
-- _____________ 

create unique index ID_t_os_IND
     on t_os (idOS);

create unique index ID_t_price_IND
     on t_price (idPrice);

create index EQU_t_pri_t_sma_IND
     on t_price (fkSmartphone);

create unique index ID_t_smartphone_IND
     on t_smartphone (idSmartphone);

create index REF_t_sma_t_os_IND
     on t_smartphone (fkOS);

INSERT INTO t_os (osName) VALUES ("Android"), ("iOS"), ("Windows");

DROP USER IF EXISTS `dbUser_smartphone`@`localhost`;
CREATE USER `dbUser_smartphone`@`localhost` identified by '.Etml-';
GRANT INSERT, SELECT, DELETE, UPDATE ON `db_smartphone`.* TO `dbUser_smartphone`@`localhost`;
FLUSH PRIVILEGES;