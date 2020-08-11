<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810205951 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_apprenant_formateur (groupe_apprenant_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_95A4A312B93A4FA9 (groupe_apprenant_id), INDEX IDX_95A4A312155D8F51 (formateur_id), PRIMARY KEY(groupe_apprenant_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_apprenant_formateur ADD CONSTRAINT FK_95A4A312B93A4FA9 FOREIGN KEY (groupe_apprenant_id) REFERENCES groupe_apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant_formateur ADD CONSTRAINT FK_95A4A312155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_apprenant_formateur');
    }
}
