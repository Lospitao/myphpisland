<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210409115012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'admin user creation';
    }

    public function up(Schema $schema) : void
    {

        $this->addSql('INSERT INTO `user` (`id`, `username`, `roles`, `password`, `signup_date`, `email`) VALUES (1,\'administrator\', \'[ "ROLE_PLAYER", "ROLE_ADMIN" ]\', \'$argon2id$v=19$m=65536,t=4,p=1$M3DEOJGhq0vOwnE0AhOqDg$FalWnm7BuXgx9zzMZNWkpwy0OPk6bckIqiq+Uy08CQM\',
        \'2021-04-19 11:30:30\',\'myphpisland@gmail.com\')');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM `user` WHERE `username`= \'administrator\'');

    }
}