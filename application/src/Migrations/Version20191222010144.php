<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191222010144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE private_user_information (private_user_id VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, middle_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, pen_name VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) DEFAULT NULL, date_added DATETIME DEFAULT NULL, date_modified DATETIME DEFAULT NULL, PRIMARY KEY(private_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity (identity_id VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(identity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (user_id BIGINT AUTO_INCREMENT NOT NULL, user_name VARCHAR(255) NOT NULL, UNIQUE INDEX unique_users (user_name), PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE biography (biography_id VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, PRIMARY KEY(biography_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id BIGINT AUTO_INCREMENT NOT NULL, chapter_id BIGINT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, body LONGTEXT DEFAULT NULL, INDEX IDX_D8698A76579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id BIGINT AUTO_INCREMENT NOT NULL, book_id BIGINT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, body LONGTEXT DEFAULT NULL, INDEX IDX_F981B52E16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id BIGINT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, body LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76579F4768');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E16A2B381');
        $this->addSql('DROP TABLE private_user_information');
        $this->addSql('DROP TABLE identity');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE biography');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE book');
    }
}
