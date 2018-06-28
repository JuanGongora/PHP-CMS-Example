<?php

/**
 * Initialisations
 *
 * Register an autoloader, start or resume the session etc.
 *
 * this allows us to dynamically require a class without hard coding it
 */
spl_autoload_register( function($class) {require dirname(__DIR__) . "/classes/{$class}.php";} );


//set sessions here so that anywhere that we want to use a session, we will be able to as a result of inclusion of this file

session_start();