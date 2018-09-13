<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180712091016 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metadata ADD edition VARCHAR(255) NOT NULL, ADD class VARCHAR(255) NOT NULL, ADD book_type VARCHAR(255) NOT NULL, DROP author3, DROP author4, DROP author5, CHANGE author2 author2 LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metadata ADD author3 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD author4 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD author5 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP edition, DROP class, DROP book_type, CHANGE author2 author2 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
