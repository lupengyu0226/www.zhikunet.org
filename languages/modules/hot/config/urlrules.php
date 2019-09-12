<?php
return array (
  "init" => 
	  array (
		'app' => '/^hot$/i',
		'controller' => '/^index$/i',
		'view' => '/^init$/i',
		'page' => '/^\d+$/',
	  ),
  "show" => 
	  array (
		'app' => '/^hot$/i',
		'controller' => '/^index$/i',
		'view' => '/^show$/i',
		'tag' => '/^\.*/',
		'page' => '/^\d+$/',
	  )
);
?>