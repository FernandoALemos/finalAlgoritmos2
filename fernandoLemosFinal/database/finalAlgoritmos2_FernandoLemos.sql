-- create database finalAlgoritmos2_FernandoLemos;

-- use finalAlgoritmos2_FernandoLemos;

create table roles(
    id int auto_increment,
    nombreRol varchar (30),
    primary key (id)
);

insert into roles (nombreRol) values ('Administrador'), ('Profesor'), ('Alumno');

create table estados(
	id int auto_increment,
    nombreEstado varchar(30),
    primary key (id)
);

insert into estados (nombreEstado) values ('Activo'), ('Suspendido');

create table carreras(
	id int auto_increment,
    nombreCarrera varchar(70) UNIQUE,
	diasCursada varchar(70),
    turno varchar(30),
    primary key (id)
);

create table usuarios(
    id int auto_increment,
    nombre varchar(30),
    apellido varchar(30),
    rol int,
    contraseña varchar(30),
    email varchar(30) UNIQUE,
    dni int(8) UNIQUE,
    foreign key (rol) references roles(id),
    primary key (id,rol)
);

create table materias(
    id int(2) auto_increment,
    materia varchar (45),
    profesor int,
    carrera int,
    foreign key (carrera) references carreras(id),
    foreign key (profesor) references usuarios(id),
    primary key (id,carrera)
); 

create table notas(
    idUsuario int,
    idMateria int,
	notaParcial1 float(1.2),
    notaParcial2 float(1.2),
    notaFinal float(1.2),
    foreign key (idUsuario) references usuarios(id),
    foreign key (idMateria) references materias(id),
    primary key (idUsuario,idMateria)
);


alter table usuarios add idEstado int;
alter table usuarios add foreign key (idEstado) references estados(id);

insert into usuarios (nombre,apellido,rol,contraseña,email,dni,idEstado) values 
('Administrador','God',1,'admin123','agod@gmail.com',9999,1),
('Paula','Giamo',2,'pgiamo','pgiamo@gmail.com',28102975,1),
('Graciana','Roldan',2,'groldan','groldan@gmail.com',33456700,1),
('Juan','Pellegrini',2,'jpellegrini','jpellegrini@gmail.com',21031795,1),
('Diego','Pacini',2,'dpacini','dpacini@gmail.com',30445687,1),
('Juan','Coduto',2,'jcoduto','jcoduto@gmail.com',32564779,1),
('Angelica','Zozula',2,'azozula','azozula@gmail.com',27456159,1),
('Gabriela','Pugliese',2,'gpugliese','gpugliese@gmail.com',27444111,1),
('Elizabeth','Obirek',2,'eobirek','eobirek@gmail.com',26456127,1),
('Fernando','Lemos',3,'flemos','flemos@gmail.com',37865101,1),
('Gonzalo','Rojas',3,'grojas','grojas@gmail.com',36123789,1),
('Alexia','Cepeda',3,'acepeda','acepeda@gmail.com',41346781,1),
('Jesica','Dalmazzo',3,'jdalmazzo','jdalmazzo@gmail.com',34159746,1),
('Nicolas','Camaño',3,'ncamaño','ncamaño@gmail.com',37456881,1),
('Lautaro','Rossi',3,'lrossi','lrossi@gmail.com',40159741,1),
('Juan','Perez',3,'jperez','jperez@gmail.com',29111222,2),
('Mariano','Morbelli',3,'mmorbelli','mmorbelli@gmail.com',30451879,2);


insert into carreras (nombreCarrera,diasCursada,turno) values 
('Analista de sistemas','Lunes a viernes','Vespertino'),
('Profesorado de matemática','Lunes a viernes','Mañana, Tarde, Vespertino'),
('Profesorado de química','Lunes a viernes','Vespertino');

insert into materias (materia,profesor,carrera) values 
('Algoritmos y Estructura de dtaos II',2,1),
('Base de datos II',4,1),
('Practicas profesionalizantes II',3,1),
('Ingles II',7,1),
('Analisis matemático',8,2),
('Probabilidad y Estadistica',9,2),
('Sistemas Operativos', 5, 1),
('Probabilidad y Estadistica',9,1),
('Química',6,3);


select * from usuarios;
select * from carreras;
select * from materias;



