<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611141027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Article entity, User relation with FeedSource';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, source_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, url CLOB NOT NULL, excerpt CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_23A0E66953C1C61 ON article (source_id)');
        $this->addSql('CREATE TABLE user_feed_source (user_id INTEGER NOT NULL, feed_source_id INTEGER NOT NULL, PRIMARY KEY(user_id, feed_source_id))');
        $this->addSql('CREATE INDEX IDX_34B3C612A76ED395 ON user_feed_source (user_id)');
        $this->addSql('CREATE INDEX IDX_34B3C612DDAEFFBD ON user_feed_source (feed_source_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE user_feed_source');
    }
}
