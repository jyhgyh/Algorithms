<?php
if ($argc != 2) {
    echo "Usage: php bsq.php <filename>\n";
    exit(1);
}

$filename = $argv[1];
$file = fopen($filename, "r");
if (!$file) {
    echo "Could not open file: $filename\n";
    exit(1);
}

$rows = intval(fgets($file));
$board = [];
while (($line = fgets($file)) !== false) {
    $board[] = trim($line);
}

fclose($file);

$cols = strlen($board[0]);
$maxSize = 0;
$maxI = 0;
$maxJ = 0;

$sizes = array_fill(0, $rows, array_fill(0, $cols, 0));

for ($i = 0; $i < $rows; $i++) {
    for ($j = 0; $j < $cols; $j++) {
        if ($board[$i][$j] == '.') {
            if ($i == 0 || $j == 0) {
                $sizes[$i][$j] = 1;
            } else {
                $sizes[$i][$j] = min($sizes[$i - 1][$j], $sizes[$i][$j - 1], $sizes[$i - 1][$j - 1]) + 1;
            }
            if ($sizes[$i][$j] > $maxSize) {
                $maxSize = $sizes[$i][$j];
                $maxI = $i;
                $maxJ = $j;
            }
        }
    }
}

for ($i = $maxI; $i > $maxI - $maxSize; $i--) {
    for ($j = $maxJ; $j > $maxJ - $maxSize; $j--) {
        $board[$i][$j] = 'x';
    }
}

foreach ($board as $line) {
    echo $line . "\n";
}
