<?php
  // Grab the “data” parameter from either GET or POST
  $input = $_REQUEST["data"];
  // Safely display it on the webpage
  echo "You sent: " . htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
?>
