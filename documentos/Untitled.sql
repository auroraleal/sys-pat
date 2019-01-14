-- -----------------------------------------------------
-- Table convenio_imagens
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS convenio_imagens (
  id INT(11) NOT NULL AUTO_INCREMENT,
  mime VARCHAR (255) NOT NULL,
  data_registro DATETIME NOT NULL,
  data BLOB          NOT NULL,
  convenio_id INT(11) NOT NULL,
  PRIMARY KEY (id))
ENGINE = InnoDB
AUTO_INCREMENT = 9
DEFAULT CHARACTER SET = utf8;

ALTER TABLE convenio_imagens ADD CONSTRAINT fk_convenio_id FOREIGN KEY (convenio_id) REFERENCES convenios(id);