<?php

namespace classes;

class Rook extends Piece
{
    public function __construct()
    {
        parent::__construct();
        $this->character = "#";
    }

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

        return true;
    }
}
