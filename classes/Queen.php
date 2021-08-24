<?php

namespace classes;

class Queen extends Piece
{
    // protected $pieces;
    // protected $attackableSquares;

    public function __construct()
    {
        parent::__construct();
        $this->character = "$";
    }

    /**
     * Place a Queen at a certain position and mark the places of the board that
     * can be taken by the queen
     *
     * @param $x x position of the piece
     * @param $y y position of the piece
     *
     * @return true if placing a queen was successful
     */
    public function place($x, $y)
    {
        // Convert to zero based value
        $x = $x - 1;
        $y = $y - 1;

        if ($this->pieces[$x][$y] === true || $this->attackableSquares[$x][$y] === true) {
            return false;
        }

        for ($i = 0; $i < 8; $i++) {
            if ($i === $y) {
                $this->pieces[$x][$i] = true;
            } else {
                $this->attackableSquares[$x][$i] = true;
            }
        }
        for ($i = 0; $i < 8; $i++) {
            if ($i === $x) {
                $this->pieces[$i][$y] = true;
            } else {
                $this->attackableSquares[$i][$y] = true;
            }
        }

        list($calculatedX, $calculatedY) = $this->searchStart($x, $y);
        $this->markOccupiedSpaces($calculatedX, $calculatedY);

        list($calculatedX, $calculatedY) = $this->searchStart($x, $y, true);
        $this->markOccupiedSpaces($calculatedX, $calculatedY, true);

        return true;
    }

    /**
     * Search for the first capturable position by a Queen either starting from the
     * top right position or the bottom left
     *
     * @param $x        x position of the piece
     * @param $y        y position of the piece
     * @param $topRight start from the top right position
     *
     * @return array of x and y position
     */
    private function searchStart($x, $y, $topRight = false)
    {
        $maxPosition = max($x, $y);

        for ($i = $maxPosition; $i >= 0; $i--) {
            if ($topRight) {
                if ($x < 7 && $y > 0) {
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

    /**
     * Mark the places that are capturable by a queen
     *
     * @param $x        x position of the place
     * @param $y        y position of the place
     * @param $topRight start from the top right position
     *
     * @return array of x and y position
     */
    private function markOccupiedSpaces($x, $y, $topRight = false)
    {
        $calculatedX = $x;
        $calculatedY = $y;

        while (( ($topRight && $calculatedX >= 0) || (!$topRight && $calculatedX < 8) ) && $calculatedY < 8) {
            if (!$this->pieces[$calculatedX][$calculatedY]) {
                $this->attackableSquares[$calculatedX][$calculatedY] = true;
            }
            if ($topRight) {
                $calculatedX--;
            } else {
                $calculatedX++;
            }
            $calculatedY++;
        }
    }
}
