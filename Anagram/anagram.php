<?php

$input_word = isset($argv[1]) ? trim($argv[1]) : '';
$numLettersToRemove = isset($argv[2]) ? intval($argv[2]) : 0;

if ($numLettersToRemove < 1 || $numLettersToRemove >= strlen($input_word)) {
    echo "Le paramètre nb doit être non négatif et inférieur à la longueur du mot..\n";
    exit;
}

function generate_combinations($word, $numLettersToRemove) {
    $combinations = [];
    $length = strlen($word);

    if ($numLettersToRemove == 0) {
        return [$word];
    }

    $indexes = range(0, $length - 1);
    $index_combinations = combinations($indexes, $numLettersToRemove);

    foreach ($index_combinations as $index_set) {
        $combination = '';
        for ($i = 0; $i < $length; $i++) {
            if (!in_array($i, $index_set)) {
                $combination .= $word[$i];
            }
        }
        $combinations[] = $combination;
    }

    return $combinations;
}

function combinations($array, $length, $start_index = 0, $current = []) {
    if ($length == 0) {
        return [$current];
    }

    $results = [];
    for ($i = $start_index; $i <= count($array) - $length; $i++) {
        $new_combination = array_merge($current, [$array[$i]]);
        $results = array_merge($results, combinations($array, $length - 1, $i + 1, $new_combination));
    }

    return $results;
}

function are_anagrams($word1, $word2) {
    $count1 = count_chars($word1, 1);
    $count2 = count_chars($word2, 1);

    return $count1 == $count2;
}

$handle = fopen("anagram-master-dictionnaire.txt", "r");

if ($handle) {
    $dictionary = [];
    while (($word = fgets($handle)) !== false) {
        $dictionary[] = trim($word);
    }

    fclose($handle);

    $combinations = generate_combinations($input_word, $numLettersToRemove);

    $anagrams = [];

    foreach ($combinations as $combo) {
        foreach ($dictionary as $word) {
            if (are_anagrams($combo, $word) && $combo !== $word) {
                $anagrams[$word] = true;
            }
        }
    }

    foreach($anagrams as $anagram){
        print_r ($anagram ."\n");
    }
} else {
    echo "Impossible d'ouvrir le fichier du dictionnaire.\n";
}
?>
