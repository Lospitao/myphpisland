<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701120552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Added $ symbol to variables in code_editor as well as katas_test_code in katas 1-6';
    }

    public function up(Schema $schema) : void
    {
        $sqlKatasUpdated1 = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n        \'$nombreDeUsuario\' => \'\',\n        \'$correoElectrónico\' => \'\',\n        \'$contraseña\' => \'\'\n    ];\n}' WHERE (`id` = '44');
EOD;

        $sqlKatasUpdated2 = <<<'EOD'
UPDATE `kata` SET `examples` = 'function getSemanticNames(): array\n{\n    return [\n        \"$nombreDeUsuario\" => \"en inglés\",\n        \"$correoElectrónico\" => \"en inglés\",\n        \"$contraseña\" => \"en inglés\",\n    ];\n}' WHERE (`id` = '44');
EOD;

        $sqlKatasUpdated3 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$nombreDeUsuario\'] === \'$username\')\n            && ($semanticNames[\'$correoElectrónico\'] === \'$email\')\n            && ($semanticNames[\'$contraseña\'] === \'$password\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '44');
EOD;

        $sqlKatasUpdated4 = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n      \'$nombreDeUsuario\' => \'\',\n      \'$obtenerRepositorios()\' => \'\',\n      \'$repositorios\' => \'\',\n      \'$título\' => \'\',\n      \'$obtenerTítulo()\' => \'\',\n      \'$descripción\' => \'\',\n      \'$obtenerDescripción()\' => \'\',\n      \'$fechaCreación\' => \'\',\n      \'$obtenerFechaCreación()\' => \'\'\n    ];\n}\n\n' WHERE (`id` = '45');
EOD;

        $sqlKatasUpdated5 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$nombreDeUsuario\'] === \'$username\')\n            && ($semanticNames[\'$obtenerRepositorios()\'] === \'$getRepositories()\')\n            && ($semanticNames[\'$repositorios\'] === \'$repositories\')\n            && ($semanticNames[\'$título\'] === \'$title\')\n            && ($semanticNames[\'$obtenerTítulo()\'] === \'$getTitle()\')\n            && ($semanticNames[\'$descripción\'] === \'$description\')\n            && ($semanticNames[\'$obtenerDescripción()\'] === \'$getDescription()\')\n			&& ($semanticNames[\'$fechaCreación\'] === \'$creationDate\')          \n            && ($semanticNames[\'$obtenerFechaCreación()\'] === \'$getCreationDate()\');\n        \n         $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '45');
EOD;

        $sqlKatasUpdated6 = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n      \'$tmp\' => \'\',\n      \'$vid\' => \'\',\n      \'$stts\' => \'\',\n      \'$edate\' => \'\'\n    ];\n}' WHERE (`id` = '46');
EOD;

        $sqlKatasUpdated7 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$klasses\'] === \'$classes\')\n            && ($semanticNames[\'$d4te\'] === \'$date\')\n            && ($semanticNames[\'$name2\'] === \'$name\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}' WHERE (`id` = '46');
EOD;

        $sqlKatasUpdated8 = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n      \'$endDateString\' => \'\',\n      \'$priceFloat\' => \'\',\n      \'$commentsArray\' => \'\',\n      \'$galleryObject\' => \'\'\n    ];\n}\n\n' WHERE (`id` = '47');
EOD;

        $sqlKatasUpdated9 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$endDateString\'] === \'$endDate\')\n            && ($semanticNames[\'$priceFloat\'] === \'$price\')\n            && ($semanticNames[\'$commentsArray\'] === \'$comments\')\n            && ($semanticNames[\'$galleryObject\'] === \'$gallery\');\n        \n         $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '47');
EOD;

        $sqlKatasUpdated10 = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n        \'$klasses\' => \'\',\n        \'$d4te\' => \'\',\n        \'$name2\' => \'\'\n    ];\n}' WHERE (`id` = '48');
EOD;

        $sqlKatasUpdated11 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$klasses\'] === \'$classes\')\n            && ($semanticNames[\'$d4te\'] === \'$date\')\n            && ($semanticNames[\'$name2\'] === \'$name\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}' WHERE (`id` = '48');
EOD;

        $sqlKatasUpdated12 = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n        \'$userData\' => \'\',\n        \'$addressInfo\' => \'\'\n    ];\n}\n' WHERE (`id` = '49');
EOD;

        $sqlKatasUpdated13 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$userData\'] === \'$user\')\n            && ($semanticNames[\'$addressInfo\'] === \'$address\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '49');
EOD;

        $this->addSql($sqlKatasUpdated1);
        $this->addSql($sqlKatasUpdated2);
        $this->addSql($sqlKatasUpdated3);
        $this->addSql($sqlKatasUpdated4);
        $this->addSql($sqlKatasUpdated5);
        $this->addSql($sqlKatasUpdated6);
        $this->addSql($sqlKatasUpdated7);
        $this->addSql($sqlKatasUpdated8);
        $this->addSql($sqlKatasUpdated9);
        $this->addSql($sqlKatasUpdated10);
        $this->addSql($sqlKatasUpdated11);
        $this->addSql($sqlKatasUpdated12);
        $this->addSql($sqlKatasUpdated13);

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
