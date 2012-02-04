var ordini = new Array(
{text:"Nome/username", value:"nome", indicatore:"tutto"},

{text:"Nome", value:"nome", indicatore:"fumetti"},
{text:"Volume", value:"volume", indicatore:"fumetti"},
{text:"Data uscita", value:"dataUscita", indicatore:"fumetti"},
{text:"Serie", value:"idSerie", indicatore:"fumetti"},

{text:"Nome", value:"nome", indicatore:"serie"},
{text:"In corso", value:"inCorso", indicatore:"serie"},

{text:"Username", value:"username", indicatore:"utenti"},
{text:"Nome", value:"nome", indicatore:"utenti"},
{text:"Cognome", value:"cognome", indicatore:"utenti"},
{text:"Luogo", value:"luogo", indicatore:"utenti"}
);

function aggiornaOrdine(dove, valore) {
 var i=0;
 for (j=0; j<ordini.length; j++)
  if (ordini[j].indicatore==valore) {
   dove.options[i]=new Option(ordini[j].text, ordini[j].value);
   i++
  }
 dove.options.length=i;  
}