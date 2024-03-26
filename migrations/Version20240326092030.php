<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240326092030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sb_critiques (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_film INTEGER NOT NULL, note INTEGER DEFAULT NULL --entre 0 et 5
        , avis CLOB NOT NULL, CONSTRAINT FK_A9BDCD20964A220 FOREIGN KEY (id_film) REFERENCES sb_films (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_A9BDCD20964A220 ON sb_critiques (id_film)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sb_films AS SELECT id, titre, annee, enstock, prix, quantite FROM sb_films');
        $this->addSql('DROP TABLE sb_films');
        $this->addSql('CREATE TABLE sb_films (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, annee INTEGER NOT NULL --année de sortie
        , enstock BOOLEAN DEFAULT 1 NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO sb_films (id, titre, annee, enstock, prix, quantite) SELECT id, titre, annee, enstock, prix, quantite FROM __temp__sb_films');
        $this->addSql('DROP TABLE __temp__sb_films');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sb_critiques');
        $this->addSql('CREATE TEMPORARY TABLE __temp__sb_films AS SELECT id, titre, annee, enstock, prix, quantite FROM sb_films');
        $this->addSql('DROP TABLE sb_films');
        $this->addSql('CREATE TABLE sb_films (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, annee INTEGER NOT NULL --année de sortie
        , enstock BOOLEAN DEFAULT 1 NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO sb_films (id, titre, annee, enstock, prix, quantite) SELECT id, titre, annee, enstock, prix, quantite FROM __temp__sb_films');
        $this->addSql('DROP TABLE __temp__sb_films');
    }
}
