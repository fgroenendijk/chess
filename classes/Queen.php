<?php

require_once "Piece.php";

class Queen extends Piece
{
    protected $pieces;
    protected $squares;

    /**
     * Place a Queen at a certain position and mark the places of the board that
     * can be taken by the queen
     *
     * @param $x x position of the piece
     * @param $y y position of the piece
     *
     * @return true if placing a queen was successful
     */
    function placeQueen($x, $y)
    {
        $x = $x - 1;
        $y = $y - 1;

        if ($this->pieces[$x][$y] === true || $this->squares[$x][$y] === true) {
            return false;
        }

        for ($i = 0; $i < 7; $i++) {
            if ($i === $y) {
                $this->pieces[$x][$i] = true;
            } else {
                $this->squares[$x][$i] = true;
            }
        }
        for ($i = 0; $i < 7; $i++) {
            if ($i === $x) {
                $this->pieces[$i][$y] = true;
            } else {
                $this->squares[$i][$y] = true;
            }
        }

        list($calculatedX, $calculatedY) = $this->searchStart($x, $y);
        $this->markOccupiedSpaces($calculatedX, $calculatedY);

        list($calculatedX, $calculatedY) = $this->searchStart($x, $y, true);
        $this->markOccupiedSpaces($calculatedX, $calculatedY, true);

        return true;
    }

    /**
     * Search for the first free position to place a Queen
     *
     * @param $x        x position of the piece
     * @param $y        y position of the piece
     * @param $topRight start from the top right position
     *
     * @return array of x and y position
     */
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

    /**
     * Mark the places that are capturable by a queen
     *
     * @param $x        x position of the place
     * @param $y        y position of the place
     * @param $topRight start from the top right position
     *
     * @return array of x and y position
     */
    function markOccupiedSpaces($x, $y, $topRight = false)
    {
        $calculatedX = $x;
        $calculatedY = $y;

        while (( ($topRight && $calculatedX >= 0) || (!$topRight && $calculatedX < 7) ) && $calculatedY < 7) {
            if (!$this->pieces[$calculatedX][$calculatedY]) {
                $this->squares[$calculatedX][$calculatedY] = true;
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