<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230101104015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX category_id ON articles');
        $this->addSql('ALTER TABLE articles DROP created, DROP modif, DROP category_id, DROP activHome, CHANGE subtitle subtitle VARCHAR(150) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE pages DROP subtitle, DROP slug, DROP description, DROP img, DROP created, DROP modif, DROP activ, CHANGE title title VARCHAR(50) NOT NULL, CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(50) NOT NULL, ADD firstname VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pages ADD subtitle VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD description TEXT DEFAULT NULL, ADD img VARCHAR(150) DEFAULT NULL, ADD created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD modif DATETIME DEFAULT NULL, ADD activ INT DEFAULT NULL, CHANGE title title VARCHAR(100) NOT NULL, CHANGE content content TEXT NOT NULL');
        $this->addSql('ALTER TABLE articles ADD created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD modif DATETIME DEFAULT NULL, ADD category_id INT NOT NULL, ADD activHome INT DEFAULT NULL, CHANGE subtitle subtitle VARCHAR(200) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE content content TEXT NOT NULL');
        $this->addSql('CREATE INDEX category_id ON articles (category_id)');
        $this->addSql('ALTER TABLE user DROP lastname, DROP firstname');
    }
}
