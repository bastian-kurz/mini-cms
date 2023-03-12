package response

import (
	"fmt"
	"github.com/go-chi/render"
	"net/http"
)

type Error struct {
	Err            error `json:"-"` // low-level runtime error
	HTTPStatusCode int   `json:"-"` // http response status code

	StatusText string `json:"status"`          // user-level status message
	AppCode    int64  `json:"code,omitempty"`  // application-specific error code
	ErrorText  string `json:"error,omitempty"` // application-level error message, for debugging
}

func (e *Error) Render(w http.ResponseWriter, r *http.Request) error {
	render.Status(r, e.HTTPStatusCode)
	return nil
}

func ErrorInvalidRequest(err error) render.Renderer {
	return &Error{
		Err:            err,
		HTTPStatusCode: http.StatusBadRequest,
		StatusText:     "Bad Request",
		ErrorText:      err.Error(),
	}
}

func ErrorResourceNotFound(err error, id int) render.Renderer {
	return &Error{
		Err:            err,
		HTTPStatusCode: http.StatusNotFound,
		StatusText:     "Resource Not Found",
		ErrorText:      err.Error() + fmt.Sprintf(" with id %d", id),
	}
}

func ErrorInvalidServerError(err error) render.Renderer {
	return &Error{
		Err:            err,
		HTTPStatusCode: http.StatusNotFound,
		StatusText:     "Invalid Server Error",
		ErrorText:      err.Error(),
	}
}
