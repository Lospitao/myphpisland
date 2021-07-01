<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621160620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '1st Lesson Katas migration';
    }

    public function up(Schema $schema) : void
    {
        $sqlKatas = <<<'EOD'
INSERT INTO `kata` (`id`, `description`, `editor_code`, `examples`, `created_at`, `updated_at`, `kata_title`, `uuid`, `kata_test_code`) VALUES
(44, 'Las variables sirven para almacenar algún tipo de dato por lo que el nombre de esa variable no debería dejar duda alguna de la información que contiene. Por ejemplo, en el caso de contener el nombre de un usuario un buen nombre para la variable sería **$name**. En el caso de contener la edad del usuario, llámame loco, pero un buen nombre sería **$age**.           \n\n\nSi en ese contexto hay dos entidades (dos conceptos) que tengan el mismo nombre, habrá que renombrar esas variables sin dejar lugar a dudas. Por ejemplo, si en un formulario de registro hay un nombre real y un nombre de usuario, entonces, cada uno debe expresar qué es cada una de las variables. Por ejemplo, **$realName** y **$userName**.   \n\nImagina que tienes que desarrollar un formulario de registro muy simple, como el de github. El formulario consta de los siguientes campos:  \n\n\n**Nombre de usuario.**  \n**Correo electrónico.**  \n**Contraseña.**  \n\n\n¿Cuál crees que serían los nombres semánticos para estos campos? Rellena los nombres semánticos que estimes oportuno para que tengan un nombre semántico.   \n\n\n**Nota: Salvo que se especifique lo contrario todos nombres se deben escribir en inglés ‘madafaka’.**  \n\n\n\n\n', 'function getSemanticNames(): array\n{\n    return [\n        \"nombre de usuario\" => \"\",\n        \"correo electrónico\" => \"\",\n        \"contraseña\" => \"\"\n    ];\n}', 'function getSemanticNames(): array\n{\n    return [\n        \"nombre de usuario\" => \"en inglés\",\n        \"correo electrónico\" => \"en inglés\",\n        \"contraseña\" => \"en inglés\",\n    ];\n}', '2021-06-11 11:15:03', '2021-06-21 17:57:57', 'Kata 1: Nombres de variables', '1c4ef804-80d8-4fba-b356-7c5ce693587b', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'nombre de usuario\'] === \'username\')\n            && ($semanticNames[\'correo electrónico\'] === \'email\')\n            && ($semanticNames[\'contraseña\'] === \'password\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(45, 'Bien, los nombres anteriores eran bastante triviales. A ver que tal con algo un poco más difícil. Se podría decir que cuando nos llega una especificación, ésta contiene todo lo necesario para poder llevar a cabo un desarrollo. Por ejemplo, una posible especificación sencilla del  formulario de registro de github debería contener algo como:\n___\n**Nombre de usuario**, con el que el usuario se puede registrar de cómo máximo 10 caracteres alfanuméricos .   \n**Correo electrónico**, que deberá tener el formato de correo electrónico.   \n**Contraseña**, será una cadena de texto de más de 6 caracteres.    \n___\nPara poder implementar el desarrollo hay que modelar esos tres conceptos.   \nEsto significa que los conceptos requieren de identidad propia en nuestro sistema. Y esta identidad propia tiene que venir representada por un buen nombre. Por ejemplo, un buen nombre para modelar el concepto “nombre de usuario” sería **$username**, para modelar el concepto “correo electrónico” sería **$email** mientras que para la contraseña **$password** no debería dejar lugar a dudas.\n\nSi el concepto es más complejo entonces el modelado podría hacerse con una estructura de datos o un objeto. Por ejemplo el concepto usuario requiere de identidad propia y este se podría modelar con un objeto que tuviera los atributos: *nombre de usuario*, *correo electrónico* y *contraseña*. \n\nCabe destacar que los conceptos siempre se deberían representar mediate una variable en inglés nombrada en singular: User, Car, House, Cart, etc. Si se está tratando una colección de objetos, entonces se trata en plural: Users, Repositories, Cars, Carts, etc. Evitad a toda costa variables como  **UsersList**, ni **UsersCollection**.  \n\nImagina que en la página de perfil de usuario de github hay una sección en la que se listan todos los repositorios del usuario. Dado el siguiente código con los nombres en español, ¿qué nombres serían más **semánticos**?\n```\n$repositorios = $nombreDeUsuario->obtenerRepositorios();\n\nforeach( $repositorios as $repositorio) {\n  $titulo = $repositorio->obtenerTitulo();\n  $descripcion = $repositorio->obtenerDescripción();\n  $fechaCreación = $repositorio->obtenerFechaCreación();\n  // Más código increíble ...\n}\n```\n**Nota**: los nombres de las variables tienen que ser en inglés.\n\n', 'function getSemanticNames(): array\n{\n    return [\n      \"nombreDeUsuario\" => \"\",\n      \"obtenerRepositorios\" => \"\",\n      \"repositorios\" => \"\",\n      \"título\" => \"\",\n      \"obtenerTítulo\" => \"\",\n      \"descripción\" => \"\",\n      \"obtenerDescripción\" => \"\",\n      \"fechaCreación\" => \"\",\n      \"obtenerFechaCreación\" => \"\"\n    ];\n}\n\n', '¡Demasiado fácil! Esta vez no necesitas pistas.', '2021-06-11 11:45:43', '2021-06-21 12:19:47', 'Kata 2: Nombres de variables y métodos', 'da644441-cfa7-4fb5-b991-8707764349bc', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'nombreDeUsuario\'] === \'username\')\n            && ($semanticNames[\'obtenerRepositorios\'] === \'findRepositories\')\n            && ($semanticNames[\'repositorios\'] === \'repositories\')\n            && ($semanticNames[\'título\'] === \'title\')\n            && ($semanticNames[\'obtenerTítulo\'] === \'getTitle\')\n            && ($semanticNames[\'descripción\'] === \'description\')\n            && ($semanticNames[\'obtenerDescripción\'] === \'getDescription\')\n			&& ($semanticNames[\'fechaCreación\'] === \'creationDate\')          \n            && ($semanticNames[\'obtenerFechaCreación\'] === \'getCreationDate\');\n        \n         $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(46, 'Los nombres deben ser siempre suficientemente claros y semánticos, por lo que las abreviaturas siempre son una mala elección. \n\nPor ejemplo, la variable  **$tmp**, podría parecer a primera vista una variable temporal, aunque algún grumete podría considerarlo una excelente opción para modelar la temperatura. Un mejor nombre sería **$temperature.**\n\nAsí qué, ya sabes, cada vez que alguien utiliza una abreviatura Dios mata a un mono de tres cabezas… ¿Nunca has visto un mono de tres cabezas? Pues ya sabes por lo que es. Así que, sin más dilación, pasemos a la siguiente prueba ...\n\nAcabas de entrar en un proyecto y has podido ver algunos fragmentos de código que, posiblemente, ya te han puesto el vello de punta:\n\n```\n$tmp = $city->getTemperature();\n\n$vid = $lesson->getVideo();\n\n$stts = $product->getStatus();\n\n$edate = $product->getExpirationDate();\n\n```\nRefactoriza las variables antes de que otro pobre mono vea sus tres cabezas cortadas.\n', '\nfunction getSemanticNames(): array\n{\n    return [\n      \"tmp\" => \"\",\n      \"vid\" => \"\",\n      \"stts\" => \"\",\n      \"edate\" => \"\"\n    ];\n}', 'Tanto el ejemplo de código que te ofrecemos\n  en la descripción como el sentido común\n  te darán la clave para resolver este ejercicio.', '2021-06-11 12:36:05', '2021-06-21 11:43:34', 'Kata 3: Evitar las abreviaturas', 'f4e45787-4aed-4f24-bb6d-13d305fcd443', '<?php\n\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n         $areSemanticNamesValid = ($semanticNames[\'tmp\'] === \'temperature\')\n            && ($semanticNames[\'vid\'] === \'video\')\n            && ($semanticNames[\'stts\'] === \'status\')\n            && ($semanticNames[\'edate\'] === \'expirationDate\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}'),
(47, 'Como ya se ha dicho, los nombres deben ser suficientemente claros y, tanto las abreviaturas como  las palabras del lenguaje de programación, deberían evitarse a la hora de nombrar variables.   \n\nIncluir  palabras como **string**, **float**, **array** u **object** en el nombre de una variable produce el acomplamiento del lenguaje de programación a las reglas del negocio.\n___\nPor ejemplo, imagina que encontramos un listado de usuarios y el nombre de la variables es **“$usersArray”**. En este caso, este grumete acaba de acoplar el tipo de dato al nombre de la variable.\n¿Qué sucece si, con el tiempo, se crea un objeto que contenga ese listado de usuarios y dicho listado  se gestiona mediante métodos? Pues que el nombre **“$usersArray”** llevará a quien lea nuestro código a pensar que esa variable almacena un array cuando en realidad almacena un objeto. Alguien podría pensar en cambiar el nombre a uno más semántico como **“$userObject”**, en cuyo caso yo lo pasaría directamente por la quilla sin pensarlo mucho. \n\nQuizá otro alguien podría pensar en **$userCollection** que, a priori, no nos aporta valor ya que **“collection”** parece una colección pero ¿qué hace una colección?. Lo mejor es llamarle simplemente **$users**.\n\nImagina que igues en el mismo proyecto y has llegado hasta el siguiente código sintiendo un escalofrío en la columna vertebral:\n```\n$endDateString = $product->getEndDate();\n$priceFloat = $product->getPrice();\n$commentsArray = $product->getComments();\n$galleryObject = $product->getGallery();\n\n```\n\n¿Cómo lo refactorizarías para mejorar el código?\n', 'function getSemanticNames(): array\n{\n    return [\n      \"endDateString\" => \"\",\n      \"priceFloat\" => \"\",\n      \"commentsArray\" => \"\",\n      \"galleryObject\" => \"\"\n    ];\n}\n\n', NULL, '2021-06-11 13:01:47', '2021-06-21 12:13:42', 'Kata 4: Evitar palabras del lenguaje', '73fda7d1-d7df-4f07-998b-651b512c5df0', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'endDateString\'] === \'endDate\')\n            && ($semanticNames[\'priceFloat\'] === \'price\')\n            && ($semanticNames[\'commentsArray\'] === \'comments\')\n            && ($semanticNames[\'galleryObject\'] === \'gallery\');\n        \n         $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(48, 'En ocasiones, puede que tengas que usar la misma variable para referirte a dos conceptos distintos.\n \nAlgunos genios utilizan la misma palabra con creativas faltas de ortografía como como **\"class\"** y **\"Klass\"**, otros cambian  letras por números o hacen uso de alguna otra ingeniosa, creativa y sorprendente solución. Pero lo cierto es que estas faltas de ortografía deberían hacernos el mismo daño a la vista que *“uevo”*, *“havlar”* o *“pescao”*.\n\n___\nImagina que el chico nuevo de la empresa ha desarrollado una pequeña funcionalidad que te hacen revisar y te encuentras con el siguiente código:\n\n```\n$klasses = $student->getClasses();\n$d4te = $course->getCreationDate();\n$name2 = $student->getName()\n\n```\n\nTira por la borda a ese grumete de agua dulce y corrige su código.\n', 'function getSemanticNames(): array\n{\n    return [\n        \"Klass\" => \"\",\n        \"d4te\" => \"\",\n        \"name2\" => \"\"\n    ];\n}', NULL, '2021-06-11 13:30:09', '2021-06-21 12:23:03', 'Kata 5: Evitar las faltas de ortografía', '4d72ee33-65b7-4fcc-ac4a-6ea7fde26089', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'Klass\'] === \'Class\')\n            && ($semanticNames[\'d4te\'] === \'date\')\n            && ($semanticNames[\'name2\'] === \'name\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}'),
(49, 'Hay palabras que no añaden un significado concreto, por ejemplo: **“info”**, ¿qué diantres es **\"info\"**? Por no mencionar que, para empezar, es una abreviatura.     \n**“Data”** es otra palabra que se ve bastante y, realmente, no añade un significado concreto.    \n¿Qué diferencia hay entre **“user”** y **“userData”**? ¿Una variable **\"user\"** no debería contener datos de un usuario? Entonces, ¿qué contiene **“userData”**? ¿datos de usuario? Cómo ves, realmente no aporta un significado concreto por lo que debería evitarse.\n\n___\nImagina que te toca solucionar un bug en el siguiente código:\n\n```\n$userData = $_POST[‘user’];\nIf ($this->validate($userData) ) {\n    // Create user\n}\n// ...\n$addressInfo = $_POST[\'info\']\nIf ($this->validate($addressInfo) ) {\n    // Create user info\n}\n```\nRefactoriza las variables', 'function getSemanticNames(): array\n{\n    return [\n        \"userData\" => \"\",\n        \"addressInfo\" => \"\"\n    ];\n}\n', NULL, '2021-06-11 13:42:36', '2021-06-21 13:03:16', 'Kata 6: Evitar palabras sin mucho sentido', '67965b95-bd90-4f19-a0d3-db100f34c5a1', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'userData\'] === \'user\')\n            && ($semanticNames[\'addressInfo\'] === \'address\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(51, 'Imagina que encuentras variables con nombres como:\n```\n$tokexptim \n$conSigDat\n$genymdhms \n```\n¿Sabrías cuál es el propósito de estas variables? ¿Quizá pasarías por la quilla a aquellos que han osado definirlas?\n\nUn buen nombre de una variable debe poder pronunciarse y ser lo suficientemente comprensible como para no tener que sacar una bola de cristal para adivinar el propósito de cada variable. Para las variables anteriores hubieran sido mejores nombres:   \n```\n$tokenExpirationTime \n$contractSignDate\n$generationDate \n```\n___\nImagina que tienes asignada una tarea relacionada con el inicio de sesión de un usuario y encuentras el siguiente código:   \n\n```// Get password\n$pwd = $user->getPwd();\n\n// Validate\nIf ( ! $this->validate($pwd) ) {\n\n            // Return invalid password message\n	return $this->invalidPwdMessage();\n\n}\n```\n¿Sabrías encontrar nombres más semánticos para las siguientes variables y métodos?\n```\n$pwd\n$user->getPwd()\n$this->showInvalidPwdMessage()\n```\n', 'function getSemanticNames(): array\n{\n    return [\n        \"pwd\" => \"\",\n        \"user->getPwd()\" => \"\",\n        \"this->showInvalidPwdMsg()\" => \"\"\n    ];\n}', NULL, '2021-06-14 11:19:45', '2021-06-21 15:24:50', 'Kata 7: Nombres que no se pueden pronunciar', 'c95d8795-7dad-4f0a-ad5e-c1ace91089f9', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'pwd\'] === \'password\')\n            && ($semanticNames[\'user->getPwd()\'] === \'user->getPassword()\')\n            && ($semanticNames[\'this->showInvalidPwdMsg()\'] === \'this->showInvalidPasswordMessage()\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(53, 'Imagina que necesitas buscar variables que estén relacionadas con un token. Ahora imagina que los  nombres utilizados para definir variables son algo así:\n\n```\n$tokExpTim\n$ymdhmsTok\n$authTok\n```\nCon estos \"mensajes encriptados\" va ser más complicado encontrar aquellas variables y funciones relacionadas con el código que encontrar la X con el mapa del tesoro. Los nombres que utilizan abreviaturas o son más cortos, acaban por ser más complicados de buscar. Para este caso hubieran sido mejores nombres:\n\n```\n$tokenExpirationTime\n$tokenCreationDate\n$authenticationToken\n```\nImagina que hay un bug en la creación de un pedido y encuentras el siguiente código que crea un pedido y le asigna la fecha en la que se ha creado.\n```\n// Create order\n$ord = new Order();\n\n// Get current date\n$ymdhms = new datetime();\n\n// Set current date\n$ord->setCreDat($ymdhms);\n\npublic function setCreDat(DateTime $ymdhms): void\n{\n    $this->creDat = $ymdhms;\n}\n```\nTu espíritu pirata se revuelve en tu interior y no puedes evitar refactorizar esos nombres abreviados por otros más **semánticos**.\n', 'function getSemanticNames(): array\n{\n    return [\n      \"ord\" => \"\",\n      \"ymdhms\" => \"\",\n      \"setCreDat()\" => \"\",\n      \"this->creDat\" => \"\"\n    ];\n}', NULL, '2021-06-14 11:34:14', '2021-06-21 15:32:29', 'Kata 8: Nombres que se pueden buscar', '59682441-9c21-4f9d-a89d-4b7a3165e780', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'ord\'] === \'order\')\n            && ($semanticNames[\'ymdhms\'] === \'currentDate\')\n            && ($semanticNames[\'setCreDat()\'] === \'setCreationDate()\')\n            && ($semanticNames[\'this->creDat\'] === \'this->creationDate\');\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}'),
(55, 'Aunque, en general, los nombres verbosos son mejor opción que los cortos, cualquier nombre es mejor que un maldito número. Habría que pasar por la quilla a aquellos botarates que osaran utilizar un número como variable.\n___\nImagina que trabajas en una plataforma de vídeos en la que, tras registrarse, el usuario tiene que confirmar su cuenta haciendo click en un enlace. El usuario no puede acceder al contenido hasta que no haya confirmado su cuenta por estar *“pendiente de confirmación”*. \n\n```````````````````````````````````````````````````````````````````````````````\nIf ($userStatus == 3) {\n    return $this->pendingConfirmationResponse();\n}\n```````````````````````````````````````````````````````````````````````````````\nComo buen pirata codificador, ese 3 debería sustituirse por una constante con un nombre lo suficientemente semántico.\n\n**Nota: recuerda que los nombres de las constantes se escriben en mayúscula con un guión bajo si hay espacios.**\n\n\n', 'function getSemanticNames(): array\n{\n	return [\n      \"3\" => \"\"\n      ];\n}\n', 'Para conocer más acerca de las constantes en PHP:\nhttps://www.php.net/manual/es/language.constants.php', '2021-06-14 11:47:52', '2021-06-21 15:39:32', 'Kata 9: Números mágicos', '79229820-bcdf-4f07-b33e-2f4761580e7a', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'3\'] === \'self::PENDING_CONFIRMATION_STATUS\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(57, 'Es posible que, en determinadas ocasiones, se considere añadir información extra para indicar el tipo de variable como por ejemplo:\n```\n$usersArray\n$dateString\n```\nO quizá indicar la visibilidad de las mismas con un ingenioso prefijo:\n```\n$_date: variable privada.\n$p_date: variable privada.\n\n```\nTodo esto es un auténtico excremento de gaviota y, salvo que trabajes en papiro, los IDE actuales son capaces de resolver este tipo de problemas, así como la ejecución del código que resultará en un error de tipo o de acceso.\n___\nImagina que tienes el siguiente código:\n\n```````````````````````````````````````````````````````````````````````````````\n$creationDateString = $creationDate->format(‘Y-m-d’);\n$this->str_email = $email;\n$this->str_password = $password;\n$this->txt_aboutMe = $aboutMe;\n$this->int_favouriteNumber = $favouriteNumber;\n```````````````````````````````````````````````````````````````````````````````\n\nRefactoriza los nombres de variables.', 'function getSemanticNames(): array\n{\n  return [\n    \"creationDateString\" => \"\",\n    \"this->str_email\" => \"\",\n    \"this->str_password\" => \"\",\n    \"this->txt_aboutMe\" => \"\",\n    \"this->int_favouriteNumber\" => \"\"\n    ];\n}', NULL, '2021-06-14 11:54:36', '2021-06-21 15:53:48', 'Kata 10: Evitar codificaciones', '5a0eec12-f672-4fa3-8df8-cfa581dfce25', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'creationDateString\'] === \'creationDate\')\n            && ($semanticNames[\'this->str_email\'] === \'this->email\')\n            && ($semanticNames[\'this->str_password\'] === \'this->password\')\n            && ($semanticNames[\'this->txt_aboutMe\'] === \'this->aboutMe\')\n            && ($semanticNames[\'this->int_favouriteNumber\'] === \'this->favouriteNumber\');\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}\n'),
(59, 'Se tiene que evitar que los lectores del código tengan que hacer una correspondencia entre las variables que están leyendo y el esquema mental del código que se hacen a medida que van comprendiendo el mismo.\n\nPor ejemplo, usar la variable $u para referirse a una URL. Esto obliga a hacer una asignación mental $u con una URL, lo cuál es una barbaridad.\n___\nEntre el código del proyecto has localizado algunos nombres de variables que ya te saltan un poco a la vista ya que no expresan claramente lo que son:\n\n```````````````````````````````````````````````````````````````````````````````\n$u = $request->getUrl();\n$un = $user->getUsername();\n$tmp = $myHome->getTemperature();\ncatch (Exception $e)\n```````````````````````````````````````````````````````````````````````````````\n¡Refactoriza esos nombres grumete!', 'function getSemanticNames(): array\n{\n	return [\n      \"u\" => \"\",\n      \"un\" => \"\",\n      \"tmp\" => \"\",\n      \"e\" => \"\"\n	];\n}\n', NULL, '2021-06-14 12:11:24', '2021-06-21 15:57:04', 'Kata 11: Evitar asignaciones mentales', '2ac0ba84-f937-4f04-b1ec-43d4bdbcdc2b', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'u\'] === \'url\')\n            && ($semanticNames[\'un\'] === \'username\')\n            && ($semanticNames[\'tmp\'] === \'temperature\')\n            && ($semanticNames[\'e\'] === \'exception\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}\n'),
(60, 'Cuando se está analizando una especificación, ésta tiene ciertos elementos que requieren de entidad propia. Las clases son una herramienta perfecta para modelar entidades del mundo del dominio del problema de la especificación.\n\nPor esta razón, los nombres de las clases deben modelar entidades como usuario (*user*), correo electrónico (*email*), contraseña (*password*), publicación (*post*), comentario (*comment*), factura (*bill*), pedido (*order*), etc.\n\nLos nombres de clases deberán ser siempre sustantivos pero nunca acciones (es decir, verbos).\n\nHay palabras que no aportan un significado concreto como pueden ser Manager, Processor, Data o Info, por lo que si no quieres que el capitán te haga saltar por la borda, ¡evítalas!\n___\nTe han encargado hacer una tienda en la que la compra se realiza a través de  una serie de pasos en los que hay que cumplimentar diversos formularios.\n\n**Artículos**\n\nEn este paso se confirman los artículos que hay en el carrito.\n```\n// Get items\n$itemsData = $_POST[‘data’]\n```\n\n**Datos de facturación**\n\nEn este paso se introducen los datos de facturación \n```\n// Get bill \n$billInfo = $_POST[‘data’]\n```\n**Dirección de envío**\n\nEn este paso se incluye la dirección de envío.\n```\n// Get shipment address\n$shipAddInfo = $_POST[‘data’]\n```\n\n```````````````````````````````````````````````````````````````````````````````\n¡Refactoriza esos nombres de acuerdo a lo aprendido!', 'function getSemanticNames(): array\n{\n	return [\n      \"itemsData\" => \"\",\n      \"billInfo\" => \"\",\n      \"shipAddInfo\" => \"\"\n	];\n}', NULL, '2021-06-14 12:27:07', '2021-06-21 16:00:28', 'Kata 12: Nombres de las clases', '670a91ca-4054-4f09-82c0-e82e33964849', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'itemsData\'] === \'items\')\n            && ($semanticNames[\'billInfo\'] === \'bill\')\n            && ($semanticNames[\'shipAddInfo\'] === \'shipmentAddress\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}'),
(61, 'Los nombres de los métodos deberían ser acciones que se producen sobre el mismo objeto. Por esta razón siempre se deberían usar verbos o frases con verbos. Por ejemplo: \n```\npublic function addPost() {}\npublic function calculateBill() {}\n```\nSi se espera una respuesta booleana, verdadero o falso, entonces los método deberían nombrarse en forma de pregunta total, como por ejemplo \n```\npublic function isConfirmed() {} \npublic function isPublished() {}\n```\n___\nImagina que tienes una aplicación blog donde encuentras los siguientes nombres de métodos:\n```\n// Remove a tag to the post\n$post->remTag($tag);\n\n// Publish at future date\n$post->pubFutDat($publicationDate);\n\n// Check if post is published\nIf ($post->published())\n\n ```\nRefactoriza esas expresiones\n', 'function getSemanticNames(): array\n{\n	return [\n      \"post->remTag()\" => \"\",\n      \"post->pubFutDat()\" => \"\",\n      \"post->published()\" => \"\"\n    ];         \n}', NULL, '2021-06-14 12:49:25', '2021-06-21 16:14:42', 'Kata 13: Nombres de los métodos', 'c8ae6193-a6ad-4fee-bc11-232fd5352ae9', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'post->remTag()\'] === \'post->removeTag()\')\n            && ($semanticNames[\'post->pubFutDat()\'] === \'post->publishAtFutureDate()\')\n            && ($semanticNames[\'post->published()\'] === \'post->isPublished()\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(62, 'Si los nombres son producto de alguna broma o gracia del momento, ésta sólo tendrá sentido para aquellos que la conozcan. Si un programador al que no le gustan los videojuegos se encuentra en la clase User con un método FinishHim() a lo Mortal Kombat, lo más probable es que no entienda el método hasta que no investigue un poco el contexto. El nombre delete() es un nombre más **semántico** que todo el mundo puede entender.  \n\nImagina que tienes una aplicación blog donde encuentras los siguientes métodos:\n```\n// Remove a tag\n$post -> obliviate($tag);\n\n// Publish post at a publication date\n$post->ascendioPostAt($publicationDate);\n\n// Show formatted Post\n$formattedPost = $post->accioPost();\n\n```\nAl parecer el grumete de agua dulce que escribió este código ha visto muchas películas de un cierto mago. Refactorízalo antes de que te salga la marca de un rayo en la frente.', 'function getSemanticNames(): array\n{\n	return [\n      \"post->obliviate()\"=>\"\",\n      \"post->ascendioPostAt()\"=>\"\",\n      \"post->accioPost()\"=>\"\",\n     ];\n}\n', '¿Alguien dijo Harry Potter por aquí?', '2021-06-16 12:01:41', '2021-06-21 16:34:25', 'Kata 14: No pasarse con las personalizaciones', '00d7679c-4023-4fc7-b6a7-c6d714254f27', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'post->obliviate()\'] === \'post->remove()\')\n            && ($semanticNames[\'post->ascendioPostAt()\'] === \'post->publishPostAt()\')\n            && ($semanticNames[\'post->accioPost()\'] === \'post->showFormattedPost()\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}\n'),
(83, 'A veces se utilizan diferentes nombres para un mismo concepto como por ejemplo: *get*, *fetch* o *retrieve*. Unificar en una palabra un mismo concepto contribuye a una mejor comprensión del código, ya que el uso de nombres diferentes puede llevar a pensar que se trata de mecanismos diferentes.\n\nPor ello es recomendable definir una palabra por concepto y seguir esa directriz. \n___\nImagina que tienes una aplicación blog donde encuentras los siguientes nombres de métodos:\n\n```\n// Get creation dates\n$userCreationDate = $user->getCreationDate();\n$postCreationDate = $post->retrievePublicationDate();\n$commentCreationDate = $comment->fetchCreationDate();\n\n// Set creation dates\n$user->setCreationDate($creationDate);\n$post->loadCreationDate($creationDate);\n$comment->putCreationDate($creationDate);\n\n// Find all \n$users = $usersRepository->findAll();\n$post = $postsRepository->lookForAll();\n$comments = $commentsRepository->searchAll();\n\n```\nSi se creó primero la entidad **User** y, de momento, no se quiere replantear los nombres, lo más sencillo es seguir la misma nomenclatura. Actualiza los nombres de las funciones para que coincidan con la entidad User.', 'function getSemanticNames(): array\n{\n	return [\n      \"post->retrievePublicationDate()\" => \"\",\n      \"comment->fetchCreationDate()\" => \"\",\n      \"post->loadCreationDate()\" => \"\",\n      \"comment->putCreationDate()\" => \"\",\n      \"postsRepository->lookForAll()\" => \"\",\n      \"commentsRepository->searchAll()\" => \"\"\n    ];\n}\n', '¡Piensa grumete! ¿Qué verbos utiliza la entidad User?', '2021-06-16 14:51:05', '2021-06-21 16:41:06', 'Kata 15: Elegir una palabra por concepto', 'd6fe74f0-1889-4f6d-881e-ba5d83379ea4', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'post->retrievePublicationDate()\'] === \'post->getPublicationDate()\')\n&& ($semanticNames[\'comment->fetchCreationDate()\'] === \'comment->getCreationDate()\')\n&& ($semanticNames[\'post->loadCreationDate()\'] === \'post->setCreationDate()\')\n&& ($semanticNames[\'comment->putCreationDate()\'] === \'comment->setCreationDate()\')\n&& ($semanticNames[\'postsRepository->lookForAll()\'] === \'postsRepository->findAll()\')\n&& ($semanticNames[\'commentsRepository->searchAll()\'] === \'commentsRepository->findAll()\');\n\n   	 \n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}'),
(85, 'El dominio del problema es el lenguaje que se utiliza para describir el problema que queremos resolver sin entrar en la parte técnica.   \n \nPor ejemplo, el desarrollo de un proceso que envíe notificaciones por correo electrónico a clientes que tengan la última factura pendiente de pago, enviando dichas notificaciones por orden de deuda acumulada, siendo los primero los que más deuda acumulada tengan.\n\nEl dominio del problema puede estar compuesto por conceptos como: *notificación*, *correo electrónico*, *facturas*, *pendientes de pagar*.\n\nSe quiere enviar una serie de notificaciones por correo electrónico a clientes que tienen facturas impagadas. Para ello, en primer lugar, se obtienen todos aquellos clientes que tengan al menos una factura impagada. El orden de las notificaciones dependerá de la deuda que tenga el cliente. A más deuda más prioridad por lo que hay que ordenar el listado de impagos. \n\nEsta funcionalidad está encapsulada en la clase siguiente:\n```\n// Find all unpaid bills\n$unpbil = $billsRepository->findUnpaidBills();\n\n// Sort bills by descending amount\n$sorUnpBilBDesAmo = $this->sortByDescAmo($unpbil)\n\n// Get defaulters \n$fuckingDefaulters =  $this->getDefaulters($sUnpBil);\n\nforeach($fuckingDefaulters as $df) {\n    // Sent notification\n    $poen = new PendingOrderEmailNotification();\n    $poen->setToEmail($fd->getEmail());\n    $poen->send();\n}\n\n```\n¿Qué nombres del dominio se deberían haber elegido?\n', 'function getSemanticNames(): array\n{\n    return [\n      \"unpbil\" => \"\",\n      \"sorUnpBilByAmoDes\" => \"\",\n      \"fuckingDefaulters\" => \"\",\n      \"df\" => \"\",\n      \"poen\" => \"\"\n    ];\n}', NULL, '2021-06-16 14:53:49', '2021-06-21 17:54:48', 'Kata 16: Usar nombres de dominio de problemas', 'b932d9d5-bcd4-4f3e-a30a-7820a93e6ac8', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n    function testKata()\n    {\n        $kataSourceCode= new KataSourceCode();\n        $semanticNames = $kataSourceCode->getSemanticNames();\n\n        $areSemanticNamesValid = ($semanticNames[\'unpbil\'] === \'unpaidBill\')\n          && ($semanticNames[\'sorUnpBilByAmoDes\'] === \'sortedUnpaidBillsByDescendingAmount\')\n          && ($semanticNames[\'fuckingDefaulters\'] === \'defaulters\')\n          && ($semanticNames[\'df\'] === \'defaulter\')\n          && ($semanticNames[\'poen\'] === \'pendingOrderEmailNotification\');\n        \n        $this->assertTrue($areSemanticNamesValid);\n    }\n}\n'),
(86, 'Cuando se elige un nombre semántico para una variable, éste no tiene un significado específico si no está incluido en un contexto concreto. \nPor ejemplo, la variable **$status** hace referencia a un estado pero si se tienen varias entidades en la misma función no se sabría a cuál de ellas se está haciendo referencia salvo retrocediendo en el código.\n\nEn aquellos casos en los que el código quede ambiguo, es más que recomendable refactorizar el nombre incluyendo el nombre de la entidad, como por ejemplo $userStatus o $postStatus. De esta manera no cabe duda de a qué entidad está haciendo referencia esa propiedad.\n\nUna solución aún mejor sería incluir ese atributo en la clase User o la clase Post para acceder al mismo a través de un método getStatus con lo que también estaríamos eliminando la ambigüedad:\n```\n$user->getStatus();\n$post->getStatus();\n```\n___\nImagina que tienes el siguiente código y solo tienes dos opciones: refactorizar el código o emborracharte con grog. Opta por lo primero que da menos resaca.\n```\n$status = $user->getStatus();\n\n// Check if user’s status is pending to confirm \nIf ($status == 2) {\n    throw new StatusUserIsPendingToConfirm();\n    return ;\n}\n\n$status2 = $post->getStatus();\n// Check if status post is a draft\nIf ($status2 == 3) {\n    throw new StatusPostIsADraft();\n}\n```\nEs recomendable evitar los números mágicos y convertirlos en constantes que contengan ese número. Para este proyecto se ha adoptado la convención de nombrar las constantes con mayúsculas y notación underscore. \n\n**Nota: el nombre de estas constantes debería describir el nombre de la entidad y el estado de la misma.**\n', 'function getSemanticNames(): array\n{\n	return [\n      \"status\" => \"\",\n      \"2\" => \"\",\n      \"status2\" => \"\",\n      \"3\" => \"\",\n     ];\n}', NULL, '2021-06-16 14:55:36', '2021-06-21 18:02:27', 'Kata 17: Añadir un contexto con significado', 'de620627-680a-4fb0-b860-3d9ea43ba8f7', '<?php\nnamespace PhpunitExecutionFromPhpTemporary;\n\nuse PHPUnit\\Framework\\TestCase;\n\nclass KataTest extends TestCase\n{\n	function testKata()\n	{\n    	$kataSourceCode= new KataSourceCode();\n    	$semanticNames = $kataSourceCode->getSemanticNames();\n\n    	$areSemanticNamesValid = ($semanticNames[\'status\'] === \'userStatus\')\n		&& ($semanticNames[\'2\'] === \'UserStatus::PENDING_TO_CONFIRM\')\n		&& ($semanticNames[\'status2\'] === \'postStatus\')\n		&& ($semanticNames[\'3\'] === \'PostStatus::DRAFT\');\n    	$this->assertTrue($areSemanticNamesValid);\n	}\n}')
EOD;
$this->addSql($sqlKatas);

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}