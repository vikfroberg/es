<?php

$body = file_get_contents("php://input");
$data = json_decode($body);

print json_encode($data);
