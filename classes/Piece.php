<?php

namespace classes;

abstract class Piece
{
    public $character = "D";
    protected $pieces;
    protected $attackableSquares;

    public function __construct()
    {
        $this->pieces = array_fill(0, 8, array_fill(0, 8, false));
        $this->attackableSquares = array_fill(0, 8, array_fill(0, 8, false));
    }

    abstract public function place($x, $y);

    public function getPositions()
    {
        return $this->pieces;
    }

    /**
     * Search for the first unoccupied space (no pieces and not capturable)
     *
     * @param $xOffset x offset to start looking from
     * @param $yOffset y offset to start looking from
     *
     * @return x and y array if a free spot has been found
     */
    public function searchFirstFreeSquare($xOffset = 0, $yOffset = 0)
    {
        for ($y = $yOffset; $y < 8; $y++) {
            for ($x = $xOffset; $x < 8; $x++) {
                if ($this->pieces[$x][$y] || $this->attackableSquares[$x][$y]) {
                    continue;
                }

                return [++$x, ++$y];
            }
        }

        return false;
    }
}
