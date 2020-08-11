<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200810194325 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_apprenant_apprenant (groupe_apprenant_id INT NOT NULL, apprenant_id INT NOT NULL, INDEX IDX_BC399B73B93A4FA9 (groupe_apprenant_id), INDEX IDX_BC399B73C5697D6D (apprenant_id), PRIMARY KEY(groupe_apprenant_id, apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE groupe_apprenant_apprenant ADD CONSTRAINT FK_BC399B73B93A4FA9 FOREIGN KEY (groupe_apprenant_id) REFERENCES groupe_apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_apprenant_apprenant ADD CONSTRAINT FK_BC399B73C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_apprenant_apprenant');
    }
}
