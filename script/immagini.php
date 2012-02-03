<?php 

function salvaImmagine($path){
	require_once("config.php");
	require_once("funzioni.php");
	//print_r($_FILES);
	if (!isset($_FILES["nomefile"]))
		die("File non ricevuto\n");
	$tmp_nome = $_FILES["nomefile"]["tmp_name"];
	$tipo = $_FILES["nomefile"]["type"];
	$nome = $_FILES["nomefile"]["name"];
  	if (!controllaTipoImg($tipo)) die("File di tipo sconosciuto\n");
  	if(!file_exists(dirname($path)))
  		mkdir(dirname($path));
  	if (move_uploaded_file($tmp_nome, $path))
 		return true;
	else
		return false;
}

function controllaFormatoImg($nomefile) {
	require_once("config.php");
	global $formati_immagine;
	foreach ($formati_immagine as $formato)
    if (strrpos($nomefile, $formato))
		return TRUE;
	return FALSE; // nessun formato trovato
}

function controllaTipoImg($tipo) {
	require_once("config.php");
	global $estensioni_immagini;
	global $tipi_immagine;
	foreach ($tipi_immagine as $formato)
	if (strpos($tipo, $formato)===0)
		return TRUE;
	return FALSE; // nessun tipo trovato
}

function uploadSerieImg($nomeSerie){
	require_once("config.php");
	global $estensioni_immagini;
	
	$nomeImg = "Serie_".$nomeSerie.$estensioni_immagini[$_FILES["nomefile"]["type"]];
	
	if(salvaImmagine(ORIGINAL_PATH.$nomeImg))
		if(creaMiniatura(ORIGINAL_PATH, $nomeImg, SERIE_PATH, 701, 175)){
			if(!SAVE_UPLOAD_ORIGINALS)
				unlink(ORIGINAL_PATH.$originale);
			return true;
			}
	return false;
}

function uploadFumettoImg($nomeFumetto){
	require_once("config.php");
	global $estensioni_immagini;
	
	$nomeImg = "Fumetto_".$nomeFumetto.$estensioni_immagini[$_FILES["nomefile"]["type"]];
	
	if(salvaImmagine(ORIGINAL_PATH.$nomeImg))
		if(creaMiniatura(ORIGINAL_PATH, $nomeImg, FUMETTI_PATH, 120, 180)){
			if(!SAVE_UPLOAD_ORIGINALS)
				unlink(ORIGINAL_PATH.$originale);
			return true;
			}
	return false;
}

function uploadAvatarImg($avatar){
	require_once("config.php");
	global $estensioni_immagini;
	
	$nomeImg = "Avatar_".$avatar.$estensioni_immagini[$_FILES["nomefile"]["type"]];
	
	if(salvaImmagine(ORIGINAL_PATH.$nomeImg))
		if(creaMiniatura(ORIGINAL_PATH, $nomeImg, AVATAR_PATH, 80, 80)){
			if(!SAVE_UPLOAD_ORIGINALS)
				unlink(ORIGINAL_PATH.$originale);
			return true;
			}
	return false;
}


function creaMiniatura($percorsoImmagine, $immagine, $savePath, $width, $height){
	require_once('config.php');
	$img = $percorsoImmagine.$immagine;
	$info = pathinfo($img);
	$dest = $savePath.$info['filename'].".jpg"; // directory di salvataggio delle miniature create 
	if(!file_exists($img)){
		echo "Immagine non esistente…";
		return;}
	
	$thumbComp = 80; 
	
	// creazione dell'immagine della miniatura 
	$thumb = imagecreatetruecolor($width, $height) or die("Impossibile creare la miniatura"); 
	// apertura dell'immagine originale 
	if(!file_exists($savePath)){
			//echo "creo cartella";
	  		mkdir($savePath);}
	switch($info['extension']){
		case 'jpg':
		case '.jpg':
			$src = imagecreatefromjpeg($img) or die ("Impossibile aprire l'immagine originale"); 
			break;
		case 'png':
		case '.png':
			$src = imagecreatefrompng($img) or die ("Impossibile aprire l'immagine originale"); 
			break;
		case 'gif':
		case '.gif':
			$src = imagecreatefromgif($img) or die ("Impossibile aprire l'immagine originale");
			break;
	}
	// copio l'immagine originale in quella della miniatura ridimensionandola 
	imagecopyresized($thumb, $src, 0, 0, 0, 0, $width, $height, imageSx($src), imageSy($src)) or die("Impossibile ridimensionare l'immagine");
	imagejpeg($thumb, $dest, $thumbComp) or die("Impossibile salvare la miniatura"); 		
	return true;
}

?>