<?php

require_once("config/database.php");

$events = array(
  "noop" => array("noop", "noop2")
);

$connection = pg_pconnect(ConfigDatabase::get_config_string());

$events_log = pg_fetch_all(pg_query("SELECT * FROM events_log")) ?: array();

foreach ($events_log as $event) {
  $id = $event["id"];
  $event_id = $event["event_id"];
  $effects = $events[$event_id];
  $data = $event["data"];
  foreach ($effects as $effect_id) {
    pg_query(
      $connection,
      "
      INSERT INTO effects_log (event_log_id, effect_id, data)
      VALUES ('${id}', '${effect_id}', '${data}');
      "
    );
  }
}
