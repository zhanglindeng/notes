### [参考](http://stackoverflow.com/questions/22892120/how-to-generate-a-random-string-of-a-fixed-length-in-golang)

```go
package main

import (
	"flag"
	"fmt"
	"math/rand"
	"time"
)

var letterRunes = []rune("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ")

func init() {
	rand.Seed(time.Now().UnixNano())

}

func main() {
	length := flag.Int("length", 32, "The random string length (default 32)")
	flag.Parse()
	b := make([]rune, *length)
	for i := range b {
		b[i] = letterRunes[rand.Intn(len(letterRunes))]
	}
	fmt.Println(string(b))
}

```
