<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190321074206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE companie_employee ADD added_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE companie_employee ADD CONSTRAINT FK_91636C0B55B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_91636C0B55B127A4 ON companie_employee (added_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE companie_employee DROP FOREIGN KEY FK_91636C0B55B127A4');
        $this->addSql('DROP INDEX IDX_91636C0B55B127A4 ON companie_employee');
        $this->addSql('ALTER TABLE companie_employee DROP added_by_id');
    }
}
