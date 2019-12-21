<?php declare(strict_types=1);

namespace Oxidmod\Messages\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180616135411 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('
            CREATE TABLE send_log_aggregated (
                id INT AUTO_INCREMENT NOT NULL,
                usr_id INT NOT NULL,
                cnt_id INT NOT NULL,
                log_date DATE NOT NULL,
                message_number_success INT NOT NULL, 
                message_number_fail INT NOT NULL, 
                INDEX IDX_DATE(log_date),
                INDEX IDX_USER_DATE(usr_id, log_date),
                INDEX IDX_COUNTRY_DATE(cnt_id, log_date),
                INDEX IDX_USER_COUNTRY_DATE(usr_id, cnt_id, log_date),
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');

        $this->addSql('ALTER TABLE send_log_aggregated ADD CONSTRAINT FK_USER_ID FOREIGN KEY (usr_id) REFERENCES users (usr_id)');
        $this->addSql('ALTER TABLE send_log_aggregated ADD CONSTRAINT FK_COUNTRY_ID FOREIGN KEY (cnt_id) REFERENCES countries (cnt_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE send_log_aggregated');
    }
}
