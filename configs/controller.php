<?php

$controllerDirectory = PATH_APPLICATION.'controller';
$arryItem = directoryToArray($controllerDirectory, false);

foreach($arryItem as $item) {
	
	$arr = explode('/',$item);
	$itemLastest = $arr[count($arr)-1];
	$character = substr($itemLastest, -14);
	if(strtolower($character) === 'controller.php') {
		include_once ($item);
	}
}

function directoryToArray($directory, $recursive) {
    $array_items = array();
    if ($handle = opendir($directory)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (is_dir($directory. "/" . $file)) {
                    if($recursive) {
                        $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
                    }
                    $file = $directory . "/" . $file;
                    $array_items[] = preg_replace("/\/\//si", "/", $file);
                } else {
                    $file = $directory . "/" . $file;
                    $array_items[] = preg_replace("/\/\//si", "/", $file);
                }
            }
        }
        closedir($handle);
    }
    return $array_items;
}