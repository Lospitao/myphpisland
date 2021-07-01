<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203111001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_chapter (game_id INT NOT NULL, chapter_id INT NOT NULL, INDEX IDX_6C43CA01E48FD905 (game_id), INDEX IDX_6C43CA01579F4768 (chapter_id), PRIMARY KEY(game_id, chapter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_chapter ADD CONSTRAINT FK_6C43CA01E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_chapter ADD CONSTRAINT FK_6C43CA01579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_chapter');
    }
}
