DROP TABLE `buscar-archivos`.`tipos`;
DROP TABLE `buscar-archivos`.`archivos`;

CREATE TABLE `buscar-archivos`.`tipos` ( `id` INT NOT NULL AUTO_INCREMENT , `nombre` VARCHAR(10) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `buscar-archivos`.`archivos` ( `id` INT NOT NULL AUTO_INCREMENT , `codigo` VARCHAR(100) NOT NULL , `nombre` VARCHAR(200) NOT NULL , `id_tipo` INT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `archivos` ADD FOREIGN KEY (`id_tipo`) REFERENCES `archivos`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

/*
select *
from archivos ar
left join tipos ti
on ar.id_tipo = ti.id
;
*/
