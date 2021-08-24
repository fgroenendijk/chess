<?php

require_once "classes/Layout.php";
require_once "classes/Queen.php";

$sha1FoundBoards = [];
$foundBoards = [];

for ( $xOffset = 0; $xOffset < 7; $xOffset++ ) {
    for ( $yOffset = 0; $yOffset < 7; $yOffset++ ) {
        $queens = new Queen();

        $totalQueens = 1;
        list($x, $y) = $queens->searchFirstFreeSquare($xOffset, $yOffset);
        $queens->placeQueen($x, $y);

        while ((list($x, $y) = $queens->searchFirstFreeSquare())) {
            $queens->placeQueen($x, $y);
            $totalQueens++;
        }

        if ($totalQueens > 6) {
            $queenPositions = $queens->getPositions();
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

$layout = new Layout();

$layout->printBoardColumns($foundBoards, 3);

print_r("Total number of possibilities: " . count($sha1FoundBoards) . "\n");

?>
