<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210628084558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Batch of katas updates by Laura';
    }

    public function up(Schema $schema) : void
    {
        $sqlKatasUpdated1 = <<<'EOD'
UPDATE `kata` SET `description` = 'Las variables sirven para almacenar algún tipo de dato por lo que el nombre de esa variable no debería dejar duda alguna de la información que contiene. Por ejemplo, en el caso de contener el nombre de un usuario un buen nombre para la variable sería **$name**. En el caso de contener la edad del usuario, llámame loco, pero un buen nombre sería **$age**.           \n\n\nSi en ese contexto hay dos entidades (dos conceptos) que tengan el mismo nombre, habrá que renombrar esas variables sin dejar lugar a dudas. Por ejemplo, si en un formulario de registro hay un nombre real y un nombre de usuario, entonces, cada uno debe expresar qué es cada una de las variables. Por ejemplo, **$realName** y **$userName**.   \n\nImagina que tienes que desarrollar un formulario de registro muy simple, como el de github. El formulario consta de los siguientes campos:  \n\n\n**Nombre de usuario.**  \n**Correo electrónico.**  \n**Contraseña.**  \n\n\n¿Cuál crees que serían los nombres **semánticos** para estos campos?    \n\n\n**Nota: Salvo que se especifique lo contrario todos nombres se deben escribir en inglés ‘madafaka’.**  \n\n\n\n\n' WHERE (`id` = '44');
EOD;

        $sqlKatasUpdated2 = <<<'EOD'
UPDATE `kata` SET `description` = 'Como ya se ha dicho, los nombres deben ser suficientemente claros y, tanto las abreviaturas como  las palabras del lenguaje de programación, deberían evitarse a la hora de nombrar variables.   \n\nIncluir  palabras como **string**, **float**, **array** u **object** en el nombre de una variable produce el acoplamiento del lenguaje de programación a las reglas del negocio.\n___\nPor ejemplo, imagina que encontramos un listado de usuarios y el nombre de la variable es **“$usersArray”**. En este caso, este grumete acaba de acoplar el tipo de dato al nombre de la variable.\n¿Qué sucece si, con el tiempo, se crea un objeto que contenga ese listado de usuarios y dicho listado  se gestiona mediante métodos? Pues que el nombre **“$usersArray”** llevará a quien lea nuestro código a pensar que esa variable almacena un array cuando en realidad almacena un objeto. Alguien podría pensar en cambiar el nombre a uno más semántico como **“$userObject”**, en cuyo caso yo lo pasaría directamente por la quilla sin pensarlo mucho. \n\nQuizá otro alguien podría pensar en **$userCollection** que, a priori, no nos aporta valor ya que **“collection”** parece una colección pero ¿qué hace una colección?. Lo mejor es nombrar la variable simplemente como **$users**.\n\nImagina que sigues en el mismo proyecto y has llegado hasta el siguiente código sintiendo un escalofrío en la columna vertebral:\n```\n$endDateString = $product->getEndDate();\n$priceFloat = $product->getPrice();\n$commentsArray = $product->getComments();\n$galleryObject = $product->getGallery();\n\n```\n\n¿Cómo lo refactorizarías para mejorar el código?\n ' WHERE (`id` = '47');
EOD;

        $sqlKatasUpdated3 = <<<'EOD'
UPDATE `kata` SET `description` = 'Imagina que encuentras variables con nombres como:\n```\n$tokexptim \n$conSigDat\n$genymdhms \n```\n¿Sabrías cuál es el propósito de estas variables? ¿Quizá pasarías por la quilla a aquellos que han osado definirlas?\n\nUn buen nombre de una variable debe poder pronunciarse y ser lo suficientemente comprensible como para no tener que sacar una bola de cristal para adivinar el propósito de cada variable. Para las variables anteriores hubieran sido mejores nombres:   \n```\n$tokenExpirationTime \n$contractSignatureDate\n$generationDate \n```\n___\nImagina que tienes asignada una tarea relacionada con el inicio de sesión de un usuario y encuentras el siguiente código:   \n\n```// Get password\n$pwd = $user->getPwd();\n\n// Validate\nIf ( ! $this->validate($pwd) ) {\n\n            // Return invalid password message\n	return $this->invalidPwdMessage();\n\n}\n```\n¿Sabrías encontrar nombres más semánticos para las siguientes variables y métodos?\n' WHERE (`id` = '51');
EOD;

        $sqlKatasUpdated4 = <<<'EOD'
UPDATE `kata` SET `description` = 'Es posible que, en determinadas ocasiones, se considere añadir información extra para indicar el tipo de variable como por ejemplo:\n```\n$usersArray\n$dateString\n```\nO quizá indicar la visibilidad de las mismas con un ingenioso prefijo:\n```\n$_date: variable privada.\n$p_date: variable privada.\n\n```\nTodo esto es un auténtico excremento de gaviota y, salvo que trabajes en papiro, los IDE actuales son capaces de resolver este tipo de problemas, así como la ejecución del código que resultará en un error de tipo o de acceso.\n___\nRefactoriza los nombres de variables de la derecha antes de que me sangren más los ojos.' WHERE (`id` = '57');
EOD;

        $sqlKatasUpdated5 = <<<'EOD'
UPDATE `kata` SET `description` = 'El dominio del problema es el lenguaje que se utiliza para describir el problema que queremos resolver sin entrar en la parte técnica.   \n \nPor ejemplo, el desarrollo de un proceso que envíe notificaciones por correo electrónico a clientes que tengan la última factura pendiente de pago, enviando dichas notificaciones por orden de deuda acumulada, siendo los primeros los que más deuda acumulada tengan.\n\nEl dominio del problema puede estar compuesto por conceptos como: *notificación*, *correo electrónico*, *facturas*, *pendientes de pagar*.\n\nSe quiere enviar una serie de notificaciones por correo electrónico a clientes que tienen facturas impagadas. Para ello, en primer lugar, se obtienen todos aquellos clientes que tengan al menos una factura impagada. El orden de las notificaciones dependerá de la deuda que tenga el cliente. A más deuda más prioridad por lo que hay que ordenar el listado de impagos. \n\nEsta funcionalidad está encapsulada en la clase siguiente:\n```\n// Find all unpaid bills\n$unpbil = $billsRepository->findUnpaidBills();\n\n// Sort unpaid bills by descending amount\n$sorUnpBilBDesAmo = $this->sortByDescAmo($unpbil)\n\n// Get defaulters \n$fuckingDefaulters =  $this->getDefaulters($sUnpBil);\n\nforeach($fuckingDefaulters as $df) {\n    // Sent notification\n    $poen = new PendingOrderEmailNotification();\n    $poen->setToEmail($fd->getEmail());\n    $poen->send();\n}\n\n```\n¿Qué nombres del dominio se deberían haber elegido?\n' WHERE (`id` = '85');
EOD;

        $sqlKatasUpdated6 = <<<'EOD'
UPDATE `kata` SET `description` = 'Cuando se elige un nombre semántico para una variable, éste no tiene un significado específico si no está incluido en un contexto concreto. \nPor ejemplo, la variable **$status** hace referencia a un estado pero si se tienen varias entidades en la misma función no se sabría a cuál de ellas se está haciendo referencia salvo retrocediendo en el código.\n\nEn aquellos casos en los que el código quede ambiguo, es más que recomendable refactorizar el nombre incluyendo el nombre de la entidad, como por ejemplo $userStatus o $postStatus. De esta manera no cabe duda de a qué entidad está haciendo referencia esa propiedad.\n\nUna solución aún mejor sería incluir ese atributo en la clase User o la clase Post para acceder al mismo a través de un método getStatus con lo que también estaríamos eliminando la ambigüedad:\n```\n$user->getStatus();\n$post->getStatus();\n```\n___\nImagina que tienes el siguiente código y solo tienes dos opciones: refactorizar el código o emborracharte con grog. Opta por lo primero que da menos resaca.\n```\n$status = $user->getStatus();\n\n// Check if user’s status is pending to confirm \nIf ($status == 2) {\n    throw new StatusUserIsPendingConfirmation();    \n}\n\n$status2 = $post->getStatus();\n// Check if status post is a draft\nIf ($status2 == 3) {\n    throw new StatusPostIsADraft();\n}\n```\nEs recomendable evitar los números mágicos y convertirlos en constantes que contengan ese número. Para este proyecto se ha adoptado la convención de nombrar las constantes con mayúsculas y notación underscore. \n\n**Nota: el nombre de estas constantes debería utilizar el nombre de la entidad que representa los distintos estados y el valor del estado. Por ejemplo, para un estado de un pedido podría ser \"OrderStatus::CONFIRMED\".**\n' WHERE (`id` = '86');
EOD;

        $sqlKatasUpdated7 = <<<'EOD'
UPDATE `kata` SET `kata_test_code` = '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'$status\'] === \'$userStatus\')\n		&& ($semanticNames[\'2\'] === \'UserStatus::PENDING_CONFIRMATION\')\n		&& ($semanticNames[\'$status2\'] === \'$postStatus\')\n		&& ($semanticNames[\'3\'] === \'PostStatus::DRAFT\');\n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}' WHERE (`id` = '86');
EOD;
        $this->addSql($sqlKatasUpdated1);
        $this->addSql($sqlKatasUpdated2);
        $this->addSql($sqlKatasUpdated3);
        $this->addSql($sqlKatasUpdated4);
        $this->addSql($sqlKatasUpdated5);
        $this->addSql($sqlKatasUpdated6);
        $this->addSql($sqlKatasUpdated7);
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
