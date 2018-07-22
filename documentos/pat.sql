-- MySQL Script generated by MySQL Workbench
-- Sat Jul 21 22:28:31 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema pat
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema pat
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pat` DEFAULT CHARACTER SET utf8 ;
USE `pat` ;

-- -----------------------------------------------------
-- Table `pat`.`programa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`programa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `fonte` VARCHAR(45) NOT NULL,
  `valor` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`funcao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`funcao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`subfuncao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`subfuncao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `funcao_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_subfuncao_funcao1_idx` (`funcao_id` ASC),
  CONSTRAINT `fk_subfuncao_funcao1`
    FOREIGN KEY (`funcao_id`)
    REFERENCES `pat`.`funcao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`acao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`acao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(150) NOT NULL,
  `programa_id` INT NOT NULL,
  `funcao_id` INT NOT NULL,
  `subfuncao_id` INT NOT NULL,
  `resultado` LONGTEXT NOT NULL,
  `ano` INT NOT NULL,
  `objetivo` LONGTEXT NOT NULL,
  `periodo_inicio` DATE NOT NULL,
  `periodo_fim` DATE NOT NULL,
  `quantidade_iniciativas` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_acao_programa_idx` (`programa_id` ASC),
  INDEX `fk_acao_funcao1_idx` (`funcao_id` ASC),
  INDEX `fk_acao_subfuncao1_idx` (`subfuncao_id` ASC),
  CONSTRAINT `fk_acao_programa`
    FOREIGN KEY (`programa_id`)
    REFERENCES `pat`.`programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acao_funcao1`
    FOREIGN KEY (`funcao_id`)
    REFERENCES `pat`.`funcao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acao_subfuncao1`
    FOREIGN KEY (`subfuncao_id`)
    REFERENCES `pat`.`subfuncao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`orgao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`orgao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NULL,
  `unidade_orcamentaria` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`iniciativa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`iniciativa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` TEXT NOT NULL,
  `acao_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_iniciativa_acao1_idx` (`acao_id` ASC),
  CONSTRAINT `fk_iniciativa_acao1`
    FOREIGN KEY (`acao_id`)
    REFERENCES `pat`.`acao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`quadrimestre`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`quadrimestre` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valor_inicial` VARCHAR(45) NOT NULL,
  `valor_atual` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `ano` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`fonte_recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`fonte_recurso` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`programa_has_orgao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`programa_has_orgao` (
  `programa_id` INT NOT NULL,
  `orgao_id` INT NOT NULL,
  PRIMARY KEY (`programa_id`, `orgao_id`),
  INDEX `fk_programa_has_orgao_orgao1_idx` (`orgao_id` ASC),
  INDEX `fk_programa_has_orgao_programa1_idx` (`programa_id` ASC),
  CONSTRAINT `fk_programa_has_orgao_programa1`
    FOREIGN KEY (`programa_id`)
    REFERENCES `pat`.`programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_programa_has_orgao_orgao1`
    FOREIGN KEY (`orgao_id`)
    REFERENCES `pat`.`orgao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`orgao_has_fonte_recurso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`orgao_has_fonte_recurso` (
  `orgao_id` INT NOT NULL,
  `fonte_recurso_id` INT NOT NULL,
  PRIMARY KEY (`orgao_id`, `fonte_recurso_id`),
  INDEX `fk_orgao_has_fonte_recurso_fonte_recurso1_idx` (`fonte_recurso_id` ASC),
  INDEX `fk_orgao_has_fonte_recurso_orgao1_idx` (`orgao_id` ASC),
  CONSTRAINT `fk_orgao_has_fonte_recurso_orgao1`
    FOREIGN KEY (`orgao_id`)
    REFERENCES `pat`.`orgao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orgao_has_fonte_recurso_fonte_recurso1`
    FOREIGN KEY (`fonte_recurso_id`)
    REFERENCES `pat`.`fonte_recurso` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`quadrimestre_has_iniciativa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`quadrimestre_has_iniciativa` (
  `quadrimestre_id` INT NOT NULL,
  `iniciativa_id` INT NOT NULL,
  `meta` VARCHAR(4) NOT NULL,
  `tipo_meta` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`quadrimestre_id`, `iniciativa_id`),
  INDEX `fk_quadrimestre_has_iniciativa_iniciativa1_idx` (`iniciativa_id` ASC),
  INDEX `fk_quadrimestre_has_iniciativa_quadrimestre1_idx` (`quadrimestre_id` ASC),
  CONSTRAINT `fk_quadrimestre_has_iniciativa_quadrimestre1`
    FOREIGN KEY (`quadrimestre_id`)
    REFERENCES `pat`.`quadrimestre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quadrimestre_has_iniciativa_iniciativa1`
    FOREIGN KEY (`iniciativa_id`)
    REFERENCES `pat`.`iniciativa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pat`.`perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`perfil` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO `pat`.`perfil` (`nome`) VALUES ('Administrador');
INSERT INTO `pat`.`perfil` (`nome`) VALUES ('Técnico');

-- -----------------------------------------------------
-- Table `pat`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pat`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `senha` VARCHAR(45) NULL,
  `perfil_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_usuario_perfil1_idx` (`perfil_id` ASC),
  CONSTRAINT `fk_usuario_perfil1`
    FOREIGN KEY (`perfil_id`)
    REFERENCES `pat`.`perfil` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO `pat`.`usuario` (`nome`, `email`, `senha`, `perfil_id`) VALUES ('admin', 'admin@macapa.ap.gov.br', md5('123456'), 1);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;