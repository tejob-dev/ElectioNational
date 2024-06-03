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

function removeAccentsAndUpperCase($str) {
    // Array of accented characters and their non-accented equivalents
    $accented_chars = array(
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
        'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
        'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'd',
        'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y',
        'þ' => 'th', 'ÿ' => 'y'
    );

    // Replace accented characters with their non-accented counterparts
    $str = strtr($str, $accented_chars);

    // Convert the string to uppercase
    $str = mb_strtoupper($str, 'UTF-8');

    return $str;
}


?>
