<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321104759 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE project_companies (project_id INT NOT NULL, companies_id INT NOT NULL, INDEX IDX_9378EFED166D1F9C (project_id), INDEX IDX_9378EFED6AE4741E (companies_id), PRIMARY KEY(project_id, companies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_employee (project_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_60D1FE7A166D1F9C (project_id), INDEX IDX_60D1FE7A8C03F15C (employee_id), PRIMARY KEY(project_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_companies ADD CONSTRAINT FK_9378EFED166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_companies ADD CONSTRAINT FK_9378EFED6AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_employee ADD CONSTRAINT FK_60D1FE7A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_employee ADD CONSTRAINT FK_60D1FE7A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE projects_companies');
        $this->addSql('DROP TABLE projects_contacts');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE projects_companies (project_id INT NOT NULL, companies_id INT NOT NULL, INDEX IDX_5BF86D05166D1F9C (project_id), INDEX IDX_5BF86D056AE4741E (companies_id), PRIMARY KEY(project_id, companies_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projects_contacts (project_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_59DDF69A166D1F9C (project_id), INDEX IDX_59DDF69A8C03F15C (employee_id), PRIMARY KEY(project_id, employee_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE projects_companies ADD CONSTRAINT FK_5BF86D05166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_companies ADD CONSTRAINT FK_5BF86D056AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_contacts ADD CONSTRAINT FK_59DDF69A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects_contacts ADD CONSTRAINT FK_59DDF69A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE project_companies');
        $this->addSql('DROP TABLE project_employee');
    }
}
