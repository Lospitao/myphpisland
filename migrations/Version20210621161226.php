<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621161226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Include Lesson 1 in Chapter 1';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (166, 1, 1, 1, 6);");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
