<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701153402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'First Kata for Clean Code (Functions) Lesson';
    }

    public function up(Schema $schema) : void
    {
        $sqlKata18 = <<<'EOD'
        INSERT INTO `kata` (`id`, `description`, `editor_code`, `examples`, `created_at`, `updated_at`, `kata_title`, `uuid`, `kata_test_code`) VALUES (87, 'Las funciones deberían ser tan pequeñas como sea posible, aunque no hay una medida estándar definida en líneas de código. Las funciones con dos o tres líneas de código son buenas funciones.   \n\n\n\nSegún establece el pirata Robert C. Martin, más popularmente conocido como Uncle Bob: *las funciones deberían hacer una sola cosa y deberían hacerla bien*. Es decir, deberían tener una sola responsabilidad.   \n\nObserva el siguiente ejemplo\n```\npublic function showHtmlPost($postId)\n{\n    $post = Post::find($postId);\n    If ($post == null) {\n        $template = new Template();\n        $template->loadFileTemplate(‘ErrorPagePostNotFound’);\n\n        return $template->getHtml();\n    }\n    $template = new Template();\n    $template->loadFileTemplate(‘Post’);\n    $template->loadTemplateWithData($post);\n\n    return $template->getHtml();\n}\n\n```\nEn este ejemplo, la mezcla de niveles de abstracción resulta algo confusa al tener:\n* nivel de abstracción alto como “getPost($id)”.\n* niveles de abstracción medios “post::find($id)”.   \n\nTodo ello lleva al lector a tener que pensar si todo esto es un concepto o un detalle de implementación.\n\nUna buena forma de empezar a refactorizar el código anterior sería:\n\n```\npublic function showHtmlPost($postId)\n{\n    $post = getPost($postId);\n    If (isPostFound($post)) {\n	return getHtmlErrorPagePostNotFound();\n    }\n    \n    return getHtmlPostTemplate($post);\n}\n\n```\nEncapsulando así en las funciones **getHtmlErrorPagePostNotFound()** y **getHtmlPostTemplate($post)** la funcionalidad de devolver la página de error o el post.\n\n___\n\nSiguiendo la prática seguida en el ejemplo anterior, observa este código:\n\n```\nclass Chapter {\n    var $chapter;\n}\npublic function showSelectedChapter($chapterId)\n{\n    $this->chapter = Chapter::find($chapterId);\n    \n    If (!this->chapter) {\n        throw new Exception(\"El capítulo especificado no existe. Cree un nuevo Capítulo\");\n    }\n\n    $title = $chapter->getTitle();\n    $description = $chapter->getDescription();\n    $lessons = $chapter->getLessons();\n    $exercises = $chapter->getExercises();\n\n\n    return $chapter->show($title, $description, $lessons, $exercises);\n}\n```\n¿Cómo refactorizarías los fragmento de código anteriores para agrupar de forma lógica y semántica el código en funciones con las siguientes responsabilidades?\n1. Encontrar el capítulo (mediante el id del capítulo)\n2. Comprobar si existe el capítulo\n3. Crear la vista del capítulo\nTan solo es necesario que escribas la cabecera de las funciones que englobarían ese código.', 'function getRefactorTheFunction(): array\n{\n    return [\n        \'$this->chapter = Chapter::find($chapterId)\' => \'\',\n        \'If (!this->chapter) {throw new Exception(\"El capítulo especificado no existe\");}\' => \'\',\n        \'return $chapter->show($title, $description, $lessons, $exercises)\' => \'$this->createChapterView()\'\n    ];\n}', NULL, '2021-07-01 16:07:01', '2021-07-01 17:30:52', 'Kata 18: Una sola función', '2e4d705b-b0c7-4f8d-856a-42646e84c690', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $refactorTheFunction = $kataSourceCode->getRefactorTheFunction();\n\n        $isFunctionRefactorValid = ($refactorTheFunction[\'$this->chapter = Chapter::find($chapterId)\'] === \'$findChapter()\')\n            && ($refactorTheFunction[\'If (!this->chapter) {throw new Exception(\"El capítulo especificado no existe\");}\'] === \'$this->checkIfChapterExists()\')\n            && ($refactorTheFunction[\'return $chapter->show($title, $description, $lessons, $exercises)\'] === \'$this->createChapterView()\');\n        \n        $this->assertTrue($isFunctionRefactorValid);\n    }\n}\n')
EOD;
        $this->addSql($sqlKata18);
        }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
