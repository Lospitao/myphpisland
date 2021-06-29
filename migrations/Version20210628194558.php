<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210628194558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Batch of katas updates by Jorge';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<'EOD'
UPDATE `kata` SET `description` = 'Imagina que encuentras variables con nombres como:\n```\n$tokexptim \n$conSigDat\n$genymdhms \n```\n¿Sabrías cuál es el propósito de estas variables? ¿Quizá pasarías por la quilla a aquellos que han osado definirlas?\n\nUn buen nombre de una variable debe poder pronunciarse y ser lo suficientemente comprensible como para no tener que sacar una bola de cristal para adivinar el propósito de cada variable. Para las variables anteriores hubieran sido mejores nombres:   \n```\n$tokenExpirationTime \n$contractSignatureDate\n$generationDate \n```\n___\nImagina que tienes asignada una tarea relacionada con el inicio de sesión de un usuario y encuentras el siguiente código:   \n\n```// Get password\n$pwd = $user->getPwd();\n\n// Validate password\nIf ( ! $this->validate($pwd) ) {\n\n	// Return invalid password message\n	return $this->invalidPwdMessage();\n\n}\n```\n¿Sabrías encontrar nombres más semánticos para las siguientes variables y métodos?\n', `editor_code` = 'function getSemanticNames(): array\n{\n    return [\n        \'$pwd\' => \'\',\n        \'$user->getPwd()\' => \'\',\n        \'$this->invalidPwdMessage()\' => \'\'\n    ];\n}', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$pwd\'] === \'$password\')\n            && ($semanticNames[\'$user->getPwd()\'] === \'$user->getPassword()\')\n            && ($semanticNames[\'$this->invalidPwdMessage()\'] === \'$this->invalidPasswordMessage()\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '51');
EOD;
        $this->addSql($sql);

        $sql = <<<'EOD'
