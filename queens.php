<?php

spl_autoload_extensions(".php"); // comma-separated list
spl_autoload_register();

$options = getopt("", ["columns:"]);

$columns = 3;

if (array_key_exists("columns", $options)) {
    $columns = intval($options["columns"]);
}

$items = ['Rook'];
$items = ['Queen'];

foreach ($items as $pieceClassName) {
//foreach (['Queen', 'Rook'] as $pieceClassName) {
    $sha1FoundBoards = [];
    $foundBoards = [];

    $className = "classes\\" . $pieceClassName;

    for ($xOffset = 0; $xOffset < 8; $xOffset++) {
        for ($yOffset = 0; $yOffset < 8; $yOffset++) {
            $piece = new $className();

            $totalPieces = 1;
            list($x, $y) = $piece->searchFirstFreeSquare($xOffset, $yOffset);
            $piece->place($x, $y);

            while ((list($x, $y) = $piece->searchFirstFreeSquare())) {
                $piece->place($x, $y);
                $totalPieces++;
            }


            if ($totalPieces > 6) {
                $piecePositions = $piece->getPositions();
                $sha1FoundBoard = sha1(json_encode($piecePositions));
                if (!in_array($sha1FoundBoard, $sha1FoundBoards)) {
                    $sha1FoundBoards[] = $sha1FoundBoard;
                    $foundBoards[] = [
                        "sha1" => $sha1FoundBoard,
                        "board" => $piecePositions
                    ];
                }
            }
        }
    }

    $layout = new classes\Layout($piece->character);

    $layout->printBoardColumns($foundBoards, $columns);

    print_r("Total number of possibilities: " . count($sha1FoundBoards) . " for $pieceClassName piece\n");
}
