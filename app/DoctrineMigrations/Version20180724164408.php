<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180724164408 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dean_student (id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hodteacher (id VARCHAR(255) NOT NULL, hod_id VARCHAR(255) DEFAULT NULL, teacher_id VARCHAR(255) DEFAULT NULL, book_id VARCHAR(255) DEFAULT NULL, transaction_type VARCHAR(255) NOT NULL, transaction_date VARCHAR(255) NOT NULL, INDEX IDX_DB5BB56D6343B07E (hod_id), INDEX IDX_DB5BB56D41807E1D (teacher_id), INDEX IDX_DB5BB56D16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE librarian_hod (id VARCHAR(255) NOT NULL, librarian_id VARCHAR(255) DEFAULT NULL, hod_id VARCHAR(255) DEFAULT NULL, book_id VARCHAR(255) DEFAULT NULL, transaction_type VARCHAR(255) NOT NULL, transaction_date DATETIME NOT NULL, INDEX IDX_F73B4148D8B58D1F (librarian_id), INDEX IDX_F73B41486343B07E (hod_id), INDEX IDX_F73B414816A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher_student (id VARCHAR(255) NOT NULL, student_id VARCHAR(255) DEFAULT NULL, teacher_id VARCHAR(255) DEFAULT NULL, book_id VARCHAR(255) DEFAULT NULL, transaction_type VARCHAR(255) NOT NULL, transaction_date DATETIME NOT NULL, INDEX IDX_7AE12272CB944F1A (student_id), INDEX IDX_7AE1227241807E1D (teacher_id), INDEX IDX_7AE1227216A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hodteacher ADD CONSTRAINT FK_DB5BB56D6343B07E FOREIGN KEY (hod_id) REFERENCES head_of_department (id)');
        $this->addSql('ALTER TABLE hodteacher ADD CONSTRAINT FK_DB5BB56D41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE hodteacher ADD CONSTRAINT FK_DB5BB56D16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE librarian_hod ADD CONSTRAINT FK_F73B4148D8B58D1F FOREIGN KEY (librarian_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE librarian_hod ADD CONSTRAINT FK_F73B41486343B07E FOREIGN KEY (hod_id) REFERENCES head_of_department (id)');
        $this->addSql('ALTER TABLE librarian_hod ADD CONSTRAINT FK_F73B414816A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE12272CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE1227241807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE teacher_student ADD CONSTRAINT FK_7AE1227216A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE dean_student');
        $this->addSql('DROP TABLE hodteacher');
        $this->addSql('DROP TABLE librarian_hod');
        $this->addSql('DROP TABLE teacher_student');
    }
}
