<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211121214558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE car_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE car_type_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car (id INT NOT NULL, car_type_id INT DEFAULT NULL, owner_id INT NOT NULL, title VARCHAR(255) NOT NULL, active BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_773DE69D96E7774F ON car (car_type_id)');
        $this->addSql('CREATE INDEX IDX_773DE69D7E3C61F9 ON car (owner_id)');
        $this->addSql('CREATE TABLE car_type (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rent (id INT NOT NULL, car_id INT NOT NULL, client_id INT NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2784DCCC3C6F69F ON rent (car_id)');
        $this->addSql('CREATE INDEX IDX_2784DCC19EB6921 ON rent (client_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, user_group_id INT DEFAULT NULL, last_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, middle_name VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D6491ED93D47 ON "user" (user_group_id)');
        $this->addSql('CREATE TABLE user_group (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D96E7774F FOREIGN KEY (car_type_id) REFERENCES car_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC19EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6491ED93D47 FOREIGN KEY (user_group_id) REFERENCES user_group (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rent DROP CONSTRAINT FK_2784DCCC3C6F69F');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT FK_773DE69D96E7774F');
        $this->addSql('ALTER TABLE car DROP CONSTRAINT FK_773DE69D7E3C61F9');
        $this->addSql('ALTER TABLE rent DROP CONSTRAINT FK_2784DCC19EB6921');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6491ED93D47');
        $this->addSql('DROP SEQUENCE car_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE car_type_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rent_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_group_id_seq CASCADE');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_type');
        $this->addSql('DROP TABLE rent');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_group');
    }
}
