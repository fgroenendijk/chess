<?php

class Layout
{
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
}
