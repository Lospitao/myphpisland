<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621161012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Include katas 1-17 in lesson 1';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `lesson_kata` (`lesson_id`, `kata_id`, `id`, `position`) VALUES
    (9, 44, 175, 0),
(9, 45, 176, 1),
(9, 46, 177, 2),
(9, 47, 178, 3),
(9, 48, 179, 4),
(9, 49, 180, 5),
(9, 51, 181, 6),
(9, 53, 182, 7),
(9, 55, 183, 8),
(9, 57, 184, 9),
(9, 59, 185, 10),
(9, 60, 186, 11),
(9, 61, 187, 12),
(9, 62, 188, 13),
(9, 83, 189, 14),
(9, 85, 190, 15),
(9, 86, 191, 16)");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
