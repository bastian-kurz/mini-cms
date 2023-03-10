package server

import "github.com/bastian-kurz/mini-cms/api"

func (s *Server) SetupRoutes() {
	api.Health(s.mux)
}
