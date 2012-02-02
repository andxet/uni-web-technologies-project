Andrea Peretti st718024 Esercizio04 per TWEB 2011/2012

- Il file 'install/db.sql' contiene il dump del database creato con phpMyAdmin.
- Il file 'dati.sql' contiene i dati utili per provare le funzionalità del sito.
- Le configurazioni del sito e del database sono nel file script/config.php

Per verificare i permessi degli utenti
Nel sito sono stati definiti 3 tipi di utenti:
- Guest (utente registrato)
- Manager (Utente registrato con il potere di aggiungere serie e fumetti)
- Administrator (Utente con il potere dei manager e di eliminare o bannare utenti)

Per provare le varie tipologie basta effettueare l'accesso con username e password uguale al grado che si desidera. Ad esempio per provare le funzionalità di un Manager, entrare con user: manager e password: manager.

Il sito non è autoinstallante, occorre creare il database ed inserire i dati traminte 'database.sql' affinchè funzioni.