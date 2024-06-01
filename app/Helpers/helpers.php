<?php

// app/Helpers/format_number.php

function make_separate_thousand($number) {
    // Add a space every 3 digits from the right
    $formatted_number = number_format($number, 0, '', ' ');

    return $formatted_number;
}


function get_item_of_datatables($arrcontent) {
    $searchidx = array();
    foreach ($arrcontent["columns"] as $column) {
        if ($column['search']['value'] != null) {
            $searchidx[$column['name']] = $column['search']['value'];
            // $searchVal[] = $column['search']['value'];
        }
    }
    if($arrcontent['search']['value'] != null) {
        $searchidx['name'] = $arrcontent['search']['value'];
        // $searchVal[] = $column['search']['value'];
    }
    return $searchidx;
}

?>
