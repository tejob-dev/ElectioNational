<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Le champ :attribute doit être accepté.',
    'accepted_if' => 'Le champ :attribute doit être accepté quand :other est :value.',
    'active_url' => 'Le champ :attribute n\'est pas une URL valide.',
    'after' => 'Le champ :attribute doit être une date après :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date après ou égale à :date.',
    'alpha' => 'Le champ :attribute ne peut contenir que des lettres.',
    'alpha_dash' => 'Le champ :attribute ne peut contenir que des lettres, des chiffres, des tirets et des underscores.',
    'alpha_num' => 'Le champ :attribute ne peut contenir que des lettres et des chiffres.',
    'array' => 'Le champ :attribute doit être un tableau.',
    'before' => 'Le champ :attribute doit être une date avant :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date avant ou égale à :date.',
    'between' => [
        'numeric' => 'Le champ :attribute doit être compris entre :min et :max.',
        'file' => 'Le champ :attribute doit avoir une taille entre :min et :max kilo-octets.',
        'string' => 'Le champ :attribute doit contenir entre :min et :max caractères.',
        'array' => 'Le champ :attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => 'Le champ :attribute n\'est pas une date valide.',
    'date_equals' => 'Le champ :attribute doit être une date égale à :date.',
    'date_format' => 'Le champ :attribute ne correspond pas au format :format.',
    'declined' => 'Le champ :attribute doit être refusé.',
    'declined_if' => 'Le champ :attribute doit être refusé lorsque :other est :value.',
    'different' => 'Le champ :attribute et :other doivent être différents.',
    'digits' => 'Le champ :attribute doit avoir :digits chiffres.',
    'digits_between' => 'Le champ :attribute doit avoir entre :min et :max chiffres.',
    'dimensions' => 'Le champ :attribute a des dimensions d\'image non valides.',
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'email' => 'Le champ :attribute doit être une adresse email valide.',
    'ends_with' => 'Le champ :attribute doit se terminer par l\'une des valeurs suivantes: :values.',
    'enum' => 'La valeur sélectionnée pour :attribute est invalide.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
    'numeric' => 'Le champ :attribute doit être supérieur à :value.',
    'file' => 'Le champ :attribute doit être supérieur à :value kilo-octets.',
    'string' => 'Le champ :attribute doit être supérieur à :value caractères.',
    'array' => 'Le champ :attribute doit avoir plus de :value éléments.',
    ],
    'gte' => [
    'numeric' => 'Le champ :attribute doit être supérieur ou égal à :value.',
    'file' => 'Le champ :attribute doit être supérieur ou égal à :value kilo-octets.',
    'string' => 'Le champ :attribute doit être supérieur ou égal à :value caractères.',
    'array' => 'Le champ :attribute doit avoir :value éléments ou plus.',
    ],
    'image' => 'Le champ :attribute doit être une image.',
    'in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'in_array' => 'Le champ :attribute n\'existe pas dans :other.',
    'integer' => 'Le champ :attribute doit être un entier.',
    'ip' => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4' => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6' => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json' => 'Le champ :attribute doit être une chaîne JSON valide.',
    'lt' => [
        'numeric' => 'Le champ :attribute doit être inférieur à :value.',
        'file' => 'Le champ :attribute doit être inférieur à :value kilo-octets.',
        'string' => 'Le champ :attribute doit être inférieur à :value caractères.',
        'array' => 'Le champ :attribute doit avoir moins de :value éléments.',
    ],
    'lte' => [
        'numeric' => ':attribute doit être inférieur ou égal à :value.',
        'file' => ':attribute doit être inférieur ou égal à :value kilo-octets.',
        'string' => ':attribute doit contenir au maximum :value caractères.',
        'array' => ':attribute ne doit pas contenir plus de :value éléments.',
        ],
        'mac_address' => ':attribute doit être une adresse MAC valide.',
        'max' => [
        'numeric' => ':attribute ne doit pas être supérieur à :max.',
        'file' => ':attribute ne doit pas dépasser :max kilo-octets.',
        'string' => ':attribute ne doit pas dépasser :max caractères.',
        'array' => ':attribute ne doit pas contenir plus de :max éléments.',
        ],
        'mimes' => ':attribute doit être un fichier de type: :values.',
        'mimetypes' => ':attribute doit être un fichier de type: :values.',
        'min' => [
        'numeric' => ':attribute doit être d\'au moins :min.',
        'file' => ':attribute doit faire au moins :min kilo-octets.',
        'string' => ':attribute doit contenir au moins :min caractères.',
        'array' => ':attribute doit contenir au moins :min éléments.',
        ],
        'multiple_of' => ':attribute doit être un multiple de :value.',
        'not_in' => 'La valeur sélectionnée pour :attribute est invalide.',
        'not_regex' => 'Le format de :attribute est invalide.',
        'numeric' => ':attribute doit être un nombre.',
        'password' => 'Le mot de passe est incorrect.',
        'present' => 'Le champ :attribute doit être présent.',
        'prohibited' => 'Le champ :attribute est interdit.',
        'prohibited_if' => 'Le champ :attribute est interdit lorsque :other est :value.',
        'prohibited_unless' => 'Le champ :attribute est interdit sauf si :other est dans :values.',
        'prohibits' => 'Le champ :attribute interdit la présence de :other.',
        'regex' => 'Le format de :attribute est invalide.',
        'required' => 'Le champ :attribute est requis.',
        'required_array_keys' => 'Le champ :attribute doit contenir des entrées pour :values.',
        'required_if' => 'Le champ :attribute est requis lorsque :other est :value.',
        'required_unless' => 'Le champ :attribute est requis sauf si :other est dans :values.',
        'required_with' => 'Le champ :attribute est requis lorsque :values est présent.',
        'required_with_all' => 'Le champ :attribute est requis lorsque :values sont présents.',
        'required_without' => 'Le champ :attribute est requis lorsque :values n\'est pas présent.',
        'required_without_all' => 'Le champ :attribute est requis lorsque aucun de :values n\'est présent.',
        'same' => ':attribute et :other doivent être identiques.',
        'size' => [
        'numeric' => ':attribute doit être de :size.',
        'file' => ':attribute doit faire :size kilo-octets.',
        'string' => ':attribute doit contenir :size caractères.',
        'array' => ':attribute doit contenir :size éléments.',
        ],
        'starts_with' => 'L\'attribut :attribute doit commencer par l\'une des valeurs suivantes : :values.',
        'string' => 'L\'attribut :attribute doit être une chaîne de caractères.',
        'timezone' => 'L\'attribut :attribute doit être un fuseau horaire valide.',
        'unique' => 'L\'attribut :attribute a déjà été pris.',
        'uploaded' => 'Le téléchargement de :attribute a échoué.',
        'url' => 'L\'attribut :attribute doit être une URL valide.',
        'uuid' => 'L\'attribut :attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];