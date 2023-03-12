package controller_test

import (
	"bytes"
	"encoding/json"
	"github.com/bastian-kurz/mini-cms/integrationtest"
	"github.com/bastian-kurz/mini-cms/internal/entity"
	is2 "github.com/matryer/is"
	"net/http"
	"strconv"
	"testing"
)

type testData struct {
	Data entity.Content `json:"data"`
}

func TestContent(t *testing.T) {
	integrationtest.SkipIfShort(t)
	is := is2.New(t)
	cleanup := integrationtest.CreateServer()
	defer cleanup()

	var d testData

	t.Run("/api/content create item", func(t *testing.T) {
		body := []byte(`{"isoCode":"UN","title":"Unit-Test","text":"Unit-Test-Text"}`)
		r, err := http.NewRequest("POST", "http://localhost:8085/api/content", bytes.NewBuffer(body))
		r.Header.Set("Content-Type", "application/json")

		client := &http.Client{}
		resp, _ := client.Do(r)
		if err != nil {
			panic(err)
		}
		defer resp.Body.Close()

		err = json.NewDecoder(resp.Body).Decode(&d)

		if err != nil {
			panic(err)
		}
		is.NoErr(err)
		is.Equal(resp.StatusCode, http.StatusCreated)
		is.Equal("UN", d.Data.IsoCode)
		is.Equal("Unit-Test", d.Data.Title)
		is.Equal("Unit-Test-Text", d.Data.Text)
	})

	contentId := strconv.Itoa(d.Data.ID)

	t.Run("PATCH /api/content/{id} update item", func(t *testing.T) {
		body := []byte(`{"isoCode":"UM","title":"Unit-Test2","text":"Unit-Test-Text3"}`)
		r, err := http.NewRequest("PATCH", "http://localhost:8085/api/content/"+contentId, bytes.NewBuffer(body))
		r.Header.Set("Content-Type", "application/json")
		client := &http.Client{}
		resp, _ := client.Do(r)
		if err != nil {
			panic(err)
		}
		defer resp.Body.Close()

		err = json.NewDecoder(resp.Body).Decode(&d)

		if err != nil {
			panic(err)
		}
		is.NoErr(err)
		is.Equal(resp.StatusCode, http.StatusOK)
		is.Equal("UM", d.Data.IsoCode)
		is.Equal("Unit-Test2", d.Data.Title)
		is.Equal("Unit-Test-Text3", d.Data.Text)
	})

	t.Run("GET /api/content/{id} get one item", func(t *testing.T) {

		resp, err := http.Get("http://localhost:8085/api/content/" + contentId)
		is.NoErr(err)
		is.Equal(http.StatusOK, resp.StatusCode)
	})

	t.Run("GET /api/content/999999 error", func(t *testing.T) {
		res, err := http.Get("http://localhost:8085/api/content/999999")
		is.NoErr(err)
		is.Equal(http.StatusNotFound, res.StatusCode)
	})

	t.Run("GET /api/content list items", func(t *testing.T) {
		res, err := http.Get("http://localhost:8085/api/content")
		is.NoErr(err)
		is.Equal(http.StatusOK, res.StatusCode)
	})

	t.Run("DELETE /api/content/{id} delete item", func(t *testing.T) {
		r, _ := http.NewRequest(http.MethodDelete, "http://localhost:8085/api/content/"+contentId, nil)
		r.Header.Set("Content-Type", "application/json")
		client := &http.Client{}
		resp, err := client.Do(r)
		is.NoErr(err)
		is.Equal(resp.StatusCode, http.StatusNoContent)
	})
}
