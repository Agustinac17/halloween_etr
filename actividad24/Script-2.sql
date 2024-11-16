create database halloween_bd;
use halloween_bd;

CREATE TABLE disfraces (
  id_disfraz int(11) NOT NULL,
  nombre varchar(50) NOT NULL,
  descripcion text NOT NULL,
  votos int(11) NOT NULL,
  foto varchar(20) NOT NULL,
  foto_blob blob NOT NULL,
  eliminado int(11) NOT NULL DEFAULT 0
);
drop table disfraces;

CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL,
  nombre varchar(50) NOT NULL,
  clave text NOT NULL
);


CREATE TABLE votos (
  id_voto int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  id_disfraz int(11) NOT NULL
);
