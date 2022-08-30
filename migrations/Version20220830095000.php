<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830095000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, type INTEGER NOT NULL, emission_date DATETIME NOT NULL, expiration_date DATETIME DEFAULT NULL, description VARCHAR(1024) DEFAULT NULL, CONSTRAINT FK_BF5476CAF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BF5476CAF675F31B ON notification (author_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user_notification (user_id INTEGER NOT NULL, notification_id INTEGER NOT NULL, PRIMARY KEY(user_id, notification_id), CONSTRAINT FK_3F980AC8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3F980AC8EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3F980AC8A76ED395 ON user_notification (user_id)');
        $this->addSql('CREATE INDEX IDX_3F980AC8EF1A9D84 ON user_notification (notification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_notification');
    }
}
