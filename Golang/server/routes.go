package server

import (
	"github.com/bastian-kurz/mini-cms/api/controller"
)

func (s *Server) SetupRoutes() {
	controller.Health(s.mux)
}
