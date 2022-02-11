<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211035424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE checkbox_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etiqueta_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lista_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE checkbox (id INT NOT NULL, lista_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, info VARCHAR(255) DEFAULT NULL, estado BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1E7B08ED6736D68F ON checkbox (lista_id)');
        $this->addSql('CREATE TABLE etiqueta (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, info VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lista (id INT NOT NULL, etiqueta_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, fecha DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FB9FEEEDD53DA3AB ON lista (etiqueta_id)');
        $this->addSql('COMMENT ON COLUMN lista.fecha IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE checkbox ADD CONSTRAINT FK_1E7B08ED6736D68F FOREIGN KEY (lista_id) REFERENCES lista (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lista ADD CONSTRAINT FK_FB9FEEEDD53DA3AB FOREIGN KEY (etiqueta_id) REFERENCES etiqueta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lista DROP CONSTRAINT FK_FB9FEEEDD53DA3AB');
        $this->addSql('ALTER TABLE checkbox DROP CONSTRAINT FK_1E7B08ED6736D68F');
        $this->addSql('DROP SEQUENCE checkbox_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etiqueta_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lista_id_seq CASCADE');
        $this->addSql('DROP TABLE checkbox');
        $this->addSql('DROP TABLE etiqueta');
        $this->addSql('DROP TABLE lista');
    }
}
