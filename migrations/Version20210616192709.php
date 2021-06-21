<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616192709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create stages for chapter 1';
    }

    public function up(Schema $schema) : void
    {

        $this->addSql("INSERT INTO `game` (`id`,`title`,`uuid`) VALUES (1,'The secret of php island','58f514bc-3c26-4f35-8933-68521ba02f49');");
        $this->addSql("INSERT INTO `chapter` (`id`,`title`,`uuid`) VALUES (1,'Capítulo 1: Llegada a la isla','1eedf58e-664d-4f26-a4f5-8030efada7c9');");
        $this->addSql("INSERT INTO `stage` VALUES (1,'Escenario 1','83cb516f-87bc-4f1b-b159-c79bb1b4c9a9','ambient.mp3','dialog.mp3','background-image.jpeg'),(2,'Escenario 2','d5bda284-121a-4fa3-b7e9-44af1b50ebf9','ambient.mp3','dialog.mp3','background-image.jpeg'),(3,'Escenario 3','13392091-601d-4fed-9bfe-d351f330c4cc','ambient.mp3','dialog.mp3','background-image.jpeg'),(4,'Escenario 4','309a2235-adc4-4fe2-b174-8122aa835ef0','ambient.mp3','dialog.mp3','background-image.jpeg'),(5,'Escenario 5','689f6c01-facd-4fd1-a014-97e6af171c2d','ambient.mp3','dialog.mp3','background-image.jpeg'),(6,'Escenario 6','150fa609-426a-4f04-abcb-8720da959599','ambient.mp3','dialog.mp3','background-image.jpeg');");
        $this->addSql("INSERT INTO `game_chapter` (`game_id`,`chapter_id`,`id`,`position`) VALUES (1,1,1,'0');");
        $this->addSql("INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (1,1,2,1,0);
INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (2,1,2,2,1);
INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (3,1,2,3,2);
INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (4,1,2,4,3);
INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (5,1,2,5,4);
INSERT INTO `chapter_element` (`id`,`chapter_id`,`chapter_element_type`,`stage_or_lesson_id`,`position`) VALUES (6,1,2,6,5);");
        $this->addSql("INSERT INTO `lesson` (`id`, `title`, `uuid`) VALUES (9, 'Lección 1', '5aac1001-7bad-4f5e-92ab-ba1684ccfba6')");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM `stage` WHERE 1=1');

    }
}