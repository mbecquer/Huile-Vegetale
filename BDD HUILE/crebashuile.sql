/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  27/12/2020 14:46:38                      */
/*==============================================================*/


drop table if exists CONTENANCE;

drop table if exists PRIX;

drop table if exists PRODUIT;

/*==============================================================*/
/* Table : CONTENANCE                                           */
/*==============================================================*/
create table CONTENANCE
(
   ID_CONTENANCE        int not null auto_increment,
   QUANTITE_CONTENANCE  int not null,
   primary key (ID_CONTENANCE)
);

/*==============================================================*/
/* Table : PRIX                                                 */
/*==============================================================*/
create table PRIX
(
   ID_PRIX              int not null auto_increment,
   MONTANT_PRIX         decimal not null,
   primary key (ID_PRIX)
);

/*==============================================================*/
/* Table : PRODUIT                                              */
/*==============================================================*/
create table PRODUIT
(
   ID_PRODUIT           int not null auto_increment,
   ID_PRIX              int not null,
   ID_CONTENANCE        int not null,
   NOM_PRODUIT          varchar(100) not null,
   PROPRIETE_PRODUIT    varchar(100) not null,
   primary key (ID_PRODUIT)
);

alter table PRODUIT add constraint FK_AVOIR foreign key (ID_PRIX)
      references PRIX (ID_PRIX) on delete restrict on update restrict;

alter table PRODUIT add constraint FK_A_POUR foreign key (ID_CONTENANCE)
      references CONTENANCE (ID_CONTENANCE) on delete restrict on update restrict;

