<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009133403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information_user ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE information_user ADD CONSTRAINT FK_AC3BDF54A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC3BDF54A76ED395 ON information_user (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE information_user DROP FOREIGN KEY FK_AC3BDF54A76ED395');
        $this->addSql('DROP INDEX UNIQ_AC3BDF54A76ED395 ON information_user');
        $this->addSql('ALTER TABLE information_user DROP user_id');
    }
}
