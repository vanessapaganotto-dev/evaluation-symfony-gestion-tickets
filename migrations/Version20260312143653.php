<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260312143653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD responsable_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA353C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_97A0ADA3BCF5E72D ON ticket (categorie_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3D5E86FF ON ticket (etat_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA353C59D72 ON ticket (responsable_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3BCF5E72D');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA3D5E86FF');
        $this->addSql('ALTER TABLE ticket DROP CONSTRAINT FK_97A0ADA353C59D72');
        $this->addSql('DROP INDEX IDX_97A0ADA3BCF5E72D');
        $this->addSql('DROP INDEX IDX_97A0ADA3D5E86FF');
        $this->addSql('DROP INDEX IDX_97A0ADA353C59D72');
        $this->addSql('ALTER TABLE ticket DROP categorie_id');
        $this->addSql('ALTER TABLE ticket DROP etat_id');
        $this->addSql('ALTER TABLE ticket DROP responsable_id');
    }
}
