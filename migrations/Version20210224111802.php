<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224111802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_history (id INT AUTO_INCREMENT NOT NULL, updated_at DATETIME NOT NULL, uuid_game_session CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', id_user INT NOT NULL, id_game INT NOT NULL, id_chapter INT NOT NULL, id_chapter_element INT NOT NULL, id_kata INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_session (id INT AUTO_INCREMENT NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', id_user INT NOT NULL, id_game INT NOT NULL, id_chapter INT NOT NULL, id_chapter_element INT NOT NULL, id_kata INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_history');
        $this->addSql('DROP TABLE game_session');
    }
}
