<?php

require_once("config/database.php");

$connection = pg_pconnect(ConfigDatabase::get_config_string());

$FROM = (int)$argv[1];

if ($connection) {
  $queries = array(
    "
      DROP TABLE IF EXISTS events_log;
      CREATE TABLE events_log (
        id SERIAL PRIMARY KEY,
        event_id varchar(255) NOT NULL,
        data json NOT NULL,
        created_at timestamp default current_timestamp
      );
    ",
    "
      DROP TABLE IF EXISTS effects_log;
      CREATE TABLE  effects_log (
        id SERIAL PRIMARY KEY,
        effect_id varchar(255) NOT NULL,
        event_log_id int REFERENCES events_log(id) NOT NULL,
        data json NOT NULL,
        status int NULL,
        created_at timestamp default current_timestamp
      );
    "
  );

  $selected_queries = array_slice($queries, $FROM);

  foreach ($selected_queries as $query) {
    pg_query($connection, $query);
  }
} else {
  echo "An error occurred.\n";
  exit;
};
