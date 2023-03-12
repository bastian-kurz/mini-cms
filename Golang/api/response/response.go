package response

import "net/http"

type DetailResponse struct {
	Data any `json:"data"`
}

func (dr *DetailResponse) Render(w http.ResponseWriter, req *http.Request) error {
	return nil
}

type ListResponse struct {
	Page  int `json:"page"`
	Total int `json:"total"`
	Data  any `json:"data"`
}

func (lr *ListResponse) Render(w http.ResponseWriter, req *http.Request) error {
	return nil
}

type NoContentResponse struct {
}

func (ncr *NoContentResponse) Render(w http.ResponseWriter, req *http.Request) error {
	return nil
}
