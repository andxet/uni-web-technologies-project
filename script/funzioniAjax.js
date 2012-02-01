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

function aggiungiLista(fumetto, bottone){
	var url = "aggiungiLista.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { updatePage(bottone, fumetto, 1); };
	xhrObj.send(null);
}

function rimuoviLista(fumetto, bottone){
	var url = "rimuoviLista.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { updatePage(bottone, fumetto, 0); };
	xhrObj.send(null);
}

function updatePage(bottone, fumetto, stato) {
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo" && stato == 1){
			bottone.parentNode.innerHTML = '<img src="images/defaults/baffo.png" alt="Rimuovi dalla lista dei fumetti che stai leggendo" onclick=rimuoviLista('+fumetto+',this); onmouseover="this.src=\'images/defaults/annulla.png\'" onmouseout="this.src=\'images/defaults/baffo.png\'" />';
			}
		else if(risp == "successo" && stato == 0){
			bottone.parentNode.innerHTML = '<img src="images/defaults/addb.png" alt="Aggiungi alla lista dei fumetti che stai leggendo" onclick="aggiungiLista('+fumetto+',this);" />';	
			}
		else
			bottone.parentNode.innerHTML = risp;
	}
}

function rimuoviListaR(fumetto, bottone){
	var url = "rimuoviLista.php?fumetto=" + fumetto;
	xhrObj.open("GET", url, true);
	xhrObj.onreadystatechange = function() { nascondiFumetto(bottone); };
	xhrObj.send(null);
}

function nascondiFumetto(bottone) {
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo"){
			bottone.parentNode.parentNode.style.display="none";
		}
		else
			bottone.parentNode.innerHTML = risp;
	}
}
