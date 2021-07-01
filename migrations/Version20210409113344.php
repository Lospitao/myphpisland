<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409113344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'insert user roles';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO `user_role`(`id`, `name`) VALUES (1,"PLAYER")');
        $this->addSql('INSERT INTO `user_role`(`id`, `name`) VALUES (2,"ADMIN")');



    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM user_role WHERE id = 1');
        $this->addSql('DELETE FROM user_role WHERE id = 2');

    }
}
