<?php

class Queens
{

    private $_queens;
    private $_squares;

    function __construct()
    {
        $this->_squares = array_fill(0, 7, array_fill(0, 7, false));
        $this->_queens = array_fill(0, 7, array_fill(0, 7, false));
    }

    function getPositions()
    {
        return $this->_queens;
    }

    function boardLayout($queens)
    {
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

    function printBoardColumns($boards, $columns = 1)
    {
        $maxBoards = count($boards);
        $boardIndex = 0;
        while ($boardIndex < $maxBoards) {
            $lines = null;
            for ($i = 0; $i < $columns; $i++) {
                $output = $this->boardLayout($boards[$boardIndex]["board"]);
                if (empty($lines)) {
                    $lines = $output;
                } else {
                    foreach ($lines as $index => &$line) {
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

    function searchFirstFreeSquare($xOffset = 0, $yOffset = 0)
    {
        for ($y = $yOffset; $y < 7; $y++) {
            for ($x = $xOffset; $x < 7; $x++) {
                if ($this->_queens[$x][$y] || $this->_squares[$x][$y]) {
                    continue;
                }

                return [++$x, ++$y];
            }
        }

        return false;
    }

    function placeQueen($x, $y)
    {
        $x = $x - 1;
        $y = $y - 1;

        if ($this->_queens[$x][$y] === true || $this->_squares[$x][$y] === true) {
            return false;
        }

        for ($i = 0; $i < 7; $i++) {
            if ($i === $y) {
                $this->_queens[$x][$i] = true;
            } else {
                $this->_squares[$x][$i] = true;
            }
        }
        for ($i = 0; $i < 7; $i++) {
            if ($i === $x) {
                $this->_queens[$i][$y] = true;
            } else {
                $this->_squares[$i][$y] = true;
            }
        }

        list($calculatedX, $calculatedY) = $this->searchStart($x, $y);
        $this->markOccupiedSpaces($calculatedX, $calculatedY);

        list($calculatedX, $calculatedY) = $this->searchStart($x, $y, true);
        $this->markOccupiedSpaces($calculatedX, $calculatedY, true);

        return true;
    }

    function markOccupiedSpaces($x, $y, $topRight = false)
    {
        $calculatedX = $x;
        $calculatedY = $y;

        while (( ($topRight && $calculatedX >= 0) || (!$topRight && $calculatedX < 7) ) && $calculatedY < 7) {
            if (!$this->_queens[$calculatedX][$calculatedY]) {
                $this->_squares[$calculatedX][$calculatedY] = true;
            }
            if ($topRight) {
                $calculatedX--;
            } else {
                $calculatedX++;
            }
            $calculatedY++;
        }
    }

    function searchStart($x, $y, $topRight = false)
    {
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
}
