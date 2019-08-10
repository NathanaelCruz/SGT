## Para execução do sistema ##

### Antes de utilizar utilize os seguintes comandos no MySql

CREATE DATABASE DB_SYSTEM_GENERATOR_TICKETS;

USE DB_SYSTEM_GENERATOR_TICKETS;

CREATE TABLE 'tbl_models_tickets' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'event_name' varchar(200) NOT NULL,
  'img_event' varchar(38) DEFAULT NULL,
  'qtd' int(5) NOT NULL,
  'height_paper' double(7,2) NOT NULL,
  'width_paper' double(7,2) NOT NULL,
  'pos_code' int(1) DEFAULT '0',
  'color_code' varchar(12) NOT NULL,
  'dpi' int(3) NOT NULL,
  PRIMARY KEY ('id')
);

CREATE TABLE 'tbl_tickets' (
  'id' int(11) NOT NULL AUTO_INCREMENT,
  'id_model_ticket' int(11) NOT NULL,
  'code_ticket' varchar(16) NOT NULL,
  'status_ticket' tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY ('id'),
  KEY 'id_model_ticket' ('id_model_ticket'),
  CONSTRAINT 'tbl_tickets_idfk_1' FOREIGN KEY ('id_model_ticket') REFERENCES 'tbl_models_tickets' ('id')
);