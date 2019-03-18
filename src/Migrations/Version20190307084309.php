<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307084309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, companie_name VARCHAR(255) NOT NULL, nb_projects INT DEFAULT NULL, city VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, phone_number VARCHAR(10) DEFAULT NULL, turnover INT DEFAULT NULL, social_reason VARCHAR(255) NOT NULL, effective INT DEFAULT NULL, type_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companie_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, email VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, project_name VARCHAR(255) NOT NULL, started_at DATETIME NOT NULL, ended_at DATETIME DEFAULT NULL, statut INT NOT NULL, city VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code INT NOT NULL, cost INT DEFAULT NULL, img_path VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_contacts (project_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_59DDF69A166D1F9C (project_id), INDEX IDX_59DDF69A8C03F15C (employee_id), PRIMARY KEY(project_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects_companies (project_id INT NOT NULL, companies_id INT NOT NULL, INDEX IDX_5BF86D05166D1F9C (project_id), INDEX IDX_5BF86D056AE4741E (companies_id), PRIMARY KEY(project_id, companies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, email VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects_contacts ADD CONSTRAINT FK_59DDF69A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_contacts ADD CONSTRAINT FK_59DDF69A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_companies ADD CONSTRAINT FK_5BF86D05166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_companies ADD CONSTRAINT FK_5BF86D056AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projects_companies DROP FOREIGN KEY FK_5BF86D056AE4741E');
        $this->addSql('ALTER TABLE projects_contacts DROP FOREIGN KEY FK_59DDF69A8C03F15C');
        $this->addSql('ALTER TABLE projects_contacts DROP FOREIGN KEY FK_59DDF69A166D1F9C');
        $this->addSql('ALTER TABLE projects_companies DROP FOREIGN KEY FK_5BF86D05166D1F9C');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE companie_type');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE projects_contacts');
        $this->addSql('DROP TABLE projects_companies');
        $this->addSql('DROP TABLE user');
    }
}
