<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260517005252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accommodation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, description LONGTEXT DEFAULT NULL, category VARCHAR(100) NOT NULL, cadastur_code VARCHAR(100) DEFAULT NULL, address VARCHAR(255) NOT NULL, district VARCHAR(100) DEFAULT NULL, latitude NUMERIC(10, 8) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, rooms INT DEFAULT NULL, beds INT DEFAULT NULL, wifi TINYINT DEFAULT 0 NOT NULL, parking TINYINT DEFAULT 0 NOT NULL, accessibility TINYINT DEFAULT 0 NOT NULL, website VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, organization_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2D385412989D9B62 (slug), INDEX IDX_2D38541232C8A3DE (organization_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE data_source (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, type VARCHAR(100) NOT NULL, url VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, update_frequency VARCHAR(100) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3F744E6A989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE indicator (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, category VARCHAR(100) NOT NULL, value DOUBLE PRECISION NOT NULL, unit VARCHAR(50) DEFAULT NULL, reference_date DATE NOT NULL, source VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D1349DB3989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, description LONGTEXT DEFAULT NULL, type VARCHAR(100) NOT NULL, document_number VARCHAR(30) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, district VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT \'Olinda\' NOT NULL, state VARCHAR(2) DEFAULT \'PE\' NOT NULL, latitude NUMERIC(10, 8) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C1EE637C989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, post_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_53AD8F834B89032C (post_id), INDEX IDX_53AD8F83F675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE symfony_demo_post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, author_id INT NOT NULL, INDEX IDX_58A92E65F675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6ABC1CC44B89032C (post_id), INDEX IDX_6ABC1CC4BAD26311 (tag_id), PRIMARY KEY (post_id, tag_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE symfony_demo_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(191) NOT NULL, UNIQUE INDEX UNIQ_4D5855405E237E06 (name), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE symfony_demo_user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(191) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8FB094A1F85E0677 (username), UNIQUE INDEX UNIQ_8FB094A1E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tourism_event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, description LONGTEXT NOT NULL, category VARCHAR(100) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, location VARCHAR(255) NOT NULL, district VARCHAR(100) DEFAULT NULL, latitude NUMERIC(10, 8) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, expected_audience INT DEFAULT NULL, is_free TINYINT DEFAULT 1 NOT NULL, ticket_url VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, source VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, organization_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_6A1CC3CC989D9B62 (slug), INDEX IDX_6A1CC3CC32C8A3DE (organization_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tourist_guide (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cadastur_code VARCHAR(100) DEFAULT NULL, languages JSON DEFAULT NULL, specialties JSON DEFAULT NULL, phone VARCHAR(50) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, service_region VARCHAR(255) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, organization_id INT DEFAULT NULL, INDEX IDX_696AD74332C8A3DE (organization_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tourist_spot (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(191) NOT NULL, description LONGTEXT NOT NULL, history LONGTEXT DEFAULT NULL, category VARCHAR(100) NOT NULL, address VARCHAR(255) DEFAULT NULL, district VARCHAR(100) DEFAULT NULL, latitude NUMERIC(10, 8) NOT NULL, longitude NUMERIC(11, 8) NOT NULL, opening_hours VARCHAR(255) DEFAULT NULL, ticket_price NUMERIC(10, 2) DEFAULT NULL, accessibility TINYINT DEFAULT 0 NOT NULL, has_bathroom TINYINT DEFAULT 0 NOT NULL, has_parking TINYINT DEFAULT 0 NOT NULL, safety_level VARCHAR(50) DEFAULT NULL, source VARCHAR(100) DEFAULT NULL, active TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, organization_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_F1227811989D9B62 (slug), INDEX IDX_F122781132C8A3DE (organization_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE accommodation ADD CONSTRAINT FK_2D38541232C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE symfony_demo_comment ADD CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id)');
        $this->addSql('ALTER TABLE symfony_demo_comment ADD CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id)');
        $this->addSql('ALTER TABLE symfony_demo_post ADD CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id)');
        $this->addSql('ALTER TABLE symfony_demo_post_tag ADD CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE symfony_demo_post_tag ADD CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tourism_event ADD CONSTRAINT FK_6A1CC3CC32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE tourist_guide ADD CONSTRAINT FK_696AD74332C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE tourist_spot ADD CONSTRAINT FK_F122781132C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accommodation DROP FOREIGN KEY FK_2D38541232C8A3DE');
        $this->addSql('ALTER TABLE symfony_demo_comment DROP FOREIGN KEY FK_53AD8F834B89032C');
        $this->addSql('ALTER TABLE symfony_demo_comment DROP FOREIGN KEY FK_53AD8F83F675F31B');
        $this->addSql('ALTER TABLE symfony_demo_post DROP FOREIGN KEY FK_58A92E65F675F31B');
        $this->addSql('ALTER TABLE symfony_demo_post_tag DROP FOREIGN KEY FK_6ABC1CC44B89032C');
        $this->addSql('ALTER TABLE symfony_demo_post_tag DROP FOREIGN KEY FK_6ABC1CC4BAD26311');
        $this->addSql('ALTER TABLE tourism_event DROP FOREIGN KEY FK_6A1CC3CC32C8A3DE');
        $this->addSql('ALTER TABLE tourist_guide DROP FOREIGN KEY FK_696AD74332C8A3DE');
        $this->addSql('ALTER TABLE tourist_spot DROP FOREIGN KEY FK_F122781132C8A3DE');
        $this->addSql('DROP TABLE accommodation');
        $this->addSql('DROP TABLE data_source');
        $this->addSql('DROP TABLE indicator');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('DROP TABLE symfony_demo_tag');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('DROP TABLE tourism_event');
        $this->addSql('DROP TABLE tourist_guide');
        $this->addSql('DROP TABLE tourist_spot');
    }
}
