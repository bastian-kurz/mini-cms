<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230310162857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $adminPw = '$2a$12$Ej1x5HDM1A0murPZTdP2re6khIrHX.BtclYkXqXWhCkDn0Z9JebAe';
        $userPw = '$2a$12$OiOYkzrxuKtIcVbti2s20.Yfx/iuwE1Iy8QiI5/Dk1H3NmXW63Krm';
        $contentDE = ['isoCode' => 'de', 'title' => 'impressum', 'text' => '<div><h1>DE-Impressum</h1></div>'];
        $contentEN = ['isoCode' => 'en', 'title' => 'imprint', 'text' => '<div><h1>EN-Imprint</h1></div>'];

        $this->addSql(
            "INSERT INTO mini_cms.`user` (email,password,secret,scopes,active,created_at,updated_at) VALUES 
    ('admin@admin.de',:adminPW,NULL,'ROLE_ADMIN,ROLE_USER',1,'2023-03-10 16:25:56',NULL)", ['adminPW' => $adminPw]);

        $this->addSql(
            "INSERT INTO mini_cms.`user` (email,password,secret,scopes,active,created_at,updated_at) VALUES 
    ('user@user.de',:userPW,NULL,'ROLE_USER',1,'2023-03-10 16:25:56',NULL)", ['userPW' => $userPw]);

        $this->addSql("
            INSERT INTO mini_cms.`content` (iso_code,title,text,created_at,updated_at) VALUES 
            (:isoCode, :title, :text, now(), now())", $contentDE);

        $this->addSql("
            INSERT INTO mini_cms.`content` (iso_code,title,text,created_at,updated_at) VALUES 
            (:isoCode, :title, :text, now(), now())", $contentEN);
    }
}
