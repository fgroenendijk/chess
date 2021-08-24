<?php

namespace classes;

class Layout
{
    private $character;

    public function __construct($character)
    {
        $this->character = $character;
    }

    private function boardLayout($pieces)
    {
        $board = "╔═════╦═════╦═════╦═════╦═════╦═════╦═════╦═════╗";
        $output[] = $board;
        for ($y = 0; $y < 8; $y++) {
            $board = "║";
            for ($x = 0; $x < 8; $x++) {
                if ($pieces[$x][$y] === true) {
                    $board .= "  $this->character  ║";
                } else {
                    $board .= "  .  ║";
                }
            }
            $output[] = $board;
            if ($y < 7) {
                $board = "╠═════╬═════╬═════╬═════╬═════╬═════╬═════╬═════╣";
            } else {
                $board = "╚═════╩═════╩═════╩═════╩═════╩═════╩═════╩═════╝";
            }
            $output[] = $board;
        }

        return $output;
    }

    public function printBoardColumns($boards, $columns = 1)
    {
        $maxBoards = count($boards);
        $boardIndex = 0;
        while ($boardIndex < $maxBoards) {
            $lines = null;
            for ($i = 0; $i < $columns; $i++) {
                if (!empty($boards[$boardIndex])) {
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
            }
            for ($i = 0; $i < count($lines); $i++) {
                print_r($lines[$i] . "\n");
            }
        }
    }
}
