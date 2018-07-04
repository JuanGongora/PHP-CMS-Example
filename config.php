<?php
/**
 * This file can take care of changes for the DB and Mail
 * settings when moving between new servers
 */

//TODO: you should change the below to real values when used in production

//defining constants that can be used globally
define("DB_HOST", "localhost:3307");
define("DB_NAME", "cms");
define("DB_USER", "cms_www");
define("DB_PASS", "pass");

define("SMTP_HOST", "mail.example.com");
define("SMTP_USER", "user@example.com");
define("SMTP_PASS", "pass");