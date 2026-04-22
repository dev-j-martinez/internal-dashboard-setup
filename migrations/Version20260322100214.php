<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260322100214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payslip (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gross_amount NUMERIC(10, 2) NOT NULL, net_amount NUMERIC(10, 2) NOT NULL, payment_date DATETIME NOT NULL, status VARCHAR(50) NOT NULL, employee_id INTEGER NOT NULL, CONSTRAINT FK_9A13CDF08C03F15C FOREIGN KEY (employee_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9A13CDF08C03F15C ON payslip (employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE payslip');
    }
}
