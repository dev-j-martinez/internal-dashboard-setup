<?php

namespace App\DataFixtures;

use App\Entity\Announcement;
use App\Entity\Department;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Create Departments
        $hr = new Department();
        $hr->setName('Human Resources');
        $hr->setDescription('Takes care of the people.');
        $manager->persist($hr);

        $eng = new Department();
        $eng->setName('Engineering');
        $eng->setDescription('Builds the products.');
        $manager->persist($eng);

        $marketing = new Department();
        $marketing->setName('Marketing');
        $marketing->setDescription('Promotes the company.');
        $manager->persist($marketing);

        // Create Admin User
        $admin = new User();
        $admin->setEmail('admin@company.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $admin->setName('Admin Supervisor');
        $admin->setJobTitle('Administrator');
        $admin->setBankAccountNumber('ES9121000418401234567890');
        $admin->setSocialSecurityNumber('123-45-6789');
        $admin->setSalary('120000.00');
        $admin->setAddress('Calle de la Innovación 12, 5A, 28001 Madrid');
        $manager->persist($admin);

        // Create Standard Users
        $employee1 = new User();
        $employee1->setEmail('alice@company.com');
        $employee1->setPassword($this->hasher->hashPassword($employee1, 'password'));
        $employee1->setName('Alice Smith');
        $employee1->setJobTitle('Software Engineer');
        $employee1->setDepartment($eng);
        $employee1->setBankAccountNumber('ES9121000418401234567891');
        $employee1->setSocialSecurityNumber('987-65-4321');
        $employee1->setSalary('95000.00');
        $employee1->setAddress('Av. de Barcelona 45, Planta Baja, 08001 Barcelona');
        $manager->persist($employee1);

        $employee2 = new User();
        $employee2->setEmail('bob@company.com');
        $employee2->setPassword($this->hasher->hashPassword($employee2, 'password'));
        $employee2->setName('Bob Johnson');
        $employee2->setJobTitle('HR Manager');
        $employee2->setDepartment($hr);
        $employee2->setBankAccountNumber('ES9121000418401234567892');
        $employee2->setSocialSecurityNumber('456-78-1234');
        $employee2->setSalary('85000.00');
        $employee2->setAddress('Paseo de Gracia 10, 3B, 41001 Sevilla');
        $manager->persist($employee2);

        // Create Announcements
        $ann1 = new Announcement();
        $ann1->setTitle('Welcome to our new Intranet!');
        $ann1->setContent('We are excited to launch the new company intranet. Feel free to explore the directory and check company news here.');
        $ann1->setAuthor($admin);
        $manager->persist($ann1);

        $ann2 = new Announcement();
        $ann2->setTitle('Upcoming Q3 Meeting');
        $ann2->setContent('Please be reminded that our all-hands Q3 meeting will be held next Friday in the main conference room.');
        $ann2->setAuthor($admin);
        $manager->persist($ann2);

        $manager->flush();
    }
}
