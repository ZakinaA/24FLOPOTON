<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402091654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarif DROP INDEX UNIQ_E7189C9B3305F4C, ADD INDEX IDX_E7189C9B3305F4C (type_cours_id)');
        $this->addSql('ALTER TABLE tarif DROP INDEX UNIQ_E7189C9C8D8BF3D, ADD INDEX IDX_E7189C9C8D8BF3D (quotient_familial_id)');
        $this->addSql('ALTER TABLE tarif CHANGE montant montant DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarif DROP INDEX IDX_E7189C9B3305F4C, ADD UNIQUE INDEX UNIQ_E7189C9B3305F4C (type_cours_id)');
        $this->addSql('ALTER TABLE tarif DROP INDEX IDX_E7189C9C8D8BF3D, ADD UNIQUE INDEX UNIQ_E7189C9C8D8BF3D (quotient_familial_id)');
        $this->addSql('ALTER TABLE tarif CHANGE montant montant INT NOT NULL');
    }
}
