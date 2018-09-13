<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180716082206 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE head_of_department ADD created_by_id VARCHAR(255) DEFAULT NULL, ADD modified_by_id VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD modified_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE head_of_department ADD CONSTRAINT FK_150337F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE head_of_department ADD CONSTRAINT FK_150337F399049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_150337F3B03A8386 ON head_of_department (created_by_id)');
        $this->addSql('CREATE INDEX IDX_150337F399049ECE ON head_of_department (modified_by_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE head_of_department DROP FOREIGN KEY FK_150337F3B03A8386');
        $this->addSql('ALTER TABLE head_of_department DROP FOREIGN KEY FK_150337F399049ECE');
        $this->addSql('DROP INDEX IDX_150337F3B03A8386 ON head_of_department');
        $this->addSql('DROP INDEX IDX_150337F399049ECE ON head_of_department');
        $this->addSql('ALTER TABLE head_of_department DROP created_by_id, DROP modified_by_id, DROP created_at, DROP modified_at');
    }
}
