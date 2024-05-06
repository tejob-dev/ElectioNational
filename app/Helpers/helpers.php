<?php

// app/Helpers/format_number.php

function make_separate_thousand($number) {
    // Add a space every 3 digits from the right
    $formatted_number = number_format($number, 0, '', ' ');

    return $formatted_number;
}

?>
