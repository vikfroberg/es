<?php

require_once("config/database.php");

function noop($data) {
  echo "NOOP";
  return 200;
}

function noop2($data) {
  echo "NOOP2";
  return 200;
}

$connection = pg_pconnect(ConfigDatabase::get_config_string());

$effects_log = pg_fetch_all(pg_query("SELECT * FROM effects_log WHERE status IS NULL;")) ?: array();

foreach ($effects_log as $effect) {
  $id = $effect["id"];
  $event_id = $effect["event_id"];
  $effect_id = $effect["effect_id"];
  $data = $effect["data"];
  $status = call_user_func($effect_id, $data);
  pg_query(
    $connection,
    "
    UPDATE effects_log SET status = '${status}' WHERE id = '${id}';
    "
  );
}
