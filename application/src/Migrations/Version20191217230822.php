<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217230822 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE private_user_information');
        $this->addSql('DROP TABLE identity');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE biography');
    }
}
