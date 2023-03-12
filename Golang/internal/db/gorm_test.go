package db_test

import (
	db2 "github.com/bastian-kurz/mini-cms/internal/db"
	is2 "github.com/matryer/is"
	"testing"
)

func TestConnect(t *testing.T) {
	t.Run("test if database connection could be established", func(t *testing.T) {
		is := is2.New(t)

		db := db2.Connect()
		dbCon, err := db.DB()
		is.NoErr(err)
		is.Equal(nil, dbCon.Ping())
		_ = dbCon.Close()
	})
}
