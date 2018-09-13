<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171116121523 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE metadata (id VARCHAR(255) NOT NULL, category_id VARCHAR(255) DEFAULT NULL, created_by_id VARCHAR(255) DEFAULT NULL, modified_by_id VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, author2 VARCHAR(255) DEFAULT NULL, author3 VARCHAR(255) DEFAULT NULL, author4 VARCHAR(255) DEFAULT NULL, author5 VARCHAR(255) DEFAULT NULL, publisher VARCHAR(255) DEFAULT NULL, isbn VARCHAR(255) DEFAULT NULL, year_published VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME NOT NULL, INDEX IDX_4F14341412469DE2 (category_id), INDEX IDX_4F143414B03A8386 (created_by_id), INDEX IDX_4F14341499049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F14341412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F143414B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE metadata ADD CONSTRAINT FK_4F14341499049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2 ON book');
        $this->addSql('ALTER TABLE book ADD metadata_id VARCHAR(255) DEFAULT NULL, DROP category_id, DROP title, DROP author, DROP author2, DROP author3, DROP author4, DROP author5, DROP publisher, DROP isbn, DROP year_published, DROP number_of_books, DROP available_books');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331DC9EE959 FOREIGN KEY (metadata_id) REFERENCES metadata (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331DC9EE959 ON book (metadata_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331DC9EE959');
        $this->addSql('DROP TABLE metadata');
        $this->addSql('DROP INDEX IDX_CBE5A331DC9EE959 ON book');
        $this->addSql('ALTER TABLE book ADD title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD author VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD author2 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD author3 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD author4 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD author5 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD publisher VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD isbn VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD year_published VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD number_of_books INT DEFAULT NULL, ADD available_books INT DEFAULT NULL, CHANGE metadata_id category_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
    }
}
