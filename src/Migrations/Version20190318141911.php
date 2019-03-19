<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190318141911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE companie_employee (id INT AUTO_INCREMENT NOT NULL, companie_id INT NOT NULL, enter_at DATETIME NOT NULL, out_at DATETIME NOT NULL, INDEX IDX_91636C0B9DC4CE1F (companie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companie_employee_employee (companie_employee_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_1A2A887677E73E09 (companie_employee_id), INDEX IDX_1A2A88768C03F15C (employee_id), PRIMARY KEY(companie_employee_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE companie_employee ADD CONSTRAINT FK_91636C0B9DC4CE1F FOREIGN KEY (companie_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE companie_employee_employee ADD CONSTRAINT FK_1A2A887677E73E09 FOREIGN KEY (companie_employee_id) REFERENCES companie_employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE companie_employee_employee ADD CONSTRAINT FK_1A2A88768C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE companie_employee_employee DROP FOREIGN KEY FK_1A2A887677E73E09');
        $this->addSql('DROP TABLE companie_employee');
        $this->addSql('DROP TABLE companie_employee_employee');
    }
}
