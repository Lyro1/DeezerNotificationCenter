<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220831195644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notifiable_content (id INT AUTO_INCREMENT NOT NULL, disc VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, artist VARCHAR(255) DEFAULT NULL, cover VARCHAR(2048) DEFAULT NULL, link VARCHAR(2048) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, content_id INT DEFAULT NULL, author_id INT DEFAULT NULL, type INT NOT NULL, emission_date DATETIME NOT NULL, expiration_date DATETIME DEFAULT NULL, description VARCHAR(1024) DEFAULT NULL, INDEX IDX_BF5476CA84A0A3ED (content_id), INDEX IDX_BF5476CAF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_notification (id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, notification INT DEFAULT NULL, read_status TINYINT(1) NOT NULL, INDEX IDX_3F980AC88D93D649 (user), INDEX IDX_3F980AC8BF5476CA (notification), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA84A0A3ED FOREIGN KEY (content_id) REFERENCES notifiable_content (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC88D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_notification ADD CONSTRAINT FK_3F980AC8BF5476CA FOREIGN KEY (notification) REFERENCES notification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA84A0A3ED');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAF675F31B');
        $this->addSql('ALTER TABLE user_notification DROP FOREIGN KEY FK_3F980AC88D93D649');
        $this->addSql('ALTER TABLE user_notification DROP FOREIGN KEY FK_3F980AC8BF5476CA');
        $this->addSql('DROP TABLE notifiable_content');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_notification');
    }
}
