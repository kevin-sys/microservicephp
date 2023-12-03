CREATE TABLE empleados (
    Identificacion VARCHAR(11) NOT NULL PRIMARY KEY,
    PrimerNombre VARCHAR(30) NOT NULL,
    SegundoNombre VARCHAR(30),
    PrimerApellido VARCHAR(25) NOT NULL,
    SegundoApellido VARCHAR(25) NOT NULL,
    FechaNacimiento DATE NOT NULL,
    Sexo CHAR(1) NOT NULL,
    Celular VARCHAR(10) NOT NULL,
    Correo VARCHAR(255) NOT NULL,
    Cargo VARCHAR(20) NOT NULL,
    Dependencia VARCHAR(50) NOT NULL,
    EstadoLaboral VARCHAR(50) NOT NULL
);
create table activos (
FechaIngreso date,
OrdenCompra VARCHAR(50) NOT NULL,
Estado VARCHAR(20) NOT null,
Proveedor VARCHAR(255) NOT NULL,
FacturaNumero VARCHAR(100),
ConsecutivoNumero VARCHAR(20),
Descripcion VARCHAR(100) NOT NULL,
Marca VARCHAR(100) NOT NULL,
Modelo VARCHAR(40) NOT NULL,
Capacidad VARCHAR(20) NOT NULL,
FechaRegistro timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);
ALTER TABLE activos
ADD COLUMN Asignado VARCHAR(20) DEFAULT 'No asignado';
ALTER TABLE activos
MODIFY Capacidad VARCHAR(20) DEFAULT 'No aplica';
DELETE FROM asignacion_activos where 0=0;


SELECT * FROM asignacion_activos;
ALTER TABLE activos
ADD CodigoActivo char(8) COLLATE utf8_spanish_ci DEFAULT NULL;
select * from activos;

DELIMITER $$
CREATE TRIGGER `GenerarCodigoActivo` BEFORE INSERT ON `activos` FOR EACH ROW BEGIN
    declare str_len int default 8;
    declare ready int default 0;
    declare rnd_str text;
    while not ready do
        set rnd_str := lpad(conv(floor(rand()*pow(36,str_len)), 10, 36), str_len, 0);
        if not exists (select * from activos where CodigoActivo = rnd_str) then
            set new.CodigoActivo = rnd_str;
            set ready := 1;
        end if;
    end while;
END
$$
DELIMITER ;

CREATE TABLE dependencias (
    CodigoDependencia CHAR(8) COLLATE utf8_spanish_ci DEFAULT NULL,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(100) NOT NULL,
    CorreoContacto VARCHAR(100) NOT NULL,
    FechaRegistro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    PRIMARY KEY (Nombre),
    UNIQUE (Nombre)
);
select * from dependencias;





DELIMITER $$
CREATE TRIGGER `GenerarCodigoDependencia` BEFORE INSERT ON `dependencias` FOR EACH ROW BEGIN
    declare str_len int default 8;
    declare ready int default 0;
    declare rnd_str text;
    while not ready do
        set rnd_str := lpad(conv(floor(rand()*pow(36,str_len)), 10, 36), str_len, 0);
        if not exists (select * from dependencias where CodigoDependencia = rnd_str) then
            set new.CodigoDependencia = rnd_str;
            set ready := 1;
        end if;
    end while;
END
$$
DELIMITER ;
SELECT *FROM dependencias;
SELECT COUNT(*) AS total FROM dependencias;


CREATE TABLE licencias (
    CodigoLicencia CHAR(8) COLLATE utf8_spanish_ci DEFAULT NULL,
    FechaAdquisicion DATE NOT NULL,
    FechaExpiracion DATE NOT NULL,
    OrdenCompra VARCHAR(50) NOT NULL,
    FacturaNumero VARCHAR(50) NOT NULL,
    ClaveLicencia VARCHAR(50) NOT NULL,
    Proveedor VARCHAR(50) NOT NULL,
    CantidadEquipos INT NOT NULL,
    PrecioLicencia DECIMAL(10, 2) NOT NULL,
    Descripcion TEXT NOT NULL,
    FechaRegistro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
    UNIQUE (ClaveLicencia)
);

