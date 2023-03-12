package entity

import (
	"errors"
	"net/http"
)

type Content struct {
	BaseModel
	IsoCode string `json:"isoCode" validate:"required,alpha,len=2,min=2"`
	Title   string `json:"title" validate:"required,ascii,max=100,min=1"`
	Text    string `json:"text" validate:"required,ascii"`
}

func (c *Content) TableName() string {
	return "content"
}

func (c *Content) Bind(r *http.Request) error {
	if c == nil {
		return errors.New("missing required fields")
	}

	return nil
}
