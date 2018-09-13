<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180716083913 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE head_of_department DROP FOREIGN KEY FK_150337F341807E1D');
        $this->addSql('ALTER TABLE head_of_department ADD CONSTRAINT FK_150337F341807E1D FOREIGN KEY (teacher_id) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE head_of_department DROP FOREIGN KEY FK_150337F341807E1D');
        $this->addSql('ALTER TABLE head_of_department ADD CONSTRAINT FK_150337F341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
    }
}
