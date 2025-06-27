<?php
// Get the input from GET or POST
$data = $_REQUEST['data'];

// ✅ 1) Validate: allow only alphanumeric characters, spaces and some punctuation
// You can use preg_match or preg_replace for this

if (preg_match('/^[a-zA-Z0-9\s.,!?]*$/', $data)) {
    // ✅ 2) Encode special characters to prevent XSS
    echo htmlspecialchars($data);
} else {
    // If validation fails, display an error message
    echo "Invalid input.";
}
?>



































