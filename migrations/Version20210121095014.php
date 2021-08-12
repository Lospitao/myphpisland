<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210121095014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_chapter DROP FOREIGN KEY FK_6C43CA01579F4768');
        $this->addSql('ALTER TABLE game_chapter DROP FOREIGN KEY FK_6C43CA01E48FD905');
        $this->addSql('ALTER TABLE game_chapter ADD id INT AUTO_INCREMENT NOT NULL, ADD position VARCHAR(255) NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE game_chapter ADD CONSTRAINT FK_6C43CA01579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE game_chapter ADD CONSTRAINT FK_6C43CA01E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_chapter MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE game_chapter DROP FOREIGN KEY FK_6C43CA01E48FD905');
        $this->addSql('ALTER TABLE game_chapter DROP FOREIGN KEY FK_6C43CA01579F4768');
        $this->addSql('ALTER TABLE game_chapter DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE game_chapter DROP id, DROP position');
        $this->addSql('ALTER TABLE game_chapter ADD CONSTRAINT FK_6C43CA01E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_chapter ADD CONSTRAINT FK_6C43CA01579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_chapter ADD PRIMARY KEY (game_id, chapter_id)');
    }
}
