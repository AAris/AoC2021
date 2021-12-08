#!/usr/bin/php
<?php

require 'utils.php';

$values = read_numbers(',');

$boardsScore = [];
$boards = [];
$valuesPositions = [];
$rowIndex = 0;
$boardIndex = -1;
$winners = [];
$size = NULL;
while (FALSE !== ($line = readline())) {
    $line = trim($line);

    // Resets state for next board.
    if ('' == $line) {
        $rowIndex = 0;
        ++$boardIndex;
        $winners[$boardIndex] = FALSE;
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

$ranking = [];

foreach ($values as $turn => $value) {

    foreach ($valuesPositions[$value] as $position) {
        // Excludes winning boards.
        if (!$winners[$position[0]]) {
            if ($position[0] == 55)
                print PHP_EOL . '55 hits with ' . $value;
            // Updates score
            $boardsScore[$position[0]] -= intval($value);
            // Updates the number of hits on a particular row or column,
            // then checks if the number of hit equals the size of the board
            // and in that case declares a winner.
            $rowHits[$position[0]][$position[1]] = (isset($rowHits[$position[0]][$position[1]]) ? $rowHits[$position[0]][$position[1]] + 1 : 1);

            $columnHits[$position[0]][$position[2]] = (isset($columnHits[$position[0]][$position[2]]) ? $columnHits[$position[0]][$position[2]] + 1 : 1);

            if ($size === $rowHits[$position[0]][$position[1]]) {
                if ($position[0] == 55)
                    print PHP_EOL . '55 wins ' . $value;
                $winner['board'] = $position[0];
                $winner['call'] = intval($value);
                $ranking[] = $winner;
                $winners[$position[0]] = TRUE;
                if (count($ranking) === count($boards))
                    break 2;
            }
            else if ($size === $columnHits[$position[0]][$position[2]]) {
                if ($position[0] == 55)
                    print PHP_EOL . '55 wins';
                $winner['board'] = $position[0];
                $winner['call'] = intval($value);
                $ranking[] = $winner;
                $winners[$position[0]] = TRUE;
                if (count($ranking) === count($boards))
                    break 2;
            }

        }
        

    }

    if (count($ranking) === count($boards))
        break;

}

var_dump($ranking);

print PHP_EOL . 'Board: ' . $ranking[0]['board'] . PHP_EOL . 'Score: ' . $boardsScore[$ranking[0]['board']] . PHP_EOL . 'WinnerCall: ' . $ranking[0]['call'] . PHP_EOL;
print 'Final score ' . $boardsScore[$ranking[0]['board']] * $ranking[0]['call'] . PHP_EOL;

print PHP_EOL . 'Loser: ' . $ranking[$boardIndex]['board'] . PHP_EOL . 'Score: ' . $boardsScore[$ranking[$boardIndex]['board']] . PHP_EOL . 'Lsoer call: ' . $ranking[$boardIndex]['call'] . PHP_EOL . 'Final Loser score :' . $boardsScore[$ranking[$boardIndex]['board']] * $ranking[$boardIndex]['call'] . PHP_EOL;


