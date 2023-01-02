<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102114839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artistes DROP FOREIGN KEY artistes_ibfk_1');
        $this->addSql('ALTER TABLE sites DROP FOREIGN KEY sites_ibfk_1');
        $this->addSql('ALTER TABLE category_articles DROP FOREIGN KEY category_articles_ibfk_1');
        $this->addSql('DROP TABLE artistes');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE count_view_article');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE click_by_day');
        $this->addSql('DROP TABLE count_look_movies');
        $this->addSql('DROP TABLE version');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE alert');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE visitor_by_day');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE article_img');
        $this->addSql('DROP TABLE category_articles');
        $this->addSql('DROP INDEX category_id ON articles');
        $this->addSql('ALTER TABLE articles DROP created, DROP modif, DROP category_id, DROP activHome, CHANGE subtitle subtitle VARCHAR(150) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE exploitant CHANGE name name VARCHAR(100) NOT NULL, CHANGE logo logo VARCHAR(20) DEFAULT NULL, CHANGE mail mail VARCHAR(100) NOT NULL, CHANGE siren siren VARCHAR(100) DEFAULT NULL, CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(20) DEFAULT NULL, CHANGE zipcode zipcode VARCHAR(5) DEFAULT NULL');
        $this->addSql('ALTER TABLE pages DROP subtitle, DROP slug, DROP description, DROP img, DROP created, DROP modif, DROP activ, CHANGE title title VARCHAR(50) NOT NULL, CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE partner DROP created, CHANGE img img VARCHAR(150) NOT NULL');
        $this->addSql('ALTER TABLE visitor CHANGE ip ip VARCHAR(16) NOT NULL, CHANGE device device LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artistes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, description TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, img VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, img_background VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, stop INT DEFAULT NULL, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE maintenance (activ INT DEFAULT NULL) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE count_view_article (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, nb INT DEFAULT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, slug VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, subtitle VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, img VARCHAR(150) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, img_background VARCHAR(150) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, content TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modif DATETIME DEFAULT NULL, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE click_by_day (date DATETIME NOT NULL, total INT DEFAULT NULL, article_id INT NOT NULL, INDEX article_id (article_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE count_look_movies (nb INT DEFAULT NULL, fk_movie INT NOT NULL) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE version (ref VARCHAR(10) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, install DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modif DATETIME DEFAULT NULL) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, list_menu INT NOT NULL, sub_menu INT DEFAULT NULL, title VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, url VARCHAR(150) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, img VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, page_id INT DEFAULT NULL, oder INT DEFAULT NULL, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, description TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, content TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modif DATETIME DEFAULT NULL, article_id INT DEFAULT NULL, artiste_id INT DEFAULT NULL, site_id INT DEFAULT NULL, stop INT DEFAULT NULL, activ INT DEFAULT NULL, INDEX artiste_id (artiste_id), INDEX site_id (site_id), INDEX article_id (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, lastname VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, email VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, password VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modif DATETIME DEFAULT NULL, law LONGTEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, banish INT DEFAULT NULL, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE alert (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, content TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, fk_page INT DEFAULT NULL, fk_article INT DEFAULT NULL, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE setting (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, description TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, value TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE visitor_by_day (total INT NOT NULL, day DATE NOT NULL) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, img VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, url VARCHAR(50) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, activ INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE article_img (id INT AUTO_INCREMENT NOT NULL, img VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, article_id INT NOT NULL, activ INT DEFAULT NULL, INDEX article_id (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE category_articles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_general_ci`, description TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, activ INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artistes ADD CONSTRAINT artistes_ibfk_1 FOREIGN KEY (id) REFERENCES movies (artiste_id)');
        $this->addSql('ALTER TABLE sites ADD CONSTRAINT sites_ibfk_1 FOREIGN KEY (id) REFERENCES movies (site_id)');
        $this->addSql('ALTER TABLE category_articles ADD CONSTRAINT category_articles_ibfk_1 FOREIGN KEY (id) REFERENCES articles (category_id)');
        $this->addSql('ALTER TABLE visitor CHANGE ip ip VARCHAR(20) NOT NULL, CHANGE device device TEXT NOT NULL');
        $this->addSql('ALTER TABLE partner ADD created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE img img VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE pages ADD subtitle VARCHAR(255) DEFAULT NULL, ADD slug VARCHAR(255) NOT NULL, ADD description TEXT DEFAULT NULL, ADD img VARCHAR(150) DEFAULT NULL, ADD created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD modif DATETIME DEFAULT NULL, ADD activ INT DEFAULT NULL, CHANGE title title VARCHAR(100) NOT NULL, CHANGE content content TEXT NOT NULL');
        $this->addSql('ALTER TABLE exploitant CHANGE name name VARCHAR(150) NOT NULL, CHANGE logo logo VARCHAR(100) NOT NULL, CHANGE mail mail VARCHAR(255) NOT NULL, CHANGE siren siren INT DEFAULT NULL, CHANGE adress adress VARCHAR(100) DEFAULT NULL, CHANGE city city VARCHAR(100) DEFAULT NULL, CHANGE zipcode zipcode INT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD modif DATETIME DEFAULT NULL, ADD category_id INT NOT NULL, ADD activHome INT DEFAULT NULL, CHANGE subtitle subtitle VARCHAR(200) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE content content TEXT NOT NULL');
        $this->addSql('CREATE INDEX category_id ON articles (category_id)');
    }
}
