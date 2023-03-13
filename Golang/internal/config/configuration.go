package config

import (
	"fmt"
	"github.com/bastian-kurz/mini-cms/internal"
	"github.com/bastian-kurz/mini-cms/internal/env"
	"github.com/bastian-kurz/mini-cms/internal/logger"
	"github.com/spf13/viper"
	"go.uber.org/zap"
	"strings"
	"sync"
)

var configOnce sync.Once
var systemConfiguration *SystemConfiguration

type SystemConfiguration struct {
	MYSQL struct {
		Host      string `mapstructure:"host"`
		Database  string `mapstructure:"database"`
		User      string `mapstructure:"user"`
		Password  string `mapstructure:"password"`
		Charset   string `mapstructure:"charset"`
		ParseTime string `mapstructure:"parseTime"`
		Loc       string `mapstructure:"loc"`
	}
}

func Config() *SystemConfiguration {
	configOnce.Do(func() {
		conf := viper.New()

		confName := fmt.Sprintf("%s.yaml", getConfigFilePath())

		conf.SetConfigFile(confName)
		conf.SetConfigType("yaml")

		conf.SetEnvPrefix("systemConfiguration")
		conf.SetEnvKeyReplacer(strings.NewReplacer(".", "-"))
		conf.AutomaticEnv()

		if err := conf.ReadInConfig(); err != nil {
			logger.Log().Fatal("error, could not read system configuration file", zap.Error(err))
		}

		systemConfiguration = &SystemConfiguration{}
		err := conf.Unmarshal(systemConfiguration)

		if err != nil {
			logger.Log().Fatal("error, could not assign system configuration to struct", zap.Error(err))
		}
	})

	return systemConfiguration
}

func getEnv() string {
	return env.GetStringOrDefault("APP_ENV", "dev")
}

func getConfigFilePath() string {
	return env.GetStringOrDefault("APP_CONFIGURATION_PATH", internal.ConfigDir+getEnv())
}
