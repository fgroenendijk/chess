<?php

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

$options = getopt("", ["columns:"]);

$columns = 3;

if (array_key_exists("columns", $options)) {
    $columns = intval($options["columns"]);
}

foreach (['Queen', 'Rook'] as $pieceClassName) {
    $sha1FoundBoards = [];
    $foundBoards = [];

    $className = "classes\\" . $pieceClassName;

    for ($xOffset = 0; $xOffset < 7; $xOffset++) {
        for ($yOffset = 0; $yOffset < 7; $yOffset++) {
            $piece = new $className();

            $totalQueens = 1;
            list($x, $y) = $piece->searchFirstFreeSquare($xOffset, $yOffset);
            $piece->place($x, $y);

            while ((list($x, $y) = $piece->searchFirstFreeSquare())) {
                $piece->place($x, $y);
                $totalQueens++;
            }

            if ($totalQueens > 6) {
                $queenPositions = $piece->getPositions();
                $sha1FoundBoard = sha1(json_encode($queenPositions));
                if (!in_array($sha1FoundBoard, $sha1FoundBoards)) {
                    $sha1FoundBoards[] = $sha1FoundBoard;
                    $foundBoards[] = [
                        "sha1" => $sha1FoundBoard,
                        "board" => $queenPositions
                    ];
                }
            }
        }
    }

    $character = "";

    switch ($pieceClassName) {
        case "Rook":
            $character = "#";
            break;
        case "Queen":
            $character = "$";
            break;
        default:
            $character = "D";
    }

    $layout = new classes\Layout($character);

    $layout->printBoardColumns($foundBoards, $columns);

    print_r("Total number of possibilities: " . count($sha1FoundBoards) . " for $pieceClassName piece\n");
}
