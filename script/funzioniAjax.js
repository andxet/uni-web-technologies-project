function setXMLHttpRequest() {
	var xhr = null;
	// browser standard con supporto nativo
	if (window.XMLHttpRequest) {
		xhr = new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xhr;
}

var xhrObj = setXMLHttpRequest();

//Funzioni per aggiungere fumetti alla lista
function aggiungiLista(fumetto, bottone){
	var url = "aggiungiLista.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { updatePage(bottone, fumetto, 1); };
	xhrObj.send(null);
}

function rimuoviLista(fumetto, bottone){
	if(!confirm("Sei sicuro di voler eliminare questo fumetto?"))
		return;
	var url = "rimuoviLista.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { updatePage(bottone, fumetto, 0); };
	xhrObj.send(null);
}

function updatePage(bottone, fumetto, stato) {
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo" && stato == 1){
			bottone.parentNode.innerHTML = '<img src="images/defaults/baffo.png" alt="Rimuovi dalla lista dei fumetti che stai leggendo" onclick="rimuoviLista(\''+fumetto+'\',this);" onmouseover="this.src=\'images/defaults/annulla.png\'" onmouseout="this.src=\'images/defaults/baffo.png\'" />';
			}
		else if(risp == "successo" && stato == 0){
			bottone.parentNode.innerHTML = '<img src="images/defaults/addb.png" alt="Aggiungi alla lista dei fumetti che stai leggendo" onclick="aggiungiLista(\''+fumetto+'\',this);" />';	
			}
		else
			bottone.parentNode.innerHTML = risp;
	}
}

//Funzione usata per rimuovere un fumetto
function rimuoviListaR(fumetto, bottone){
	if(!confirm("Sei sicuro di voler eliminare questo fumetto?"))
		return;
	var url = "rimuoviLista.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { nascondiElemento(bottone); };
	xhrObj.send(null);
}

function nascondiElemento(bottone) {
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo"){
			bottone.parentNode.parentNode.style.display="none";
		}
		else
			bottone.parentNode.innerHTML = risp;
	}
}


//Funzioni per cambiare lo stato di lettura
function dimenticaLettura(img, fumetto){
	if(!confirm("Vuoi annullare la lettura di questo fumetto?"))
		return;
	var url = "dimenticaFumetto.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { dimenticaFumetto(img, fumetto); };
	xhrObj.send(null);	
}


function dimenticaFumetto(img, fumetto){
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo"){
			//div.innerHTML = '<div id="fumetto" onclick="leggi(this, ' + fumetto + ')">';
			img.parentNode.id="fumetto";
			//div.onClick="leggiFumetto(this, "+fumetto+");";
			//div.onClick = 'leggi(this, ' + fumetto + ')';
			img.onclick = function(){ leggi(img, fumetto); };
		}
		else
			bottone.parentNode.innerHTML = risp;
	}
}

function leggi(img, fumetto){
	var url = "leggiFumetto.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { leggiFumetto(img, fumetto); };
	xhrObj.send(null);
}

function leggiFumetto(img, fumetto){
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo"){
			//cambiaSfondoLetto(div);
			//div.innerHTML = '<div id="fumettoLetto" onclick="dimenticaLettura(this, ' + fumetto + ')">';
			img.parentNode.id = "fumettoLetto";
			//div.onClick = function() { dimenticaFumetto(div, fumetto); }
			//div.onClick = 'dimenticaLettura(this, ' + fumetto + ')';
			img.onclick = function() {dimenticaLettura(img, fumetto); };
		}
		else
			bottone.parentNode.innerHTML = risp;
	}
}

//Funzioni per gestire gli amici
function aggiungiAmico(amico, bottone){
	var url = "chiediAmicizia.php?amico=" + amico;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { updatePages(bottone, amico, 1); };
	xhrObj.send(null);
}

function aggiungiAmicoR(amico, bottone){
	var url = "chiediAmicizia.php?amico=" + amico;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { nascondiElemento(bottone); };
	xhrObj.send(null);
}

function rimuoviAmico(amico, bottone){
	if(!confirm("Sei sicuro di voler eliminare "+amico+" dagli amici?"))
		return;
	var url = "eliminaAmicizia.php?amico=" + amico;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { updatePages(bottone, amico, 0); };
	xhrObj.send(null);
}

function rimuoviAmicoR(amico, bottone){
	if(!confirm("Sei sicuro di voler eliminare "+amico+" dagli amici?"))
		return;
	var url = "eliminaAmicizia.php?amico=" + amico;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { nascondiElemento(bottone); };
	xhrObj.send(null);
}

function updatePages(bottone, amico, stato) {
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo" && stato == 1){
			bottone.parentNode.innerHTML = '<img src="images/defaults/baffo.png" alt="Rimuovi dagli amici" onclick="rimuoviAmico(\''+amico+'\',this);" onmouseover="this.src=\'images/defaults/annulla.png\'" onmouseout="this.src=\'images/defaults/baffo.png\'" />';
			}
		else if(risp == "successo" && stato == 0){
			bottone.parentNode.innerHTML = '<img src="images/defaults/addb.png" alt="Aggiungi agli amici!" onclick="aggiungiAmico(\''+amico+'\',this);" />';	
			}
		else
			bottone.parentNode.innerHTML = risp;
	}
}


