<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127123159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE chapter_element_type RENAME COLUMN chapter_element to name');
        $this->addSql('ALTER TABLE `chapter_element_type` CHANGE COLUMN `chapter_element` `name` VARCHAR(255) NULL DEFAULT NULL COLLATE \'utf8mb4_unicode_ci\' AFTER `id`;
');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
