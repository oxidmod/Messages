<?php

declare(strict_types=1);

namespace Oxidmod\Messages\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180616113131 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE numbers (
                num_id INT AUTO_INCREMENT NOT NULL,
                cnt_id INT NOT NULL, 
                num_number VARCHAR(255) NOT NULL, 
                num_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
                INDEX IDX_779ECAF964FD3E92 (cnt_id), 
                PRIMARY KEY(num_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE numbers ADD CONSTRAINT FK_779ECAF964FD3E92 FOREIGN KEY (cnt_id) REFERENCES countries (cnt_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE numbers');
    }
}
