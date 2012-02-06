Andrea Peretti st718024 Esercizio04 per TWEB 2011/2012

FumeZZi è un sito in cui gli utenti possono mantenere una lista dei loro fumetti e trovare amici con cui scambiarli.

- Il file 'install/db.sql' contiene il dump del database creato con phpMyAdmin.
- Le configurazioni del sito e del database sono nel file script/config.php

Per verificare i permessi degli utenti
Nel sito sono stati definiti 3 tipi di utenti:
- Guest (utente registrato)
- Manager (Utente registrato con il potere di aggiungere serie e fumetti)
- Administrator (Utente con il potere dei manager e di eliminare o bannare utenti)

Per provare le varie tipologie basta effettueare l'accesso con username e password uguale al grado che si desidera. Ad esempio per provare le funzionalità di un Manager, entrare con user: manager e password: manager.

Due utenti si possono ritenere amici quando nella tabella "Richieste" è presente un record di richieste di entrambi gli utenti verso l'altro utente. Questo per implementare le richieste ed i rifiuti di una amicizia.
La conseguenza di un'amicizia è la possibilità di scambiarsi i messaggi e di vedere le rispettive liste dei fumetti.

Il sito è autoinstallante, in mancanza del file dbconf.php reindirizza alla pagina di installazione install/index.php