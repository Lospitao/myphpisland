<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111105327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson_kata DROP FOREIGN KEY FK_CCE12551C1BDD1D5');
        $this->addSql('ALTER TABLE lesson_kata DROP FOREIGN KEY FK_CCE12551CDF80196');
        $this->addSql('ALTER TABLE lesson_kata ADD id INT AUTO_INCREMENT NOT NULL, ADD position INT NOT NULL, CHANGE kata_id kata_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE lesson_kata ADD CONSTRAINT FK_CCE12551C1BDD1D5 FOREIGN KEY (kata_id) REFERENCES kata (id)');
        $this->addSql('ALTER TABLE lesson_kata ADD CONSTRAINT FK_CCE12551CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lesson_kata MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson_kata DROP FOREIGN KEY FK_CCE12551CDF80196');
        $this->addSql('ALTER TABLE lesson_kata DROP FOREIGN KEY FK_CCE12551C1BDD1D5');
        $this->addSql('ALTER TABLE lesson_kata DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE lesson_kata DROP id, DROP position, CHANGE kata_id kata_id INT NOT NULL');
        $this->addSql('ALTER TABLE lesson_kata ADD CONSTRAINT FK_CCE12551CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_kata ADD CONSTRAINT FK_CCE12551C1BDD1D5 FOREIGN KEY (kata_id) REFERENCES kata (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_kata ADD PRIMARY KEY (lesson_id, kata_id)');
    }
}
