package config_test

import (
	"github.com/bastian-kurz/mini-cms/internal/config"
	is2 "github.com/matryer/is"
	"testing"
)

func TestConfig(t *testing.T) {
	t.Run("test load configuration", func(t *testing.T) {
		is := is2.New(t)
		is.Equal("mini_cms", config.Config().MYSQL.Database)
	})
}
