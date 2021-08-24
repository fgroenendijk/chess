<?php

namespace Chess;

require_once "Piece.php";

class Rook extends Piece
{
    /**
     * Place a Rook at a certain position and mark the places of the board that
     * can be taken by the rook
     *
     * @param $x x position of the piece
     * @param $y y position of the piece
     *
     * @return true if placing a rook was successful
     */
    public function place($x, $y)
    {
        // Convert to zero based array value
        $x = $x - 1;
        $y = $y - 1;

        if ($this->pieces[$x][$y] === true || $this->attackableSquares[$x][$y] === true) {
            return false;
        }

        for ($i = 0; $i < 7; $i++) {
            if ($i === $y) {
                $this->pieces[$x][$i] = true;
            } else {
                $this->attackableSquares[$x][$i] = true;
            }
        }
        for ($i = 0; $i < 7; $i++) {
            if ($i === $x) {
                $this->pieces[$i][$y] = true;
            } else {
                $this->attackableSquares[$i][$y] = true;
            }
        }

        // list($calculatedX, $calculatedY) = $this->searchStart($x, $y);
        // $this->markOccupiedSpaces($calculatedX, $calculatedY);

        // list($calculatedX, $calculatedY) = $this->searchStart($x, $y, true);
        // $this->markOccupiedSpaces($calculatedX, $calculatedY, true);

        return true;
    }
}
