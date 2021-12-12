package main

import (
	"fmt"
	"os"
	"strings"
)

const MAX_ENERGY int = 9
const STEPS int = 100

type Octopus int

var flashCount int = 0

func readOctopus(path string) [][]Octopus {
	fileData, err := os.ReadFile(path)
	if err != nil {
		panic(err)
	}

	fileText := string(fileData)
	fileLines := strings.Split(fileText, "\n")

	sea := [][]Octopus{}

	for _, line := range fileLines {
		octs := []Octopus{}
		for _, rune := range line {
			oct := Octopus(rune - '0')
			octs = append(octs, oct)
		}
		sea = append(sea, octs)
	}
	return sea
}

// func increase(r int, c int, state *[][]Octopus, flashes *[][2]int) {
// 	if (int(*state[r][c]) == MAX_ENERGY) {
// 		*flashes = append(*flashes, [2]int{r,c})
// 		*state[r][c] = Octopus(0)
// 	}
// }

func main() {

	state := readOctopus("input_test.txt")

	for day := 0; day < STEPS; day++ {
		flashes := [][2]int{}
		for i, line := range state {
			for j, oct := range line {
				if int(oct) == MAX_ENERGY {
					flashes = append(flashes, [2]int{i,j})
					flashCount++
					state[i][j] = Octopus(0)
				} else {
					state[i][j] = oct + 1
				}
			}
		}

		for len(flashes) > 0 {
			for _, r := range [3]int{-1,0,1} {
				for _, c := range [3]int{-1,0,1} {
					rc := flashes[0][0] + r
					cc := flashes[0][1] + c
					if rc < len(state) && rc >= 0 && cc < len(state[0]) && cc >= 0 {
						if (int(state[rc][cc]) != 0) {
							if (int(state[rc][cc]) == MAX_ENERGY) {
								flashes = append(flashes, [2]int{rc,cc})
								flashCount++
								state[rc][cc] = Octopus(0)
							} else {
								state[rc][cc] += 1
							}
						}
					}
				}
			}

			flashes = flashes[1:]
		}
		
	}

	fmt.Println(flashCount)

	finish := 0
	day := 0
	stateOrig := readOctopus("input.txt")
	target := len(stateOrig) * len(stateOrig[0])
	for finish == 0 {
		flashCount := 0
		flashes := [][2]int{}
		for i, line := range stateOrig {
			for j, oct := range line {
				if int(oct) == MAX_ENERGY {
					flashes = append(flashes, [2]int{i,j})
					stateOrig[i][j] = Octopus(0)
				} else {
					stateOrig[i][j] = oct + 1
				}
			}
		}

		for len(flashes) > 0 {
			flashCount ++
			for _, r := range [3]int{-1,0,1} {
				for _, c := range [3]int{-1,0,1} {
					rc := flashes[0][0] + r
					cc := flashes[0][1] + c
					if rc < len(stateOrig) && rc >= 0 && cc < len(stateOrig[0]) && cc >= 0 {
						if (int(stateOrig[rc][cc]) != 0) {
							if (int(stateOrig[rc][cc]) == MAX_ENERGY) {
								flashes = append(flashes, [2]int{rc,cc})
								stateOrig[rc][cc] = Octopus(0)
							} else {
								stateOrig[rc][cc] += 1
							}
						}
					}
				}
			}

			flashes = flashes[1:]
		}

		if (flashCount == target) {
			finish = day + 1
		}

		day++
	}

	fmt.Println(finish)
	
		

}