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

require dirname(__DIR__) . "/config.php";


//displays errors and exceptions depending on the environment
//which will be 'set' as the arguments further below
function errorHandler($level, $message, $file, $line) {
    throw new ErrorException($message, 0, $level, $file, $line);
}

function exceptionHandler($exception) {

    if (SHOW_ERROR_DETAIL) {

    echo "<h1>An error occured</h1>";
    echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
    echo "<p>" . $exception->getMessage() . "'</p>";
    echo "<p>Stack trace: <pre>" . $exception->getTraceAsString() . "</pre></p>";
    echo "<p>In file '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";

    } else {
        echo "<h1>An error occurred</h1>";
        echo "<p>Please try again later</p>";
    }

    exit();
}

set_error_handler("errorHandler");
set_exception_handler("exceptionHandler");