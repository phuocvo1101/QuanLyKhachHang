<?php
include_once (PATH_LIBRARY.'Smarty/libs/Smarty.class.php');
global $template;
$template = new Smarty();
$template->template_dir = PATH_APPLICATION.'view/templates';
$template->compile_dir = PATH_CACHE.'templates_c';
$template->config_dir = PATH_CONFIG;
$template->cache_dir = PATH_CACHE;