<?php

$db = new Database();
//by returning the value, it automatically becomes assigned to whatever encapsulates this file
return $db->getConn();