<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201106110052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kata (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, editor_code LONGTEXT DEFAULT NULL, test_code LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, kata_title VARCHAR(255) NOT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_kata (lesson_id INT NOT NULL, kata_id INT NOT NULL, INDEX IDX_CCE12551CDF80196 (lesson_id), INDEX IDX_CCE12551C1BDD1D5 (kata_id), PRIMARY KEY(lesson_id, kata_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ambient_sound VARCHAR(255) DEFAULT NULL, dialog VARCHAR(255) DEFAULT NULL, background_image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, signup_date DATETIME NOT NULL, email VARCHAR(255) NOT NULL, profile_pic VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lesson_kata ADD CONSTRAINT FK_CCE12551CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_kata ADD CONSTRAINT FK_CCE12551C1BDD1D5 FOREIGN KEY (kata_id) REFERENCES kata (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson_kata DROP FOREIGN KEY FK_CCE12551C1BDD1D5');
        $this->addSql('ALTER TABLE lesson_kata DROP FOREIGN KEY FK_CCE12551CDF80196');
        $this->addSql('DROP TABLE kata');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE lesson_kata');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE user');
    }
}
