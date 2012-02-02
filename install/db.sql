-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 01 feb, 2012 at 11:16 PM
-- Versione MySQL: 5.5.9
-- Versione PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `fumezzi`
--
-- CREATE DATABASE `fumezzi` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
-- USE `fumezzi`;

-- --------------------------------------------------------

--
-- Struttura della tabella `Amicizie`
--

CREATE TABLE IF NOT EXISTS `Amicizie` (
  `utente1` varchar(30) NOT NULL,
  `utente2` varchar(30) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `approvazione1` enum('true','false') NOT NULL DEFAULT 'false',
  `approvazione2` enum('true','false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`utente1`,`utente2`),
  KEY `utente2` (`utente2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Amicizie`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `Campi`
--

CREATE TABLE IF NOT EXISTS `Campi` (
  `nomeForm` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posizione` int(11) NOT NULL,
  `tipo` enum('text','textfield','password','confermaPass','legend','submit','reset','login','file','checkbox','int','hidden') NOT NULL,
  `nome` varchar(30) NOT NULL,
  `descrizione` varchar(50) NOT NULL COMMENT 'Cosa verrà visualizzato nel form',
  `valore` varchar(50) NOT NULL COMMENT 'verrà inserito nel campo "value"',
  `setPrecedente` enum('y','n') NOT NULL DEFAULT 'n' COMMENT 'se il tipo è "legend" indica se lasciare aperto il precedente textfield o no.',
  `richiesto` enum('y','n') NOT NULL DEFAULT 'n',
  `aCapo` enum('y','n') NOT NULL DEFAULT 'y',
  `customFunction` varchar(30) DEFAULT NULL,
  `controlli` set('isLong1','isLong4','isLong8','notHasProhibitedChars') DEFAULT 'isLong4,notHasProhibitedChars',
  PRIMARY KEY (`id`),
  KEY `nomeForm` (`nomeForm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dump dei dati per la tabella `Campi`
--

INSERT INTO `Campi` VALUES('registrazione', 1, 0, 'legend', 'Informazioni account', '', '', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('registrazione', 2, 1, 'textfield', 'username', 'Username', '', 'y', 'y', 'y', 'controlloUser', 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 3, 2, 'confermaPass', 'password', 'Password', '', 'n', 'y', 'y', 'confermaPass', 'isLong1');
INSERT INTO `Campi` VALUES('registrazione', 4, 4, 'legend', 'Informazioni personali', '', '', 'n', 'y', 'y', NULL, '');
INSERT INTO `Campi` VALUES('registrazione', 5, 5, 'textfield', 'nome', 'Nome', '', 'y', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 6, 6, 'textfield', 'cognome', 'Cognome', '', 'y', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 7, 7, 'textfield', 'luogo', 'Dove abiti?', '', 'y', 'n', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 8, 9, 'submit', 'invia', 'Registrati!', 'Registrati!', 'n', 'n', 'n', NULL, NULL);
INSERT INTO `Campi` VALUES('registrazione', 9, 10, 'reset', 'reset', 'Ripristina campi', 'Ripristina campi', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('registrazione', 10, 3, 'textfield', 'email', 'eMail', '', 'y', 'y', 'y', 'controlloEmail', 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 11, 8, 'legend', '', '', '', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaDati', 12, 0, 'legend', 'Informazioni personali', '', '', 'n', 'y', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 14, 1, 'textfield', 'nome', 'Nome', 'userName', 'n', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 15, 2, 'textfield', 'cognome', 'Cognome', 'userCognome', 'n', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 16, 3, 'textfield', 'luogo', 'Dove ti trovi adesso?', 'userPlace', 'n', 'n', 'y', NULL, 'notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 17, 5, 'submit', 'submit', 'Modifica', 'Modifica', 'n', 'n', 'n', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 18, 6, 'reset', 'reset', 'Ripristina campi', 'Ripristina campi', 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 19, 4, 'legend', '', '', '', 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaPassword', 20, 0, 'legend', 'Modifica password', '', '', 'n', 'y', 'y', NULL, 'isLong4');
INSERT INTO `Campi` VALUES('modificaPassword', 22, 1, 'password', 'passOld', 'Vecchia password', '', 'n', 'y', 'y', 'controlloLogin', 'isLong1');
INSERT INTO `Campi` VALUES('modificaPassword', 24, 3, 'confermaPass', 'password', 'Nuova password', '', 'n', 'y', 'y', 'confermaPass', 'isLong1');
INSERT INTO `Campi` VALUES('modificaPassword', 25, 4, 'legend', '', '', '', 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaPassword', 26, 5, 'submit', 'submit', '', 'Modifica', 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaMail', 27, 0, 'legend', 'Modifica e-mail', '', '', 'n', 'y', 'y', NULL, 'isLong1');
INSERT INTO `Campi` VALUES('modificaMail', 28, 1, 'textfield', 'email', 'Nuova e-mail', 'userMail', 'n', 'y', 'y', 'controlloEmail', 'notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaMail', 29, 2, 'submit', 'submit', '', 'Modifica', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 30, 0, 'legend', 'Dati serie', 'Dati serie', 'Dati serie', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 31, 1, 'textfield', 'nome', 'Nome', '', 'y', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('inserisciSerie', 32, 2, 'file', 'nomefile', 'Immagine', '', 'y', 'n', 'y', 'fileIsSet', NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 33, 3, 'checkbox', 'inCorso', 'La serie &egrave; in corso', 'true', 'y', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 34, 4, 'submit', 'invia', '', 'Aggiungi', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 35, 0, 'legend', 'Dati fumetto', 'Dati fumetto', 'Dati fumetto', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 36, 1, 'textfield', 'nome', 'Nome o titolo', '', 'y', 'n', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('inserisciFumetto', 37, 2, 'file', 'nomefile', 'Copertina', '', 'y', 'n', 'y', 'fileIsSet', NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 38, 4, 'int', 'volume', 'Numero del volume', '', 'y', 'y', 'y', 'controlloVolume', NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 39, 5, 'submit', 'submit', '', 'Aggiungi', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 40, 6, 'hidden', 'serie', '', 'setSerieGet', 'y', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('cerca', 41, 0, 'textfield', 'parolaChiave', 'Parola chiave', '', 'y', 'y', 'n', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('cerca', 42, 1, 'submit', 'submit', 'Cerca', 'Cerca', 'n', 'n', 'y', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Commenti`
--

CREATE TABLE IF NOT EXISTS `Commenti` (
  `utente` varchar(30) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testo` longtext NOT NULL,
  `spoiler` enum('true','false') NOT NULL DEFAULT 'false',
  `tipo` enum('serie','volume') NOT NULL DEFAULT 'volume',
  `idSerie` int(11) DEFAULT NULL,
  `idVolume` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idSerie` (`idSerie`),
  KEY `idVolume` (`idVolume`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `Commenti`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `Form`
--

CREATE TABLE IF NOT EXISTS `Form` (
  `nome` varchar(50) NOT NULL DEFAULT 'modulo',
  `metodo` enum('get','post') NOT NULL DEFAULT 'post',
  `successo` varchar(100) NOT NULL DEFAULT 'Operazione eseguita!' COMMENT 'Messaggio da visualizzare in caso di modifica avvenuta',
  `fallimento` varchar(100) NOT NULL,
  `funzioneForm` varchar(50) DEFAULT NULL COMMENT 'Funzione che verrà eseguita se i controlli saranno superati',
  `reindirizzamento` varchar(50) DEFAULT NULL COMMENT 'Pagina a cui si viene reindirizzati in caso di successo (null per non essere reindirizzati)',
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Form`
--

INSERT INTO `Form` VALUES('cerca', 'post', 'Ricerca effettuata', 'Errore nella ricerca', 'cercaCose', NULL);
INSERT INTO `Form` VALUES('inserisciFumetto', 'post', 'Fumetto aggiunto!', 'C''&egrave; stato un problema nell''aggiungere il fumetto.', 'aggiungiFumetto', 'list.php');
INSERT INTO `Form` VALUES('inserisciSerie', 'post', 'Serie aggiunta!', 'C''&egrave; stato un problema nell''aggiungere la serie.', 'aggiungiSerie', 'list.php');
INSERT INTO `Form` VALUES('modificaDati', 'post', 'I tuoi dati sono stati modificati!', 'Non è stato possibile nodificare i tuoi dati. Riprova più tardi.', 'modificaUtente', 'profilo.php');
INSERT INTO `Form` VALUES('modificaMail', 'post', 'Mail modificata!', 'Impossibile modificare la mail, riprovare più tardi', 'modificaMail', 'profilo.php');
INSERT INTO `Form` VALUES('modificaPassword', 'post', 'Password cambiata!', 'Errore nella modifica della password. Riprova più tardi', 'modificaPassword', 'profilo.php');
INSERT INTO `Form` VALUES('registrazione', 'post', 'Operazione eseguita!', 'Errore nella registrazione, prova più tardi.', 'registraUtente', 'index.php');

-- --------------------------------------------------------

--
-- Struttura della tabella `Fumetti`
--

CREATE TABLE IF NOT EXISTS `Fumetti` (
  `idVolume` int(11) NOT NULL AUTO_INCREMENT,
  `idSerie` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `volume` int(11) NOT NULL,
  `dataUscita` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idVolume`),
  KEY `idSerie` (`idSerie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dump dei dati per la tabella `Fumetti`
--

INSERT INTO `Fumetti` VALUES(8, 1, 'L''alba dei morti viventi', 1, '2012-01-16 23:13:58');
INSERT INTO `Fumetti` VALUES(9, 1, 'Vivono tra noi', 13, '2012-01-16 23:14:40');
INSERT INTO `Fumetti` VALUES(10, 1, 'La iena', 42, '2012-01-16 23:17:02');
INSERT INTO `Fumetti` VALUES(11, 1, 'La storia di Dylan Dog', 100, '2012-01-16 23:17:37');
INSERT INTO `Fumetti` VALUES(12, 10, '', 45, '2012-01-31 16:42:39');
INSERT INTO `Fumetti` VALUES(14, 10, '', 52, '2012-01-31 16:46:49');
INSERT INTO `Fumetti` VALUES(15, 10, '', 50, '2012-01-31 16:47:26');
INSERT INTO `Fumetti` VALUES(16, 10, '', 1, '2012-01-31 16:47:47');
INSERT INTO `Fumetti` VALUES(17, 10, '', 5, '2012-01-31 16:48:02');
INSERT INTO `Fumetti` VALUES(18, 10, '', 10, '2012-01-31 16:48:43');
INSERT INTO `Fumetti` VALUES(19, 10, '', 47, '2012-01-31 16:48:59');
INSERT INTO `Fumetti` VALUES(20, 10, '', 54, '2012-01-31 16:49:12');
INSERT INTO `Fumetti` VALUES(21, 10, '', 3, '2012-01-31 17:49:03');
INSERT INTO `Fumetti` VALUES(22, 10, '', 4, '2012-01-31 17:49:14');

-- --------------------------------------------------------

--
-- Struttura della tabella `Fumetti2`
--

CREATE TABLE IF NOT EXISTS `Fumetti2` (
  `idVolume` int(11) NOT NULL AUTO_INCREMENT,
  `idSerie` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `volume` int(11) NOT NULL,
  `edizione` varchar(30) NOT NULL,
  `copertina` varchar(100) NOT NULL,
  `dataUscita` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idVolume`),
  KEY `idSerie` (`idSerie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `Fumetti2`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `Legge`
--

CREATE TABLE IF NOT EXISTS `Legge` (
  `utente` varchar(30) NOT NULL,
  `fumetto` int(11) NOT NULL,
  `letto` enum('si','no') NOT NULL DEFAULT 'no',
  `dataLettura` timestamp NULL DEFAULT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`utente`,`fumetto`),
  KEY `fumetto` (`fumetto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Legge`
--

INSERT INTO `Legge` VALUES('andre', 10, '', NULL, '0000-00-00 00:00:00');
INSERT INTO `Legge` VALUES('dshinigami', 8, '', NULL, '0000-00-00 00:00:00');
INSERT INTO `Legge` VALUES('dshinigami', 10, '', NULL, '0000-00-00 00:00:00');
INSERT INTO `Legge` VALUES('io', 8, 'si', '2012-02-01 16:09:57', '2012-02-01 16:09:45');
INSERT INTO `Legge` VALUES('io', 9, 'si', '2012-02-01 21:31:22', '2012-02-01 16:09:46');
INSERT INTO `Legge` VALUES('io', 10, 'si', '2012-02-01 21:31:37', '2012-02-01 18:05:46');

-- --------------------------------------------------------

--
-- Struttura della tabella `Menu`
--

CREATE TABLE IF NOT EXISTS `Menu` (
  `nome` varchar(30) NOT NULL,
  `nomeStile` varchar(30) NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Menu`
--

INSERT INTO `Menu` VALUES('Contolli fumetto', 'controlliFumetto');
INSERT INTO `Menu` VALUES('Controlli fumetti', 'controlliFumetti');
INSERT INTO `Menu` VALUES('Controlli serie', 'controlliSerie');
INSERT INTO `Menu` VALUES('Controlli Utente', 'user_control');
INSERT INTO `Menu` VALUES('Menu', 'navigation');
INSERT INTO `Menu` VALUES('pagine', 'null');

-- --------------------------------------------------------

--
-- Struttura della tabella `Pagine`
--

CREATE TABLE IF NOT EXISTS `Pagine` (
  `posizione` int(10) unsigned NOT NULL,
  `menu` varchar(30) NOT NULL DEFAULT '',
  `nome` varchar(30) NOT NULL,
  `link` varchar(100) NOT NULL,
  `titolo` varchar(50) NOT NULL,
  `permessi` set('guest','administrator','manager') NOT NULL DEFAULT 'guest,administrator,manager',
  PRIMARY KEY (`posizione`,`menu`),
  KEY `menu` (`menu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Pagine`
--

INSERT INTO `Pagine` VALUES(0, 'Controlli Utente', 'printUser', 'profilo.php', 'USER', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(0, 'Menu', 'Amici', 'amici.php', 'Lista amici', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(0, 'pagine', 'Elimina utente', 'elimina_utente.php', '', 'administrator');
INSERT INTO `Pagine` VALUES(1, 'Controlli fumetti', 'nuovoFumettoButton', 'aggiungiFumetto.php', 'Nuovo fumetto', 'administrator,manager');
INSERT INTO `Pagine` VALUES(1, 'Controlli Utente', 'Lista', 'lista.php', 'I miei fumetti', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(2, 'Controlli Utente', 'Esplora', 'list.php', 'Elenco Serie', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(3, 'Controlli Utente', 'Aggiungi', 'aggiungi.php', 'Nuovo fumetto', 'administrator,manager');
INSERT INTO `Pagine` VALUES(4, 'Controlli Utente', 'Cerca', 'cerca.php', 'Cerca', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(6, 'Controlli Utente', 'Gestione utenti', 'utenti.php', 'Utenti', 'administrator');
INSERT INTO `Pagine` VALUES(7, 'Controlli serie', 'nuovaSerieButton', 'aggiungiSerie.php', 'Nuova serie', 'administrator,manager');
INSERT INTO `Pagine` VALUES(20, 'Controlli Utente', 'Esci', 'logout.php', '', 'guest,administrator,manager');

-- --------------------------------------------------------

--
-- Struttura della tabella `Possiede`
--

CREATE TABLE IF NOT EXISTS `Possiede` (
  `idVolume` int(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `letto` enum('true','false') NOT NULL DEFAULT 'false',
  `aggiuntoIl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idVolume`,`username`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Possiede`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `Serie`
--

CREATE TABLE IF NOT EXISTS `Serie` (
  `idSerie` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `inCorso` enum('true','false') NOT NULL,
  PRIMARY KEY (`idSerie`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dump dei dati per la tabella `Serie`
--

INSERT INTO `Serie` VALUES(1, 'Dylan Dog', 'true');
INSERT INTO `Serie` VALUES(10, 'Naruto', 'true');
INSERT INTO `Serie` VALUES(15, 'Deathnote', 'false');
INSERT INTO `Serie` VALUES(21, 'Bobobo-bo Bo-bobo', 'false');

-- --------------------------------------------------------

--
-- Struttura della tabella `Serie2`
--

CREATE TABLE IF NOT EXISTS `Serie2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `immagine` varchar(100) NOT NULL COMMENT 'Path dell'' immagine',
  `inCorso` enum('true','false') NOT NULL,
  `volumi` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dump dei dati per la tabella `Serie2`
--


-- --------------------------------------------------------

--
-- Struttura della tabella `Utenti`
--

CREATE TABLE IF NOT EXISTS `Utenti` (
  `username` varchar(30) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `luogo` varchar(50) DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL,
  `banned` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `privilegi` enum('guest','administrator','manager') NOT NULL DEFAULT 'guest',
  `attivo` enum('true','false') NOT NULL DEFAULT 'false',
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `privilegi` (`privilegi`),
  KEY `luogo` (`luogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Utenti`
--

INSERT INTO `Utenti` VALUES('andre', 'jlj', 'lkj', 'and.xet@andail.com', 'pp', NULL, '2012-01-15 15:39:39', 'guest', 'true', '7f94dd413148ff9ac9e9e4b6ff2b6ca9');
INSERT INTO `Utenti` VALUES('andrea', 'Andrea', 'Peretti', 'and.xet@gmail.com', 'Roasio', NULL, '2010-02-12 17:58:34', 'administrator', 'true', '1f59281654802634091309326ecc9166');
INSERT INTO `Utenti` VALUES('dshinigami', 'Andrea', 'Peretti', 'io@me.commm', 'Roasio', NULL, '2010-01-12 17:42:19', 'administrator', 'true', '1f59281654802634091309326ecc9166');
INSERT INTO `Utenti` VALUES('io', 'io', 'me', 'io@mee.com', 'Timbuktu', NULL, '2010-02-12 19:13:30', 'administrator', 'true', '6e6bc4e49dd477ebc98ef4046c067b5f');
INSERT INTO `Utenti` VALUES('iol', 'io', 'me', 'and.xet@gmail.coml', 'tu', NULL, '2010-02-12 17:58:45', 'guest', 'true', 'cfcd208495d565ef66e7dff9f98764da');
INSERT INTO `Utenti` VALUES('mango', 'Iooooo', 'tuoo', 'mango@signore.deimanghi', 'oo', NULL, '2010-02-12 17:58:29', 'guest', 'true', 'aa00faf97d042c13a59da4d27eb32358');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Amicizie`
--
ALTER TABLE `Amicizie`
  ADD CONSTRAINT `Amicizie_ibfk_1` FOREIGN KEY (`utente1`) REFERENCES `Utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Amicizie_ibfk_2` FOREIGN KEY (`utente2`) REFERENCES `Utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Campi`
--
ALTER TABLE `Campi`
  ADD CONSTRAINT `Campi_ibfk_1` FOREIGN KEY (`nomeForm`) REFERENCES `Form` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Commenti`
--
ALTER TABLE `Commenti`
  ADD CONSTRAINT `Commenti_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `Serie2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Commenti_ibfk_2` FOREIGN KEY (`idVolume`) REFERENCES `Fumetti2` (`idVolume`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Fumetti`
--
ALTER TABLE `Fumetti`
  ADD CONSTRAINT `Fumetti_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `Serie` (`idSerie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Fumetti2`
--
ALTER TABLE `Fumetti2`
  ADD CONSTRAINT `Fumetti2_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `Serie2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Legge`
--
ALTER TABLE `Legge`
  ADD CONSTRAINT `Legge_ibfk_1` FOREIGN KEY (`utente`) REFERENCES `Utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Legge_ibfk_2` FOREIGN KEY (`fumetto`) REFERENCES `Fumetti` (`idVolume`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Pagine`
--
ALTER TABLE `Pagine`
  ADD CONSTRAINT `Pagine_ibfk_1` FOREIGN KEY (`menu`) REFERENCES `Menu` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Possiede`
--
ALTER TABLE `Possiede`
  ADD CONSTRAINT `Possiede_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Possiede_ibfk_2` FOREIGN KEY (`idVolume`) REFERENCES `Fumetti2` (`idVolume`) ON DELETE CASCADE ON UPDATE CASCADE;
