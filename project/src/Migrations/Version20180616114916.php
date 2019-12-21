<?php

declare(strict_types=1);

namespace Oxidmod\Messages\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180616114916 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE send_log (
                log_id INT AUTO_INCREMENT NOT NULL,
                usr_id INT NOT NULL, 
                num_id INT NOT NULL, 
                log_message VARCHAR(255) NOT NULL, 
                log_success TINYINT(1) NOT NULL, 
                log_created DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                INDEX IDX_232F3BDCC69D3FB (usr_id),
                INDEX IDX_232F3BDCE24293CA (num_id),
                PRIMARY KEY(log_id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('ALTER TABLE send_log ADD CONSTRAINT FK_232F3BDCC69D3FB FOREIGN KEY (usr_id) REFERENCES users (usr_id)');
        $this->addSql('ALTER TABLE send_log ADD CONSTRAINT FK_232F3BDCE24293CA FOREIGN KEY (num_id) REFERENCES numbers (num_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE send_log');
    }
}
