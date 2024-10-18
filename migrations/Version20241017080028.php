<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017080028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_produits (commande_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_680DC71682EA2E54 (commande_id), INDEX IDX_680DC716CD11A2CF (produits_id), PRIMARY KEY(commande_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_produits ADD CONSTRAINT FK_680DC71682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_produits ADD CONSTRAINT FK_680DC716CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_produits DROP FOREIGN KEY FK_680DC71682EA2E54');
        $this->addSql('ALTER TABLE commande_produits DROP FOREIGN KEY FK_680DC716CD11A2CF');
        $this->addSql('DROP TABLE commande_produits');
    }
}
