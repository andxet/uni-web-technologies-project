function mostraMenu( menu ){
	
	if(menu.children[1].style.display=="none" || menu.children[1].style.display==""){//nascosto
		menu.children[0].firstChild.src="images/frecciag.png";
		menu.children[1].style.display="block";
		}
	else{//visualizzato
		menu.children[0].firstChild.src = "images/frecciad.png";
		menu.children[1].style.display="none";
		}
}