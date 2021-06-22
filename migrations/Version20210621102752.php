<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621102752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move from SQLite to PostgreSQL';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE feed_source_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, source_id INT NOT NULL, title VARCHAR(255) NOT NULL, url TEXT NOT NULL, excerpt TEXT NOT NULL, last_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_23A0E66953C1C61 ON article (source_id)');
        $this->addSql('CREATE TABLE feed_source (id INT NOT NULL, name VARCHAR(255) NOT NULL, url TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE TABLE user_feed_source (user_id INT NOT NULL, feed_source_id INT NOT NULL, PRIMARY KEY(user_id, feed_source_id))');
        $this->addSql('CREATE INDEX IDX_34B3C612A76ED395 ON user_feed_source (user_id)');
        $this->addSql('CREATE INDEX IDX_34B3C612DDAEFFBD ON user_feed_source (feed_source_id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66953C1C61 FOREIGN KEY (source_id) REFERENCES feed_source (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_feed_source ADD CONSTRAINT FK_34B3C612A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_feed_source ADD CONSTRAINT FK_34B3C612DDAEFFBD FOREIGN KEY (feed_source_id) REFERENCES feed_source (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_23A0E66953C1C61');
        $this->addSql('ALTER TABLE user_feed_source DROP CONSTRAINT FK_34B3C612DDAEFFBD');
        $this->addSql('ALTER TABLE user_feed_source DROP CONSTRAINT FK_34B3C612A76ED395');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE feed_source_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE feed_source');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_feed_source');
    }
}