UPDATE `kata` SET `description` = 'Los nombres de los métodos deberían ser acciones que se producen sobre el mismo objeto. Por esta razón siempre se deberían usar verbos o frases con verbos. Por ejemplo: \n```\npublic function addPost() {}\npublic function calculateBill() {}\n```\nSi se espera una respuesta booleana, verdadero o falso, entonces los método deberían nombrarse en forma de pregunta total, como por ejemplo \n```\npublic function isConfirmed() {} \npublic function isPublished() {}\n```\n___\nImagina que tienes una aplicación blog donde encuentras los siguientes nombres de métodos:\n```\n// Remove a tag to the post\n$post->remTag($tag);\n\n// Publish at future date\n$post->pubFutDat($publicationDate);\n\n// Check if post is published\nIf ($post->published())\n\n ```\nRefactoriza esos métodos.\n', `editor_code` = 'function getSemanticNames(): array\n{\n	return [\n      \'$post->remTag($tag)\' => \'\',\n      \'$post->pubFutDat($publicationDate)\' => \'\',\n      \'$post->published()\' => \'\'\n    ];         \n}', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'$post->remTag($tag)\'] === \'$post->removeTag($tag)\')\n            && ($semanticNames[\'$post->pubFutDat($publicationDate)\'] === \'$post->publishAtFutureDate($publicationDate)\')\n            && ($semanticNames[\'$post->published()\'] === \'$post->isPublished()\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n' WHERE (`id` = '61');
EOD;
        $this->addSql($sql);

        $sql = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n	return [\n      \'$post->obliviateTag($tag)\' => \'\',\n      \'$post->ascendioPostAt($publicationDate)\' => \'\',\n      \'$post->accioComment($comment)\' =>  \'\',\n     ];\n}\n', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'$post->obliviateTag($tag)\'] === \'$post->removeTag($tag)\')\n            && ($semanticNames[\'$post->ascendioPostAt($publicationDate)\'] === \'$post->publishAt($publicationDate)\')\n            && ($semanticNames[\'$post->accioComment($comment)\'] === \'$post->addComment($comment)\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}\n' WHERE (`id` = '62');
EOD;
        $this->addSql($sql);

        $sql = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n	return [\n      \'$post->obliviateTag($tag)\' => \'\',\n      \'$post->ascendioAt($publicationDate)\' => \'\',\n      \'$post->accioComment($comment)\' =>  \'\',\n     ];\n}\n', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'$post->obliviateTag($tag)\'] === \'$post->removeTag($tag)\')\n            && ($semanticNames[\'$post->ascendioAt($publicationDate)\'] === \'$post->publishAt($publicationDate)\')\n            && ($semanticNames[\'$post->accioComment($comment)\'] === \'$post->addComment($comment)\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}\n' WHERE (`id` = '62');
EOD;
        $this->addSql($sql);

        $sql = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n	return [\n      \'$post->retrievePublicationDate()\' => \'\',\n      \'$comment->fetchCreationDate()\' => \'\',\n      \'$post->loadCreationDate($creationDate)\' => \'\',\n      \'$comment->putCreationDate($creationDate)\' => \'\',\n      \'$postsRepository->lookForAll()\'=> \'\',\n      \'$commentsRepository->searchAll()\' => \'\'\n    ];\n}\n', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'$post->retrievePublicationDate()\'] === \'$post->getPublicationDate()\')\n&& ($semanticNames[\'$comment->fetchCreationDate()\'] === \'$comment->getCreationDate()\')\n&& ($semanticNames[\'$post->loadCreationDate($creationDate)\'] === \'$post->setCreationDate($creationDate)\')\n&& ($semanticNames[\'$comment->putCreationDate($creationDate)\'] === \'$comment->setCreationDate($creationDate)\')\n&& ($semanticNames[\'$postsRepository->lookForAll()\'] === \'$postsRepository->findAll()\')\n&& ($semanticNames[\'$commentsRepository->searchAll()\'] === \'$commentsRepository->findAll()\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}' WHERE (`id` = '83');
EOD;
        $this->addSql($sql);
        $sql = <<<'EOD'
UPDATE `kata` SET `editor_code` = 'function getSemanticNames(): array\n{\n	return [\n      \'$post->retrievePublicationDate()\' => \'\',\n      \'$comment->fetchCreationDate()\' => \'\',\n      \'$post->loadCreationDate($creationDate)\' => \'\',\n      \'$comment->putCreationDate($creationDate)\' => \'\',\n      \'$postRepository->lookForAll()\'=> \'\',\n      \'$commentsRepository->searchAll()\' => \'\'\n    ];\n}\n', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'$post->retrievePublicationDate()\'] === \'$post->getPublicationDate()\')\n&& ($semanticNames[\'$comment->fetchCreationDate()\'] === \'$comment->getCreationDate()\')\n&& ($semanticNames[\'$post->loadCreationDate($creationDate)\'] === \'$post->setCreationDate($creationDate)\')\n&& ($semanticNames[\'$comment->putCreationDate($creationDate)\'] === \'$comment->setCreationDate($creationDate)\')\n&& ($semanticNames[\'$postRepository->lookForAll()\'] === \'$postRepository->findAll()\')\n&& ($semanticNames[\'$commentsRepository->searchAll()\'] === \'$commentsRepository->findAll()\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}' WHERE (`id` = '83');
EOD;
        $this->addSql($sql);

        $sql = <<<'EOD'
UPDATE `kata` SET `description` = 'A veces se utilizan diferentes nombres para un mismo concepto como por ejemplo: *get*, *fetch* o *retrieve*. Unificar en una palabra un mismo concepto contribuye a una mejor comprensión del código, ya que el uso de nombres diferentes puede llevar a pensar que se trata de mecanismos diferentes.\n\nPor ello es recomendable definir una palabra por concepto y seguir esa directriz. \n___\nImagina que tienes una aplicación blog donde encuentras los siguientes nombres de métodos:\n\n```\n// Get creation dates\n$userCreationDate = $user->getCreationDate();\n$postCreationDate = $post->retrievePublicationDate();\n$commentCreationDate = $comment->fetchCreationDate();\n\n// Set creation dates\n$user->setCreationDate($creationDate);\n$post->loadCreationDate($creationDate);\n$comment->putCreationDate($creationDate);\n\n// Find all \n$users = $userRepository->findAll();\n$post = $postRepository->lookForAll();\n$comments = $commentRepository->searchAll();\n\n```\nSi se creó primero la entidad **User** y, de momento, no se quiere replantear los nombres, lo más sencillo es seguir la misma nomenclatura. Actualiza los nombres de las funciones para que coincidan con la entidad User.', `editor_code` = 'function getSemanticNames(): array\n{\n	return [\n      \'$post->retrievePublicationDate()\' => \'\',\n      \'$comment->fetchCreationDate()\' => \'\',\n      \'$post->loadCreationDate($creationDate)\' => \'\',\n      \'$comment->putCreationDate($creationDate)\' => \'\',\n      \'$postRepository->lookForAll()\'=> \'\',\n      \'$commentRepository->searchAll()\' => \'\'\n    ];\n}\n', `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'$post->retrievePublicationDate()\'] === \'$post->getPublicationDate()\')\n&& ($semanticNames[\'$comment->fetchCreationDate()\'] === \'$comment->getCreationDate()\')\n&& ($semanticNames[\'$post->loadCreationDate($creationDate)\'] === \'$post->setCreationDate($creationDate)\')\n&& ($semanticNames[\'$comment->putCreationDate($creationDate)\'] === \'$comment->setCreationDate($creationDate)\')\n&& ($semanticNames[\'$postRepository->lookForAll()\'] === \'$postRepository->findAll()\')\n&& ($semanticNames[\'$commentRepository->searchAll()\'] === \'$commentRepository->findAll()\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}' WHERE (`id` = '83');
EOD;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
