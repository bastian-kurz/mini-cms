package controller

import (
	"context"
	"errors"
	"github.com/bastian-kurz/mini-cms/api/domain"
	"github.com/bastian-kurz/mini-cms/api/domain/content"
	"github.com/bastian-kurz/mini-cms/api/response"
	"github.com/go-chi/chi/v5"
	"github.com/go-chi/render"
	"gorm.io/gorm"
	"net/http"
	"strconv"
)

func Content(r chi.Router, db *gorm.DB) {
	repository := domain.NewRepository(db)
	service := content.NewContentService(repository)

	r.Group(func(r chi.Router) {
		r.Route("/api/content", func(r chi.Router) {
			r.Get("/", service.List)
			r.Post("/", service.Create)
			r.Route("/{contentId}", func(r chi.Router) {
				r.Use(contentCtx)
				r.Get("/", service.Get)
				r.Patch("/", service.Update)
				r.Delete("/", service.Delete)
			})
		})
	})
}

func contentCtx(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		contentId := chi.URLParam(r, "contentId")
		if contentId == "" {
			_ = render.Render(w, r, response.ErrorInvalidRequest(errors.New("missing required, contentId parameter")))
		}

		id, _ := strconv.Atoi(contentId)
		ctx := context.WithValue(r.Context(), "contentId", id)
		next.ServeHTTP(w, r.WithContext(ctx))
	})
}