DELIMITER $$
CREATE TRIGGER `GenerarCodigoLicencia` BEFORE INSERT ON `licencias` FOR EACH ROW BEGIN
    declare str_len int default 8;
    declare ready int default 0;
    declare rnd_str text;
    while not ready do
        set rnd_str := lpad(conv(floor(rand()*pow(36,str_len)), 10, 36), str_len, 0);
        if not exists (select * from licencias where CodigoLicencia = rnd_str) then
            set new.CodigoLicencia = rnd_str;
            set ready := 1;
        end if;
    end while;
END
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER `GenerarCodigoLicencia` BEFORE INSERT ON `licencias` FOR EACH ROW BEGIN
    declare ready int default 0;
    declare timestamp_str VARCHAR(14);
    
    while not ready do
        set timestamp_str := DATE_FORMAT(NOW(), '%Y%m%d%H%i%s');
        set new.CodigoLicencia := CONCAT(timestamp_str, LPAD(FLOOR(RAND() * 10000), 4, '0'));
        
        if not exists (select * from licencias where CodigoLicencia = new.CodigoLicencia) then
            set ready := 1;
        end if;
    end while;
END
$$
DELIMITER ;
select * from activos;


CREATE TABLE asignacion_activos (
  ID INT AUTO_INCREMENT PRIMARY KEY,
  FechaAsignacion DATE NOT NULL,
  CodigoActivo VARCHAR(11) NOT NULL,
  FechaIngreso DATE NOT NULL,
  OrdenCompra VARCHAR(35) NOT NULL,
  FacturaNumero VARCHAR(35) NOT NULL,
  Estado VARCHAR(20) NOT NULL,
  Proveedor VARCHAR(150) NOT NULL,
  Descripcion VARCHAR(150) NOT NULL,
  Marca VARCHAR(35) NOT NULL,
  Modelo VARCHAR(35) NOT NULL,
  Capacidad VARCHAR(35),
  Dependencia VARCHAR(150) NOT NULL,
  Empleado VARCHAR(150) NOT NULL,
  Cuenta VARCHAR(50) NOT NULL,
  Subcuenta VARCHAR(50) NOT NULL,
  FechaRegistro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP()
);
ALTER TABLE asignacion_activos
MODIFY Cuenta VARCHAR(250) NOT NULL;
ALTER TABLE asignacion_activos
MODIFY Subcuenta VARCHAR(250) NOT NULL;

select * from activos;
select * from asignacion_activos;


DELIMITER $$
CREATE TRIGGER `ActualizarAsignado` AFTER INSERT ON `asignacion_activos` FOR EACH ROW
BEGIN
    UPDATE activos
    SET Asignado = 'Asignado'
    WHERE CodigoActivo = NEW.CodigoActivo;
END
$$
DELIMITER ;


CREATE TABLE usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Usuario VARCHAR(255) NOT NULL,
    ContrasenaHash VARCHAR(255) NOT NULL
);
insert into usuarios (Usuario,Contrasena)values('kevin','kevin');
select * from usuarios;
CREATE TABLE usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Usuario VARCHAR(255) NOT NULL,
    Contrasena VARCHAR(255) NOT NULL
);

SELECT *FROM activos;

select * from asignacion_activos;
delete from activos where  Estado="Nuevo" or 0=0;

ALTER TABLE activos
ADD Cuenta VARCHAR(300),
ADD Subcuenta VARCHAR(300);

alter table activos 
ADD Precio DECIMAL(18, 4)

DELIMITER //
CREATE TRIGGER generar_consecutivo BEFORE INSERT ON activos
FOR EACH ROW
BEGIN
    DECLARE anio_mes CHAR(6);
    DECLARE sec INT;

    -- Obtener año y mes del sistema
    SET anio_mes = DATE_FORMAT(NOW(), '%Y%m');

    -- Obtener la secuencia actual
    SELECT IFNULL(MAX(SUBSTRING(ConsecutivoNumero, 7))+1, 1) INTO sec FROM activos WHERE SUBSTRING(ConsecutivoNumero, 1, 6) = anio_mes;

    -- Componer el nuevo consecutivo
    SET NEW.ConsecutivoNumero = CONCAT(anio_mes, LPAD(sec, 4, '0'));
END;
//
DELIMITER ;


