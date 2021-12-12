package main

import (
	"bufio"
	"fmt"
	"os"
	"strings"
)

const START string = "start"
const END string = "end"
const SEPARATOR string = "-"
const MAX_VISITS int = 2


func readMap(path string) map[string]map[string]bool {

	fileData, err := os.Open(path)
	if err != nil {
		panic(err)
	}

    defer fileData.Close()

    // read the file line by line using scanner
    scanner := bufio.NewScanner(fileData)

    caveMap := map[string]map[string]bool{}
    for scanner.Scan() {
        rooms := strings.Split(scanner.Text(), SEPARATOR)
        if caveMap[rooms[0]] == nil {
        	caveMap[rooms[0]] = make(map[string]bool)
        }
        caveMap[rooms[0]][rooms[1]] = true
        if caveMap[rooms[1]] == nil {
        	caveMap[rooms[1]] = make(map[string]bool)
        }
        caveMap[rooms[1]][rooms[0]] = true
    }

    return caveMap
}

func findPaths(room string, visited map[string]int, caveMap map[string]map[string]bool, small bool, path string) int {

	count := 0
	path = path + " " + room
	if (END == room) {
		fmt.Println(path)
		count = 1
	} else {
		visitedC := map[string]int{}
		for key, val := range visited {
			visitedC[key] = val
		}
		visitedC[room] += 1
		if (strings.ToLower(room) == room && visitedC[room] >= MAX_VISITS) {
			small = false
		}
		for nextRoom, _ := range caveMap[room] {
			if (START != nextRoom) {
				if strings.ToUpper(nextRoom) == nextRoom || visitedC[nextRoom] == 0 || small {
					count += findPaths(nextRoom, visitedC, caveMap, small, path)
				}
			}
		}
 	}

 	return count
}

func main() {
	caveMap := readMap("input.txt")
	visited := map[string]int{}
	paths := findPaths(START, visited, caveMap, true, "")


	fmt.Println((paths))
}