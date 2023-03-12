package content

import (
	"github.com/bastian-kurz/mini-cms/api"
	"github.com/bastian-kurz/mini-cms/api/request"
	"github.com/bastian-kurz/mini-cms/api/response"
	"github.com/bastian-kurz/mini-cms/internal/entity"
	"github.com/go-chi/render"
	"net/http"
)

type ContentService struct {
	repo api.ApiRepositoryInterface
}

func NewContentService(repo api.ApiRepositoryInterface) api.ApiServiceInterface {
	return &ContentService{
		repo: repo,
	}
}

func (s *ContentService) Get(w http.ResponseWriter, r *http.Request) {
	var content entity.Content
	contentId := r.Context().Value("contentId").(int)

	_, err := s.repo.GetById(contentId, &content)
	if err != nil {
		_ = render.Render(w, r, response.ErrorResourceNotFound(err, contentId))
		return
	}

	render.Status(r, http.StatusOK)
	_ = render.Render(w, r, &response.DetailResponse{Data: content})
}

func (s *ContentService) List(w http.ResponseWriter, r *http.Request) {
	var contents []entity.Content
	_, err := s.repo.GetList(&contents)
	if err != nil {
		_ = render.Render(w, r, response.ErrorInvalidServerError(err))
		return
	}

	render.Status(r, http.StatusOK)
	_ = render.Render(w, r, &response.ListResponse{Page: 1, Total: len(contents), Data: contents})
}

func (s *ContentService) Create(w http.ResponseWriter, r *http.Request) {
	var content entity.Content

	if err := render.Bind(r, &content); err != nil {
		_ = render.Render(w, r, response.ErrorInvalidRequest(err))
		return
	}

	if err := request.IsValidStruct(content); err != nil {
		_ = render.Render(w, r, response.ErrorInvalidRequest(err))
		return
	}

	_, err := s.repo.Create(&content)
	if err != nil {
		_ = render.Render(w, r, response.ErrorInvalidServerError(err))
		return
	}

	render.Status(r, http.StatusCreated)
	_ = render.Render(w, r, &response.DetailResponse{Data: content})
}

func (s *ContentService) Update(w http.ResponseWriter, r *http.Request) {
	var content entity.Content

	contentId := r.Context().Value("contentId").(int)
	_, err := s.repo.GetById(contentId, &content)
	if err != nil {
		_ = render.Render(w, r, response.ErrorResourceNotFound(err, contentId))
		return
	}

	if err := render.Bind(r, &content); err != nil {
		_ = render.Render(w, r, response.ErrorInvalidRequest(err))
		return
	}

	if err := request.IsValidStruct(content); err != nil {
		_ = render.Render(w, r, response.ErrorInvalidRequest(err))
		return
	}

	_, err = s.repo.Update(&content)
	if err != nil {
		_ = render.Render(w, r, response.ErrorInvalidServerError(err))
		return
	}

	render.Status(r, http.StatusOK)
	_ = render.Render(w, r, &response.DetailResponse{Data: content})
}

func (s *ContentService) Delete(w http.ResponseWriter, r *http.Request) {
	var content entity.Content
	contentId := r.Context().Value("contentId").(int)
	_, err := s.repo.Delete(contentId, &content)
	if err != nil {
		_ = render.Render(w, r, response.ErrorInvalidServerError(err))
		return
	}

	render.Status(r, http.StatusNoContent)
	_ = render.Render(w, r, &response.NoContentResponse{})
}
