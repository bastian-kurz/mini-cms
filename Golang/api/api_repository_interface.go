package api

import "gorm.io/gorm"

type ApiRepositoryInterface interface {
	GetById(id int, entity any) (*gorm.DB, error)
	GetList(entity any) (*gorm.DB, error)
	Create(entity any) (*gorm.DB, error)
	Delete(id int, entity any) (*gorm.DB, error)
	Update(entity any) (*gorm.DB, error)
}
