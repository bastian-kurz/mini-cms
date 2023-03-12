package domain

import (
	"github.com/bastian-kurz/mini-cms/api"
	"gorm.io/gorm"
)

type Repository struct {
	db *gorm.DB
}

func NewRepository(db *gorm.DB) api.ApiRepositoryInterface {
	return &Repository{
		db: db,
	}
}

func (r Repository) GetById(id int, entity any) (*gorm.DB, error) {
	res := r.db.First(entity, id)
	return res, res.Error
}

func (r Repository) GetList(entity any) (*gorm.DB, error) {
	res := r.db.Find(entity)
	return res, res.Error
}

func (r Repository) Create(entity any) (*gorm.DB, error) {
	res := r.db.Create(entity)
	return res, res.Error
}

func (r Repository) Delete(id int, entity any) (*gorm.DB, error) {
	res := r.db.Delete(entity, id)
	return res, res.Error
}

func (r Repository) Update(entity any) (*gorm.DB, error) {
	res := r.db.Save(entity)

	return res, res.Error
}
