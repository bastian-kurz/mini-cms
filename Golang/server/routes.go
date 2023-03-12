package server

import (
	"github.com/bastian-kurz/mini-cms/api/controller"
	"gorm.io/gorm"
)

func (s *Server) SetupRoutes(db *gorm.DB) {
	controller.Health(s.mux)
	controller.Content(s.mux, db)
}
