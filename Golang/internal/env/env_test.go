package env_test

import (
	"github.com/bastian-kurz/mini-cms/internal/env"
	is2 "github.com/matryer/is"
	"os"
	"testing"
)

func TestGetIntOrDefault(t *testing.T) {
	is := is2.New(t)

	t.Run("test without os env", func(t *testing.T) {
		res := env.GetIntOrDefault("TEST", 100)
		is.Equal(100, res)
	})

	t.Run("test with os env and correct int value", func(t *testing.T) {
		_ = os.Setenv("TEST1", "200")
		res := env.GetIntOrDefault("TEST1", 100)
		is.Equal(200, res)
	})

	t.Run("test with os env but incorrect int value", func(t *testing.T) {
		_ = os.Setenv("TEST2", "ABC")
		res := env.GetIntOrDefault("TEST2", 100)
		is.Equal(100, res)
	})
}

func TestGetStringOrDefault(t *testing.T) {
	is := is2.New(t)

	t.Run("test without os env", func(t *testing.T) {
		res := env.GetStringOrDefault("STRING", "miau")
		is.Equal("miau", res)
	})

	t.Run("test with os env", func(t *testing.T) {
		_ = os.Setenv("STRING", "wuff")
		res := env.GetStringOrDefault("STRING", "miau")
		is.Equal("wuff", res)
	})
}
