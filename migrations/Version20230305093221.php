<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305093221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `user` (
  `id` varchar(32) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(60) NOT NULL,
  `secret` varchar(128) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updater` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_FK` (`updater`),
  KEY `user_email_IDX` (`email`) USING BTREE,
  CONSTRAINT `user_FK` FOREIGN KEY (`updater`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
    }
}
