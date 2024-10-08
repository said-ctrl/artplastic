<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241008073655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits ADD code_promo_id INT DEFAULT NULL, DROP code_promo');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C294102D4 FOREIGN KEY (code_promo_id) REFERENCES code_promo (id)');
        $this->addSql('CREATE INDEX IDX_BE2DDF8C294102D4 ON produits (code_promo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C294102D4');
        $this->addSql('DROP INDEX IDX_BE2DDF8C294102D4 ON produits');
        $this->addSql('ALTER TABLE produits ADD code_promo VARCHAR(255) NOT NULL, DROP code_promo_id');
    }
}
