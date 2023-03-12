package db

import (
	"fmt"
	"github.com/bastian-kurz/mini-cms/internal/config"
	"github.com/bastian-kurz/mini-cms/internal/logger"
	"go.uber.org/zap"
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

// Connect tries to connect to the mysql database by the credentials and configuration given
// by the configuration yaml file in the system. If connection is successful it will return *gorm.DB,
// if not it will throw a fatal error
func Connect() *gorm.DB {
	// refer https://github.com/go-sql-driver/mysql#dsn-data-source-name for details
	dsn := fmt.Sprintf(
		"%s:%s@tcp(%s)/%s?charset=%s&parseTime=%s&loc=%s",
		config.Config().MYSQL.User,
		config.Config().MYSQL.Password,
		config.Config().MYSQL.Host,
		config.Config().MYSQL.Database,
		config.Config().MYSQL.Charset,
		config.Config().MYSQL.ParseTime,
		config.Config().MYSQL.Loc,
	)

	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		logger.Log().Fatal("error, connection to database failed", zap.Error(err))
	}

	return db
}
