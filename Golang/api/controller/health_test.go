package controller_test

import (
	"github.com/bastian-kurz/mini-cms/integrationtest"
	is2 "github.com/matryer/is"
	"net/http"
	"testing"
)

func TestHealth(t *testing.T) {
	integrationtest.SkipIfShort(t)

	t.Run("start the server and test /health endpoint", func(t *testing.T) {
		is := is2.New(t)

		cleanup := integrationtest.CreateServer()
		defer cleanup()

		resp, err := http.Get("http://localhost:8085/health")
		is.NoErr(err)
		is.Equal(http.StatusOK, resp.StatusCode)
	})
}
