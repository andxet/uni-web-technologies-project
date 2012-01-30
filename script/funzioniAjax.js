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
	xhrObj.onreadystatechange = function() { updatePage(bottone); };
	xhrObj.send(null);
}

function updatePage(bottone) {
	if (xhrObj.readyState == 4) {
		var risp = xhrObj.responseText;
		if (risp == "successo")
			//document.getElementById(bottone).innerHTML = '<img src="images/defaults/baffo.png" />';
			bottone.src="images/defaults/baffo.png"
		else
			//document.getElementById(bottone).innerHTML = 'errore';
			bottone.parentNode.innerHTML = risp;
	}
}