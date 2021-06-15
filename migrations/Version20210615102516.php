<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210615102516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add last_modified';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E66953C1C61');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, source_id, title, url, excerpt FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, source_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, url CLOB NOT NULL COLLATE BINARY, excerpt CLOB NOT NULL COLLATE BINARY, last_modified DATETIME DEFAULT NULL, CONSTRAINT FK_23A0E66953C1C61 FOREIGN KEY (source_id) REFERENCES feed_source (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, source_id, title, url, excerpt) SELECT id, source_id, title, url, excerpt FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66953C1C61 ON article (source_id)');
        $this->addSql('DROP INDEX IDX_34B3C612DDAEFFBD');
        $this->addSql('DROP INDEX IDX_34B3C612A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_feed_source AS SELECT user_id, feed_source_id FROM user_feed_source');
        $this->addSql('DROP TABLE user_feed_source');
        $this->addSql('CREATE TABLE user_feed_source (user_id INTEGER NOT NULL, feed_source_id INTEGER NOT NULL, PRIMARY KEY(user_id, feed_source_id), CONSTRAINT FK_34B3C612A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_34B3C612DDAEFFBD FOREIGN KEY (feed_source_id) REFERENCES feed_source (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_feed_source (user_id, feed_source_id) SELECT user_id, feed_source_id FROM __temp__user_feed_source');
        $this->addSql('DROP TABLE __temp__user_feed_source');
        $this->addSql('CREATE INDEX IDX_34B3C612DDAEFFBD ON user_feed_source (feed_source_id)');
        $this->addSql('CREATE INDEX IDX_34B3C612A76ED395 ON user_feed_source (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E66953C1C61');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, source_id, title, url, excerpt FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, source_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, url CLOB NOT NULL, excerpt CLOB NOT NULL)');
        $this->addSql('INSERT INTO article (id, source_id, title, url, excerpt) SELECT id, source_id, title, url, excerpt FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66953C1C61 ON article (source_id)');
        $this->addSql('DROP INDEX IDX_34B3C612A76ED395');
        $this->addSql('DROP INDEX IDX_34B3C612DDAEFFBD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_feed_source AS SELECT user_id, feed_source_id FROM user_feed_source');
        $this->addSql('DROP TABLE user_feed_source');
        $this->addSql('CREATE TABLE user_feed_source (user_id INTEGER NOT NULL, feed_source_id INTEGER NOT NULL, PRIMARY KEY(user_id, feed_source_id))');
        $this->addSql('INSERT INTO user_feed_source (user_id, feed_source_id) SELECT user_id, feed_source_id FROM __temp__user_feed_source');
        $this->addSql('DROP TABLE __temp__user_feed_source');
        $this->addSql('CREATE INDEX IDX_34B3C612A76ED395 ON user_feed_source (user_id)');
        $this->addSql('CREATE INDEX IDX_34B3C612DDAEFFBD ON user_feed_source (feed_source_id)');
    }
}
