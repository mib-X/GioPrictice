<?php

use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Dotenv\Dotenv;

require_once "./vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/src/.env');

$params = ['host' => $_ENV['HOST'],
    'user' => $_ENV['DB_USER'],
    'dbname' => $_ENV['DB_NAME'],
    'password' => $_ENV['DB_PASS'],
    'driver' => 'pdo_mysql'
];

try {
    $connection = DriverManager::getConnection($params);
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    $entityManager = new EntityManager(
        $connection,
        ORMSetup::createAttributeMetadataConfiguration([__DIR__ . "/src/App/Entity"])
    );
} catch (MissingMappingDriverImplementation $e) {
    echo $e->getMessage();
}





$email = 'test@gmail1.com';
//$userToUpdate = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
//$userToUpdate->getInvoices()->get(3)->setAmount(123);

$queryBuilder = $entityManager->createQueryBuilder();
$query = $queryBuilder->select('u')
    ->from(User::class, 'u')
    ->where('u.fullName LIKE :name')
    ->setParameter('name', '%Ivan%')
    ->getQuery();

/**@var User $user*/
$result = $query->getResult();

foreach ($result as $user) {
    echo $user->getFullName() . " - " . $user->getEmail() . " - " . $user->isActive() . PHP_EOL;
}

//if (null !== $userToUpdate) {
//    echo "User with $email is already exists";
//} else {
//    $userToUpdate = new User();
//    $userToUpdate->setEmail($email)
//        ->setFullName('Ivan Ivanov')
//        ->setIsActive(true)
//        ->setCreatedAt((new DateTime()));
//}
//
//$invoice = new App\Entity\Invoice();
//$invoice->setAmount(450)
//    ->setInvoiceStatus(\App\Enums\InvoiceStatus::WAITING)
//    ->setUser($userToUpdate);
//$invoice1 = new App\Entity\Invoice();
//$invoice1->setAmount(500)
//    ->setInvoiceStatus(\App\Enums\InvoiceStatus::WAITING)
//    ->setUser($userToUpdate);
//$invoice2 = new App\Entity\Invoice();
//$invoice2->setAmount(600)
//    ->setInvoiceStatus(\App\Enums\InvoiceStatus::PAID)
//    ->setUser($userToUpdate);
//
//$userToUpdate->addInvoice($invoice);
//$userToUpdate->addInvoice($invoice1);
//$userToUpdate->addInvoice($invoice2);
//$entityManager->persist($userToUpdate);

try {
    $entityManager->flush();
} catch (OptimisticLockException | ORMException $e) {
}
