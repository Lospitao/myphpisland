<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Egulias\EmailValidator\Warning\ObsoleteDTEXT;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623192926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '44 Kata Update with latest Jorge\'s correction';
    }

    public function up(Schema $schema) : void
    {
        $sqlKatasUpdated1 = <<<'EOD'
        UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'nombreDeUsuario\'] === \'username\')\n            && ($semanticNames[\'obtenerRepositorios\'] === \'getRepositories\')\n            && ($semanticNames[\'repositorios\'] === \'repositories\')\n            && ($semanticNames[\'título\'] === \'title\')\n            && ($semanticNames[\'obtenerTítulo\'] === \'getTitle\')\n            && ($semanticNames[\'descripción\'] === \'description\')\n            && ($semanticNames[\'obtenerDescripción\'] === \'getDescription\')\n			&& ($semanticNames[\'fechaCreación\'] === \'creationDate\')          \n            && ($semanticNames[\'obtenerFechaCreación\'] === \'getCreationDate\');\n        \n         $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '45');
EOD;

        $this->addSql($sqlKatasUpdated1);


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
