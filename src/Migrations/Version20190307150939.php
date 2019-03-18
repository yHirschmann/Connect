<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307150939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE companies CHANGE type_id type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE companies ADD CONSTRAINT FK_8244AA3AC54C8C93 FOREIGN KEY (type_id) REFERENCES companie_type (id)');
        $this->addSql('CREATE INDEX IDX_8244AA3AC54C8C93 ON companies (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE companies DROP FOREIGN KEY FK_8244AA3AC54C8C93');
        $this->addSql('DROP INDEX IDX_8244AA3AC54C8C93 ON companies');
        $this->addSql('ALTER TABLE companies CHANGE type_id type_id INT NOT NULL');
    }
}
