package utils

import (
	"os"
	"strings"
)


func ReadLinesFromFile(path string) (out []string) {
	fileData, err := os.ReadFile(path)
	if err != nil {
		panic(err)
	}

	fileText := string(fileData)
	fileLines := strings.Split(fileText, "\n")

	var filtered []string
	for _, line := range fileLines {
		if len(strings.TrimSpace(line)) > 0 {
			filtered = append(filtered, line)
		}
	}
	return filtered
}
