<?php

$db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);
//by returning the value, it automatically becomes assigned to whatever encapsulates this file
return $db->getConn();