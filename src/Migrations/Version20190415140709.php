<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415140709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE companies (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, companie_name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, phone_number VARCHAR(10) DEFAULT NULL, turnover INT DEFAULT NULL, social_reason VARCHAR(255) NOT NULL, effective INT DEFAULT NULL, INDEX IDX_8244AA3AC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE companie_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, companie_id INT NOT NULL, added_by_id INT NOT NULL, added_at DATETIME NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, email VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), INDEX IDX_5D9F75A19DC4CE1F (companie_id), INDEX IDX_5D9F75A155B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, project_name VARCHAR(255) NOT NULL, started_at DATETIME NOT NULL, ended_at DATETIME DEFAULT NULL, statut INT NOT NULL, city VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code INT NOT NULL, cost INT DEFAULT NULL, img VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_2FB3D0EEB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_companies (project_id INT NOT NULL, companies_id INT NOT NULL, INDEX IDX_9378EFED166D1F9C (project_id), INDEX IDX_9378EFED6AE4741E (companies_id), PRIMARY KEY(project_id, companies_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_employee (project_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_60D1FE7A166D1F9C (project_id), INDEX IDX_60D1FE7A8C03F15C (employee_id), PRIMARY KEY(project_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(10) NOT NULL, email VARCHAR(180) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3AC54C8C93 FOREIGN KEY (type_id) REFERENCES companie_type (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A19DC4CE1F FOREIGN KEY (companie_id) REFERENCES companies (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A155B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_companies ADD CONSTRAINT FK_9378EFED166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_companies ADD CONSTRAINT FK_9378EFED6AE4741E FOREIGN KEY (companies_id) REFERENCES companies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_employee ADD CONSTRAINT FK_60D1FE7A166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_employee ADD CONSTRAINT FK_60D1FE7A8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A19DC4CE1F');
        $this->addSql('ALTER TABLE project_companies DROP FOREIGN KEY FK_9378EFED6AE4741E');
        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3AC54C8C93');
        $this->addSql('ALTER TABLE project_employee DROP FOREIGN KEY FK_60D1FE7A8C03F15C');
        $this->addSql('ALTER TABLE project_companies DROP FOREIGN KEY FK_9378EFED166D1F9C');
        $this->addSql('ALTER TABLE project_employee DROP FOREIGN KEY FK_60D1FE7A166D1F9C');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A155B127A4');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB03A8386');
        $this->addSql('DROP TABLE companies');
        $this->addSql('DROP TABLE companie_type');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_companies');
        $this->addSql('DROP TABLE project_employee');
        $this->addSql('DROP TABLE user');
    }
}
