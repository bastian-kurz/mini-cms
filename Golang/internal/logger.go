package internal

import (
	"github.com/bastian-kurz/mini-cms/internal/env"
	"go.uber.org/zap"
	"log"
	"sync"
)

var once sync.Once
var logger *zap.Logger

func Log() *zap.Logger {
	once.Do(func() {
		appEnv := env.GetStringOrDefault("APP_ENV", "develop")
		switch appEnv {
		case "develop":
			l, err := zap.NewDevelopment()
			if err != nil {
				log.Fatal(err)
			}

			logger = l
		default:
			logger = zap.NewNop()
		}
	})

	return logger
}
