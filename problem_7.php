#!/usr/bin/php
<?php

require 'utils.php';

$values = read_numbers(',');

$boardsScore = [];
$boards = [];
$valuesPositions = [];
$rowIndex = 0;
$boardIndex = -1;
$size = NULL;
while (FALSE !== ($line = readline())) {
    $line = trim($line);

    // Resets state for next board.
    if ('' == $line) {
        $rowIndex = 0;
        ++$boardIndex;
    }
    else {
        $boards[$boardIndex][$rowIndex] = preg_split('/\s+/ ', $line);
        $size = ($size ? $size : count($boards[$boardIndex][$rowIndex]));
        foreach ($boards[$boardIndex][$rowIndex] as $columnIndex => $val) {
            if (isset($boardsScore[$boardIndex])) {
                $boardsScore[$boardIndex] = $boardsScore[$boardIndex] + intval($val);
            }
            else {
                $boardsScore[$boardIndex] = intval($val);
            }

            // [board number, row, column]
            $valuesPositions[$val][] = [$boardIndex, $rowIndex, $columnIndex];
        }
        ++$rowIndex;    
    }
    
}

$rowHits = $columnHits = [];
$winnerScore = -1;
$winnerBoard = -1;
$winnerCall = -1;
foreach ($values as $turn => $value) {

    foreach ($valuesPositions[$value] as $position) {
        // Updates score
        $boardsScore[$position[0]] -= intval($value);
        // Updates the number of hits on a particular row or column,
        // then checks if the number of hit equals the size of the board
        // and in that case declares a winner.
        $rowHits[$position[0]][$position[1]] = (isset($rowHits[$position[0]][$position[1]]) ? $rowHits[$position[0]][$position[1]] + 1 : 1);

        if ($size === $rowHits[$position[0]][$position[1]]) {
            $winnerBoard = $position[0];
            $winnerScore = $boardsScore[$position[0]];
            $winnerCall = intval($value);
            break;
          
        }

        $columnHits[$position[0]][$position[2]] = (isset($columnHits[$position[0]][$position[2]]) ? $columnHits[$position[0]][$position[2]] + 1 : 1);
        if ($size === $columnHits[$position[0]][$position[2]]) {
            $winnerBoard = $position[0];
            $winnerScore = $boardsScore[$position[0]];
            $winnerCall = intval($value);
            break;
          
        }

    }

    if (-1 !== $winnerScore)
        break;

}

print '\nBoard: ' . $winnerBoard . '\nScore: ' . $winnerScore . '\nWinnerCall: ' . $winnerCall . '\n';
print 'Final score ' . $winnerScore * $winnerCall;


