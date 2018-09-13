<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180716081730 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE head_of_department (id VARCHAR(255) NOT NULL, teacher_id VARCHAR(255) DEFAULT NULL, subject_id VARCHAR(255) DEFAULT NULL, INDEX IDX_150337F341807E1D (teacher_id), INDEX IDX_150337F323EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE replacement (id VARCHAR(255) NOT NULL, book_id VARCHAR(255) DEFAULT NULL, student_id VARCHAR(255) DEFAULT NULL, received_by_id VARCHAR(255) DEFAULT NULL, reason VARCHAR(255) NOT NULL, replaced_at DATETIME NOT NULL, INDEX IDX_54D5F44A16A2B381 (book_id), INDEX IDX_54D5F44ACB944F1A (student_id), INDEX IDX_54D5F44A6F8DDD17 (received_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id VARCHAR(255) NOT NULL, user_id VARCHAR(255) DEFAULT NULL, subject_id VARCHAR(255) DEFAULT NULL, created_by_id VARCHAR(255) DEFAULT NULL, updated_by_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B0F6A6D5A76ED395 (user_id), INDEX IDX_B0F6A6D523EDC87 (subject_id), INDEX IDX_B0F6A6D5B03A8386 (created_by_id), INDEX IDX_B0F6A6D5896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE head_of_department ADD CONSTRAINT FK_150337F341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE head_of_department ADD CONSTRAINT FK_150337F323EDC87 FOREIGN KEY (subject_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE replacement ADD CONSTRAINT FK_54D5F44A16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE replacement ADD CONSTRAINT FK_54D5F44ACB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE replacement ADD CONSTRAINT FK_54D5F44A6F8DDD17 FOREIGN KEY (received_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D523EDC87 FOREIGN KEY (subject_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book ADD hod_assigned_id VARCHAR(255) DEFAULT NULL, ADD teacher_assigned_id VARCHAR(255) DEFAULT NULL, ADD student_assigned_id VARCHAR(255) DEFAULT NULL, ADD librarian_assigned_id VARCHAR(255) DEFAULT NULL, ADD stage VARCHAR(255) NOT NULL, ADD state VARCHAR(255) NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE barcode barcode VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3318A5F6F00 FOREIGN KEY (hod_assigned_id) REFERENCES head_of_department (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331370CA64F FOREIGN KEY (teacher_assigned_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33136B01706 FOREIGN KEY (student_assigned_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331A82C501E FOREIGN KEY (librarian_assigned_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3318A5F6F00 ON book (hod_assigned_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331370CA64F ON book (teacher_assigned_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33136B01706 ON book (student_assigned_id)');
        $this->addSql('CREATE INDEX IDX_CBE5A331A82C501E ON book (librarian_assigned_id)');
        $this->addSql('ALTER TABLE student ADD current_class INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3318A5F6F00');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331370CA64F');
        $this->addSql('ALTER TABLE head_of_department DROP FOREIGN KEY FK_150337F341807E1D');
        $this->addSql('DROP TABLE head_of_department');
        $this->addSql('DROP TABLE replacement');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33136B01706');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331A82C501E');
        $this->addSql('DROP INDEX IDX_CBE5A3318A5F6F00 ON book');
        $this->addSql('DROP INDEX IDX_CBE5A331370CA64F ON book');
        $this->addSql('DROP INDEX IDX_CBE5A33136B01706 ON book');
        $this->addSql('DROP INDEX IDX_CBE5A331A82C501E ON book');
        $this->addSql('ALTER TABLE book DROP hod_assigned_id, DROP teacher_assigned_id, DROP student_assigned_id, DROP librarian_assigned_id, DROP stage, DROP state, CHANGE status status VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE barcode barcode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE student DROP current_class');
    }
}
