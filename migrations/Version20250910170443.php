<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910170443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card CHANGE ability2_name ability2_name VARCHAR(100) DEFAULT NULL, CHANGE ability2_type ability2_type VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE user_booster DROP FOREIGN KEY FK_B77B81A7F85E4930');
        $this->addSql('ALTER TABLE user_booster CHANGE booster_id booster_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_booster ADD CONSTRAINT FK_B77B81A7F85E4930 FOREIGN KEY (booster_id) REFERENCES booster (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card CHANGE ability2_name ability2_name VARCHAR(100) DEFAULT \'NULL\', CHANGE ability2_type ability2_type VARCHAR(50) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE user_booster DROP FOREIGN KEY FK_B77B81A7F85E4930');
        $this->addSql('ALTER TABLE user_booster CHANGE booster_id booster_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_booster ADD CONSTRAINT FK_B77B81A7F85E4930 FOREIGN KEY (booster_id) REFERENCES booster (id)');
    }
}
