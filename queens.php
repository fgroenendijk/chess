<?php

$sha1FoundBoards = [];
$foundBoards = [];

for ( $xOffset = 0; $xOffset < 7; $xOffset++ ) {
	for ( $yOffset = 0; $yOffset < 7; $yOffset++ ) {
		initArrays();

		$totalQueens = 1;
		list($x, $y) = searchFirstFreeSquare($xOffset, $yOffset);
		placeQueen($x, $y);

		while((list($x, $y) = searchFirstFreeSquare())) {
			placeQueen($x, $y);
			$totalQueens++;
		}

		if ($totalQueens > 6) {
			$sha1FoundBoard = sha1(json_encode($queens));
			if (!in_array($sha1FoundBoard, $sha1FoundBoards)) {
				$sha1FoundBoards[] = $sha1FoundBoard;
				$foundBoards[] = ["sha1" => $sha1FoundBoard, "board" => $queens];
			}
		}
	}
}

printBoardColumns($foundBoards, 3);

print_r( "Total number of possibilities: " . count($sha1FoundBoards) . "\n" );

function initArrays() {
	global $queens, $squares;
	$squares = array_fill(0, 7, array_fill(0, 7, false));
	$queens = array_fill(0, 7, array_fill(0, 7, false));
}

function boardLayout($queens) {
	$board = "╔═════╦═════╦═════╦═════╦═════╦═════╦═════╗";
	$output[] = $board;
	for ($y = 0; $y < 7; $y++) {
		$board = "║";
		for ($x = 0; $x < 7; $x++) {
			if ($queens[$x][$y] === true) {
				$board .= "  $  ║"; 
			} else {
				$board .= "  .  ║"; 
			}
		}
	  	$output[] = $board;
		if ($y < 6) {
 	 		$board = "╠═════╬═════╬═════╬═════╬═════╬═════╬═════╣";
		} else {
			$board = "╚═════╩═════╩═════╩═════╩═════╩═════╩═════╝";
		}
 	 	$output[] = $board;
	}

	return $output;
}

function printBoardColumns($boards, $columns = 1) {
	$maxBoards = count($boards);
	$boardIndex = 0;
	while ($boardIndex < $maxBoards) {
		$lines = null;
		for ($i = 0; $i < $columns; $i++) {
			$output = boardLayout($boards[$boardIndex]["board"]);
			if (empty($lines)) {
				$lines = $output;
			} else {
				foreach($lines as $index => &$line) {
					$line .= "   "    . $output[$index];
				}
			}
			$boardIndex++;
		}
		for ($i = 0; $i < count($lines); $i++) {
			print_r($lines[$i] . "\n");
		}
	}
}

function searchFirstFreeSquare($xOffset = 0, $yOffset = 0) {
	global $squares, $queens;

	for ($y = $yOffset; $y < 7; $y++) {
		for ($x = $xOffset; $x < 7; $x++) {
			if ($queens[$x][$y] || $squares[$x][$y]) {
				continue;
			}

			return [++$x, ++$y];
		}
	}

	return false;
}

function placeQueen($x, $y) {
	global $squares, $queens;

	$x = $x - 1;
	$y = $y - 1;

	if ($queens[$x][$y] === true || $squares[$x][$y] === true) {
		return false;
	}

	for ($i = 0; $i < 7; $i++) {
		if ($i === $y) {
			$queens[$x][$i] = true;	
		} else {
			$squares[$x][$i] = true;
		}
	}
	for ($i = 0; $i < 7; $i++) {
		if ($i === $x) {
			$queens[$i][$y] = true;	
		} else {
			$squares[$i][$y] = true;
		}
	}

	list($calculatedX, $calculatedY) = searchStart($x, $y);
	markOccupiedSpaces($calculatedX, $calculatedY);

	list($calculatedX, $calculatedY) = searchStart($x, $y, true);
	markOccupiedSpaces($calculatedX, $calculatedY, true);

	return true;
}

function markOccupiedSpaces($x, $y, $topRight = false) {
	global $squares, $queens;
	$calculatedX = $x;
	$calculatedY = $y;

	while(( ($topRight && $calculatedX >= 0) || (!$topRight && $calculatedX < 7) ) && $calculatedY < 7) {
		if (!$queens[$calculatedX][$calculatedY]) {
			$squares[$calculatedX][$calculatedY] = true;
		}
		if ($topRight) {
			$calculatedX--;
		} else {
			$calculatedX++;
		}
		$calculatedY++;
	}
}

function searchStart($x, $y, $topRight = false) {
	$maxPosition = max($x, $y);

	for ($i = $maxPosition; $i >= 0; $i--) {
		if ($topRight) {
			if ($x < 6 && $y > 0) {
				$x++;
				$y--;
			} else {
				break;
			}
		} else {
			if ($x > 0 && $y > 0) {
				$x--;
				$y--;
			} else {
				break;
			}
		}
	}
	return [$x, $y];
}

?>
