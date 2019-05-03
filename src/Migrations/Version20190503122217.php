<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190503122217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_file ADD CONSTRAINT FK_B50EFE0855B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B50EFE0855B127A4 ON project_file (added_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE project_file DROP FOREIGN KEY FK_B50EFE0855B127A4');
        $this->addSql('DROP INDEX IDX_B50EFE0855B127A4 ON project_file');
    }
}
