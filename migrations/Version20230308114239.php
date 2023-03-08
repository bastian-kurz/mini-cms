<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230308114239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso_code` varchar(2) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_UN` (`iso_code`,`title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `content`;');
    }
}
