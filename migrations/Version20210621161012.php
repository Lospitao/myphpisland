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
        $lessonSql = <<<'EOD1'
            INSERT INTO `lesson` (`id`,`title`,`uuid`) VALUES (1,'Lesson 1','741e2eb4-d928-4f33-8b88-35d1ee994cb5');
EOD1;
        $this->addSql($lessonSql);

        $this->addSql("INSERT INTO `lesson_kata` (`lesson_id`, `kata_id`, `id`, `position`) VALUES
    (1, 44, 175, 0),
(1, 45, 176, 1),
(1, 46, 177, 2),
(1, 47, 178, 3),
(1, 48, 179, 4),
(1, 49, 180, 5),
(1, 51, 181, 6),
(1, 53, 182, 7),
(1, 55, 183, 8),
(1, 57, 184, 9),
(1, 59, 185, 10),
(1, 60, 186, 11),
(1, 61, 187, 12),
(1, 62, 188, 13),
(1, 83, 189, 14),
(1, 85, 190, 15),
(1, 86, 191, 16)");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
