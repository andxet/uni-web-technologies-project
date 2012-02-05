-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generato il: 05 feb, 2012 at 11:24 PM
-- Versione MySQL: 5.5.9
-- Versione PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `fumezzi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Campi`
--

CREATE TABLE `Campi` (
  `nomeForm` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posizione` int(11) NOT NULL,
  `tipo` enum('text','password','confermaPass','legend','submit','reset','login','file','checkbox','int','hidden','select') NOT NULL,
  `nome` varchar(30) NOT NULL,
  `descrizione` varchar(50) DEFAULT NULL COMMENT 'Cosa verrà visualizzato nel form',
  `valore` varchar(50) DEFAULT NULL COMMENT 'verrà inserito nel campo "value"',
  `setPrecedente` enum('y','n') NOT NULL DEFAULT 'n' COMMENT 'se il tipo è "legend" indica se lasciare aperto il precedente textfield o no.',
  `richiesto` enum('y','n') NOT NULL DEFAULT 'n',
  `aCapo` enum('y','n') NOT NULL DEFAULT 'y',
  `customFunction` varchar(30) DEFAULT NULL,
  `controlli` set('isLong1','isLong4','isLong8','notHasProhibitedChars') DEFAULT 'isLong4,notHasProhibitedChars',
  PRIMARY KEY (`id`),
  KEY `nomeForm` (`nomeForm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dump dei dati per la tabella `Campi`
--

INSERT INTO `Campi` VALUES('registrazione', 1, 0, 'legend', 'Informazioni account', NULL, NULL, 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('registrazione', 2, 1, 'text', 'username', 'Username', NULL, 'y', 'y', 'y', 'controlloUser', 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 3, 2, 'confermaPass', 'password', 'Password', NULL, 'n', 'y', 'y', 'confermaPass', 'isLong1');
INSERT INTO `Campi` VALUES('registrazione', 4, 4, 'legend', 'Informazioni personali', NULL, NULL, 'n', 'y', 'y', NULL, '');
INSERT INTO `Campi` VALUES('registrazione', 5, 5, 'text', 'nome', 'Nome', NULL, 'y', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 6, 6, 'text', 'cognome', 'Cognome', NULL, 'y', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 7, 7, 'text', 'luogo', 'Dove abiti?', NULL, 'y', 'n', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 8, 9, 'submit', 'invia', 'Registrati!', 'Registrati!', 'n', 'n', 'n', NULL, NULL);
INSERT INTO `Campi` VALUES('registrazione', 9, 10, 'reset', 'reset', 'Ripristina campi', 'Ripristina campi', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('registrazione', 10, 3, 'text', 'email', 'eMail', NULL, 'y', 'y', 'y', 'controlloEmail', 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('registrazione', 11, 8, 'legend', '', NULL, NULL, 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaDati', 12, 0, 'legend', 'Informazioni personali', NULL, NULL, 'n', 'y', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 14, 1, 'text', 'nome', 'Nome', 'userName', 'n', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 15, 2, 'text', 'cognome', 'Cognome', 'userCognome', 'n', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 16, 3, 'text', 'luogo', 'Dove ti trovi adesso?', 'userPlace', 'n', 'n', 'y', NULL, 'notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 17, 6, 'submit', 'invia', 'Modifica', 'Modifica', 'n', 'n', 'n', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 18, 7, 'reset', 'reset', 'Ripristina campi', 'Ripristina campi', 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaDati', 19, 5, 'legend', '', NULL, NULL, 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaPassword', 20, 0, 'legend', 'Modifica password', NULL, NULL, 'n', 'y', 'y', NULL, 'isLong4');
INSERT INTO `Campi` VALUES('modificaPassword', 22, 1, 'password', 'passOld', 'Vecchia password', NULL, 'n', 'y', 'y', 'controlloLogin', 'isLong1');
INSERT INTO `Campi` VALUES('modificaPassword', 24, 3, 'confermaPass', 'password', 'Nuova password', NULL, 'n', 'y', 'y', 'confermaPass', 'isLong1');
INSERT INTO `Campi` VALUES('modificaPassword', 25, 4, 'legend', '', NULL, NULL, 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaPassword', 26, 5, 'submit', 'invia', 'Modifica', 'Modifica', 'n', 'n', 'y', NULL, 'isLong4,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaMail', 27, 0, 'legend', 'Modifica e-mail', NULL, NULL, 'n', 'y', 'y', NULL, 'isLong1');
INSERT INTO `Campi` VALUES('modificaMail', 28, 1, 'text', 'email', 'Nuova e-mail', 'userMail', 'n', 'y', 'y', 'controlloEmail', 'notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaMail', 29, 2, 'submit', 'invia', 'Modifica', 'Modifica', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 30, 0, 'legend', 'Dati serie', 'Dati serie', 'Dati serie', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 31, 1, 'text', 'nome', 'Nome', NULL, 'y', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('inserisciSerie', 32, 2, 'file', 'nomefile', 'Immagine', NULL, 'y', 'n', 'y', 'fileIsSet', NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 33, 3, 'checkbox', 'inCorso', 'La serie &egrave; in corso', 'true', 'y', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciSerie', 34, 4, 'submit', 'invia', 'Aggiungi', 'Aggiungi', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 35, 0, 'legend', 'Dati fumetto', 'Dati fumetto', 'Dati fumetto', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 36, 1, 'text', 'nome', 'Nome o titolo', NULL, 'y', 'n', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('inserisciFumetto', 37, 2, 'file', 'nomefile', 'Copertina', NULL, 'y', 'n', 'y', 'fileIsSet', NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 38, 4, 'int', 'volume', 'Numero del volume', NULL, 'y', 'y', 'y', 'controlloVolume', NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 39, 5, 'submit', 'invia', 'Aggiungi', 'Aggiungi', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('inserisciFumetto', 40, 6, 'hidden', 'serie', NULL, 'getSerieIndex', 'y', 'y', 'n', NULL, NULL);
INSERT INTO `Campi` VALUES('cerca', 41, 0, 'text', 'parolaChiave', 'Parola chiave', NULL, 'y', 'y', 'n', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('cerca', 42, 5, 'submit', 'invia', 'Cerca', 'Cerca', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaDati', 43, 4, 'file', 'nomefile', 'Avatar', NULL, 'y', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('cerca', 44, 2, 'select', 'cosa', 'Cosa', 'getCosaCercare', 'n', 'y', 'n', NULL, NULL);
INSERT INTO `Campi` VALUES('cerca', 45, 3, 'select', 'ordine', 'Ordina per', 'getComeOrdinare', 'n', 'y', 'n', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaFumetto', 46, 0, 'legend', 'Dati fumetto', 'Dati fumetto', 'Dati fumetto', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaFumetto', 47, 1, 'text', 'nome', 'Nome o titolo', 'valFumettoNome', 'n', 'n', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaFumetto', 48, 2, 'file', 'nomefile', 'Copertina', NULL, 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaFumetto', 49, 4, 'int', 'volume', 'Numero del volume', 'valFumettoNum', 'n', 'y', 'y', 'controlloVolume', NULL);
INSERT INTO `Campi` VALUES('modificaFumetto', 50, 7, 'submit', 'invia', 'Modifica', 'Modifica', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaSerie', 52, 0, 'legend', 'Dati serie', 'Dati serie', 'Dati serie', 'n', 'y', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaSerie', 53, 1, 'text', 'nome', 'Nome', 'getNomeSerie', 'n', 'y', 'y', NULL, 'isLong1,notHasProhibitedChars');
INSERT INTO `Campi` VALUES('modificaSerie', 54, 2, 'file', 'nomefile', 'Immagine', NULL, 'y', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaSerie', 55, 3, 'checkbox', 'inCorso', 'La serie &egrave; in corso', 'true', 'y', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaSerie', 56, 6, 'submit', 'invia', 'Modifica', 'Modifica', 'n', 'n', 'y', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaFumetto', 57, 6, 'hidden', 'idVolume', NULL, 'setIdVolumeGet', 'n', 'y', 'n', NULL, NULL);
INSERT INTO `Campi` VALUES('modificaSerie', 58, 4, 'hidden', 'idSerie', NULL, 'setSerieGet', 'n', 'n', 'n', NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `Form`
--

CREATE TABLE `Form` (
  `nome` varchar(50) NOT NULL DEFAULT 'modulo',
  `metodo` enum('get','post') NOT NULL DEFAULT 'post',
  `successo` varchar(100) NOT NULL DEFAULT 'Operazione eseguita!' COMMENT 'Messaggio da visualizzare in caso di modifica avvenuta',
  `fallimento` varchar(100) NOT NULL,
  `funzioneForm` varchar(50) DEFAULT NULL COMMENT 'Funzione che verrà eseguita se i controlli saranno superati',
  `reindirizzamento` varchar(50) DEFAULT NULL COMMENT 'Pagina a cui si viene reindirizzati in caso di successo (null per non essere reindirizzati)',
  `controlloJS` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Form`
--

INSERT INTO `Form` VALUES('cerca', 'post', 'Ricerca effettuata', 'Errore nella ricerca', 'cercaCose', NULL, NULL);
INSERT INTO `Form` VALUES('inserisciFumetto', 'post', 'Fumetto aggiunto!', 'C''&egrave; stato un problema nell''aggiungere il fumetto.', 'aggiungiFumetto', 'list.php', NULL);
INSERT INTO `Form` VALUES('inserisciSerie', 'post', 'Serie aggiunta!', 'C''&egrave; stato un problema nell''aggiungere la serie.', 'aggiungiSerie', 'list.php', NULL);
INSERT INTO `Form` VALUES('modificaDati', 'post', 'I tuoi dati sono stati modificati!', 'Non è stato possibile nodificare i tuoi dati. Riprova più tardi.', 'modificaUtente', 'profilo.php', 'controlloDati');
INSERT INTO `Form` VALUES('modificaFumetto', 'post', 'Operazione eseguita!', '', 'modificaFumetto', 'list.php', NULL);
INSERT INTO `Form` VALUES('modificaMail', 'post', 'Mail modificata!', 'Impossibile modificare la mail, riprovare più tardi', 'modificaMail', 'profilo.php', 'controlloMail');
INSERT INTO `Form` VALUES('modificaPassword', 'post', 'Password cambiata!', 'Errore nella modifica della password. Riprova più tardi', 'modificaPassword', 'profilo.php', 'controlloPassword');
INSERT INTO `Form` VALUES('modificaSerie', 'post', 'Operazione eseguita!', '', 'modificaSerie', 'list.php', NULL);
INSERT INTO `Form` VALUES('registrazione', 'post', 'Operazione eseguita!', 'Errore nella registrazione, prova più tardi.', 'registraUtente', 'index.php', 'controlloRegistrazione');

-- --------------------------------------------------------

--
-- Struttura della tabella `Fumetti`
--

CREATE TABLE `Fumetti` (
  `idVolume` int(11) NOT NULL AUTO_INCREMENT,
  `idSerie` int(11) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `volume` int(11) NOT NULL,
  `dataUscita` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idVolume`),
  KEY `idSerie` (`idSerie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

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
-- Struttura della tabella `Legge`
--

CREATE TABLE `Legge` (
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

INSERT INTO `Legge` VALUES('a', 10, '', NULL, '0000-00-00 00:00:00');
INSERT INTO `Legge` VALUES('b', 8, 'no', NULL, '2012-02-03 02:07:28');
INSERT INTO `Legge` VALUES('b', 9, 'si', '2012-02-03 02:16:23', '2012-02-03 02:07:32');
INSERT INTO `Legge` VALUES('b', 11, 'no', NULL, '2012-02-03 02:07:31');
INSERT INTO `Legge` VALUES('c', 8, '', NULL, '0000-00-00 00:00:00');
INSERT INTO `Legge` VALUES('c', 10, '', NULL, '0000-00-00 00:00:00');
INSERT INTO `Legge` VALUES('io', 8, 'no', NULL, '2012-02-05 17:44:17');
INSERT INTO `Legge` VALUES('io', 9, 'si', '2012-02-02 00:23:13', '2012-02-01 16:09:46');
INSERT INTO `Legge` VALUES('io', 11, 'si', '2012-02-03 18:52:49', '2012-02-02 00:23:24');
INSERT INTO `Legge` VALUES('io', 12, 'no', NULL, '2012-02-03 18:02:40');
INSERT INTO `Legge` VALUES('io', 17, 'no', NULL, '2012-02-02 16:51:38');
INSERT INTO `Legge` VALUES('io', 18, 'no', NULL, '2012-02-02 16:51:39');
INSERT INTO `Legge` VALUES('io', 20, 'no', NULL, '2012-02-02 16:51:47');
INSERT INTO `Legge` VALUES('io', 21, 'no', NULL, '2012-02-02 16:51:36');
INSERT INTO `Legge` VALUES('io', 22, 'no', NULL, '2012-02-02 16:51:48');

-- --------------------------------------------------------

--
-- Struttura della tabella `Menu`
--

CREATE TABLE `Menu` (
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

CREATE TABLE `Pagine` (
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

INSERT INTO `Pagine` VALUES(0, 'Menu', 'getRichiesteAmici', 'amici.php', 'Lista amici', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(0, 'pagine', 'Elimina utente', 'elimina_utente.php', '', 'administrator');
INSERT INTO `Pagine` VALUES(1, 'Controlli fumetti', 'nuovoFumettoButton', 'aggiungiFumetto.php', 'Nuovo fumetto', 'administrator,manager');
INSERT INTO `Pagine` VALUES(1, 'Menu', 'Lista', 'lista.php', 'I miei fumetti', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(1, 'pagine', 'Profili', 'profilo.php', 'getProfiloName', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(2, 'Controlli Utente', 'Esplora', 'list.php', 'Elenco Serie', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(3, 'Controlli Utente', 'Aggiungi', 'aggiungi.php', 'Nuovo fumetto', 'administrator,manager');
INSERT INTO `Pagine` VALUES(4, 'Controlli Utente', 'Cerca', 'cerca.php', 'Cerca', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(6, 'Menu', 'Gestione utenti', 'utenti.php', 'Utenti', 'administrator');
INSERT INTO `Pagine` VALUES(7, 'Controlli serie', 'nuovaSerieButton', 'aggiungiSerie.php', 'Nuova serie', 'administrator,manager');
INSERT INTO `Pagine` VALUES(19, 'Controlli Utente', 'printUser', 'impostazioni.php', 'Impostazioni', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(20, 'Controlli Utente', 'Esci', 'logout.php', '', 'guest,administrator,manager');
INSERT INTO `Pagine` VALUES(102, 'pagine', 'Elimina fumetto', 'eliminaFumetto.php', 'Elimina fumetto', 'administrator,manager');
INSERT INTO `Pagine` VALUES(103, 'pagine', 'Elimina serie', 'eliminaSerie.php', 'Elimina serie', 'administrator,manager');
INSERT INTO `Pagine` VALUES(104, 'pagine', 'Modifica fumetto', 'modificaFumetto', 'Modifica fumetto', 'administrator,manager');
INSERT INTO `Pagine` VALUES(105, 'pagine', 'Modifica serie', 'modificaSerie', 'Modifica serie', 'administrator,manager');

-- --------------------------------------------------------

--
-- Struttura della tabella `Richieste`
--

CREATE TABLE `Richieste` (
  `richiedente` varchar(30) NOT NULL,
  `amico` varchar(30) NOT NULL,
  `data` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`richiedente`,`amico`),
  KEY `amico` (`amico`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Richieste`
--

INSERT INTO `Richieste` VALUES('a', 'b', '2012-02-03 02:14:26');
INSERT INTO `Richieste` VALUES('b', 'a', '2012-02-03 02:13:59');
INSERT INTO `Richieste` VALUES('b', 'c', '2012-02-03 02:13:49');
INSERT INTO `Richieste` VALUES('b', 'd', '2012-02-03 01:28:12');
INSERT INTO `Richieste` VALUES('b', 'e', '2012-02-03 01:28:12');
INSERT INTO `Richieste` VALUES('b', 'io', '2012-02-03 18:48:30');
INSERT INTO `Richieste` VALUES('c', 'a', '2012-02-03 01:28:12');
INSERT INTO `Richieste` VALUES('d', 'io', '2012-02-03 00:37:40');
INSERT INTO `Richieste` VALUES('e', 'b', '2012-02-03 02:14:26');
INSERT INTO `Richieste` VALUES('e', 'c', '2012-02-03 01:28:12');
INSERT INTO `Richieste` VALUES('io', 'a', '2012-02-04 00:43:36');
INSERT INTO `Richieste` VALUES('io', 'b', '2012-02-03 18:48:42');
INSERT INTO `Richieste` VALUES('io', 'd', '2012-02-03 18:44:27');

-- --------------------------------------------------------

--
-- Struttura della tabella `Serie`
--

CREATE TABLE `Serie` (
  `idSerie` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `inCorso` enum('true','false') NOT NULL,
  PRIMARY KEY (`idSerie`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dump dei dati per la tabella `Serie`
--

INSERT INTO `Serie` VALUES(1, 'Dylan Dog', 'true');
INSERT INTO `Serie` VALUES(10, 'Naruto', 'true');
INSERT INTO `Serie` VALUES(15, 'Deathnote', 'true');
INSERT INTO `Serie` VALUES(21, 'Bobobo-bo Bo-bobo', 'true');

-- --------------------------------------------------------

--
-- Struttura della tabella `Utenti`
--

CREATE TABLE `Utenti` (
  `username` varchar(30) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `luogo` varchar(50) DEFAULT NULL,
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

INSERT INTO `Utenti` VALUES('a', 'jlj', 'lkj', 'and.xet@andail.com', 'pp', '2012-01-15 15:39:39', 'guest', 'true', '0cc175b9c0f1b6a831c399e269772661');
INSERT INTO `Utenti` VALUES('administrator', 'administrator', 'administrator', 'administrator@fumezzi.zz', NULL, '2012-02-04 01:58:59', 'administrator', 'true', '200ceb26807d6bf99fd6f4f0d1ca54d4');
INSERT INTO `Utenti` VALUES('b', 'Andrea', 'Peretti', 'and.xet@gmail.com', 'Roasio', '2010-02-12 17:58:34', 'administrator', 'true', '92eb5ffee6ae2fec3ad71c777531578f');
INSERT INTO `Utenti` VALUES('c', 'Andrea', 'Peretti', 'io@me.commm', 'Roasio', '2010-01-12 17:42:19', 'administrator', 'true', '4a8a08f09d37b73795649038408b5f33');
INSERT INTO `Utenti` VALUES('d', 'io', 'me', 'and.xet@gmail.coml', 'tu', '2010-02-12 17:58:45', 'guest', 'true', '8277e0910d750195b448797616e091ad');
INSERT INTO `Utenti` VALUES('e', 'Iooooo', 'tuoo', 'mango@signore.deimanghi', 'oo', '2010-02-12 17:58:29', 'guest', 'true', 'e1671797c52e15f763380b45e841ec32');
INSERT INTO `Utenti` VALUES('guest', 'guest', 'guest', 'guest@fumezzi.zz', '', '2012-02-02 15:30:44', 'guest', 'true', '084e0343a0486ff05530df6c705c8bb4');
INSERT INTO `Utenti` VALUES('io', 'io', 'meo', 'io@mee.ittt', 'Timbuktu', '2010-02-12 19:13:30', 'administrator', 'true', '6e6bc4e49dd477ebc98ef4046c067b5f');
INSERT INTO `Utenti` VALUES('ioo', 'kk', 'kk', 'aaaa@aaaaa.lo', '', '2012-02-05 22:45:12', 'guest', 'false', '6e6bc4e49dd477ebc98ef4046c067b5f');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Campi`
--
ALTER TABLE `Campi`
  ADD CONSTRAINT `Campi_ibfk_1` FOREIGN KEY (`nomeForm`) REFERENCES `Form` (`nome`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `Fumetti`
--
ALTER TABLE `Fumetti`
  ADD CONSTRAINT `Fumetti_ibfk_1` FOREIGN KEY (`idSerie`) REFERENCES `Serie` (`idSerie`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Limiti per la tabella `Richieste`
--
ALTER TABLE `Richieste`
  ADD CONSTRAINT `Richieste_ibfk_1` FOREIGN KEY (`richiedente`) REFERENCES `Utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Richieste_ibfk_2` FOREIGN KEY (`amico`) REFERENCES `Utenti` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
