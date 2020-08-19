<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200819192756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, referentiel_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, langue VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, contexte VARCHAR(255) DEFAULT NULL, modalite_pedagogiques VARCHAR(255) DEFAULT NULL, critere_de_performance VARCHAR(255) DEFAULT NULL, modalite_evaluation VARCHAR(255) DEFAULT NULL, avatar LONGBLOB DEFAULT NULL, date_creation DATE DEFAULT NULL, statut_brief VARCHAR(255) DEFAULT NULL, INDEX IDX_1FBB1007805DB139 (referentiel_id), INDEX IDX_1FBB1007155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_livrables_attendus (brief_id INT NOT NULL, livrables_attendus_id INT NOT NULL, INDEX IDX_3F62A6C3757FABFF (brief_id), INDEX IDX_3F62A6C3251E52B2 (livrables_attendus_id), PRIMARY KEY(brief_id, livrables_attendus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_tag (brief_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_452A4F36757FABFF (brief_id), INDEX IDX_452A4F36BAD26311 (tag_id), PRIMARY KEY(brief_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_groupe_apprenant (brief_id INT NOT NULL, groupe_apprenant_id INT NOT NULL, INDEX IDX_97F9DD76757FABFF (brief_id), INDEX IDX_97F9DD76B93A4FA9 (groupe_apprenant_id), PRIMARY KEY(brief_id, groupe_apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire_general (id INT AUTO_INCREMENT NOT NULL, fil_de_discussion_id INT DEFAULT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date DATE NOT NULL, piece_jointe LONGBLOB DEFAULT NULL, INDEX IDX_BDE1A4199E665F32 (fil_de_discussion_id), INDEX IDX_BDE1A419A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, livrable_rendu_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date DATE NOT NULL, pieces_jointes LONGBLOB DEFAULT NULL, INDEX IDX_D9BEC0C49F3E86A9 (livrable_rendu_id), INDEX IDX_D9BEC0C4155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fil_de_discussion (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date DATE NOT NULL, UNIQUE INDEX UNIQ_399E12C5D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_rendu (id INT AUTO_INCREMENT NOT NULL, livrables_partiels_id INT DEFAULT NULL, apprenant_id INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, delai DATE NOT NULL, date_de_rendu DATE DEFAULT NULL, INDEX IDX_9033AB0F2BE153F2 (livrables_partiels_id), INDEX IDX_9033AB0FC5697D6D (apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, livrables_attendus_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, INDEX IDX_FF9E7800C5697D6D (apprenant_id), INDEX IDX_FF9E7800251E52B2 (livrables_attendus_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_attendus (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrables_partiels (id INT AUTO_INCREMENT NOT NULL, promo_brief_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, delai DATE NOT NULL, date_creation DATE NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_AC3B3FEABDA08EC7 (promo_brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_livrables_partiels (niveau_id INT NOT NULL, livrables_partiels_id INT NOT NULL, INDEX IDX_2BF0F6CB3E9C81 (niveau_id), INDEX IDX_2BF0F6C2BE153F2 (livrables_partiels_id), PRIMARY KEY(niveau_id, livrables_partiels_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_brief (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, promo_brief_apprenant_id INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_F6922C91757FABFF (brief_id), INDEX IDX_F6922C91D0C07AFF (promo_id), INDEX IDX_F6922C91D7DB67BE (promo_brief_apprenant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_brief_apprenant (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, piece_jointe LONGBLOB DEFAULT NULL, INDEX IDX_939F4544757FABFF (brief_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statistiques_competences (id INT AUTO_INCREMENT NOT NULL, apprenant_id INT DEFAULT NULL, promo_id INT DEFAULT NULL, competence_id INT DEFAULT NULL, referentiel_id INT DEFAULT NULL, niveau1 VARCHAR(255) DEFAULT NULL, niveau2 VARCHAR(255) DEFAULT NULL, niveau3 VARCHAR(255) DEFAULT NULL, INDEX IDX_5C1C9F22C5697D6D (apprenant_id), INDEX IDX_5C1C9F22D0C07AFF (promo_id), INDEX IDX_5C1C9F2215761DAB (competence_id), INDEX IDX_5C1C9F22805DB139 (referentiel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE brief_livrables_attendus ADD CONSTRAINT FK_3F62A6C3757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_livrables_attendus ADD CONSTRAINT FK_3F62A6C3251E52B2 FOREIGN KEY (livrables_attendus_id) REFERENCES livrables_attendus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_tag ADD CONSTRAINT FK_452A4F36757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_tag ADD CONSTRAINT FK_452A4F36BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_groupe_apprenant ADD CONSTRAINT FK_97F9DD76757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_groupe_apprenant ADD CONSTRAINT FK_97F9DD76B93A4FA9 FOREIGN KEY (groupe_apprenant_id) REFERENCES groupe_apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire_general ADD CONSTRAINT FK_BDE1A4199E665F32 FOREIGN KEY (fil_de_discussion_id) REFERENCES fil_de_discussion (id)');
        $this->addSql('ALTER TABLE commentaire_general ADD CONSTRAINT FK_BDE1A419A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C49F3E86A9 FOREIGN KEY (livrable_rendu_id) REFERENCES livrable_rendu (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE fil_de_discussion ADD CONSTRAINT FK_399E12C5D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE livrable_rendu ADD CONSTRAINT FK_9033AB0F2BE153F2 FOREIGN KEY (livrables_partiels_id) REFERENCES livrables_partiels (id)');
        $this->addSql('ALTER TABLE livrable_rendu ADD CONSTRAINT FK_9033AB0FC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrables ADD CONSTRAINT FK_FF9E7800C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE livrables ADD CONSTRAINT FK_FF9E7800251E52B2 FOREIGN KEY (livrables_attendus_id) REFERENCES livrables_attendus (id)');
        $this->addSql('ALTER TABLE livrables_partiels ADD CONSTRAINT FK_AC3B3FEABDA08EC7 FOREIGN KEY (promo_brief_id) REFERENCES promo_brief (id)');
        $this->addSql('ALTER TABLE niveau_livrables_partiels ADD CONSTRAINT FK_2BF0F6CB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_livrables_partiels ADD CONSTRAINT FK_2BF0F6C2BE153F2 FOREIGN KEY (livrables_partiels_id) REFERENCES livrables_partiels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE promo_brief ADD CONSTRAINT FK_F6922C91D7DB67BE FOREIGN KEY (promo_brief_apprenant_id) REFERENCES promo_brief_apprenant (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F2215761DAB FOREIGN KEY (competence_id) REFERENCES competences (id)');
        $this->addSql('ALTER TABLE statistiques_competences ADD CONSTRAINT FK_5C1C9F22805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id)');
        $this->addSql('ALTER TABLE apprenant ADD promo_brief_apprenant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462ED7DB67BE FOREIGN KEY (promo_brief_apprenant_id) REFERENCES promo_brief_apprenant (id)');
        $this->addSql('CREATE INDEX IDX_C4EB462ED7DB67BE ON apprenant (promo_brief_apprenant_id)');
        $this->addSql('ALTER TABLE niveau ADD brief_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau ADD CONSTRAINT FK_4BDFF36B757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('CREATE INDEX IDX_4BDFF36B757FABFF ON niveau (brief_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_livrables_attendus DROP FOREIGN KEY FK_3F62A6C3757FABFF');
        $this->addSql('ALTER TABLE brief_tag DROP FOREIGN KEY FK_452A4F36757FABFF');
        $this->addSql('ALTER TABLE brief_groupe_apprenant DROP FOREIGN KEY FK_97F9DD76757FABFF');
        $this->addSql('ALTER TABLE niveau DROP FOREIGN KEY FK_4BDFF36B757FABFF');
        $this->addSql('ALTER TABLE promo_brief DROP FOREIGN KEY FK_F6922C91757FABFF');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544757FABFF');
        $this->addSql('ALTER TABLE commentaire_general DROP FOREIGN KEY FK_BDE1A4199E665F32');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C49F3E86A9');
        $this->addSql('ALTER TABLE brief_livrables_attendus DROP FOREIGN KEY FK_3F62A6C3251E52B2');
        $this->addSql('ALTER TABLE livrables DROP FOREIGN KEY FK_FF9E7800251E52B2');
        $this->addSql('ALTER TABLE livrable_rendu DROP FOREIGN KEY FK_9033AB0F2BE153F2');
        $this->addSql('ALTER TABLE niveau_livrables_partiels DROP FOREIGN KEY FK_2BF0F6C2BE153F2');
        $this->addSql('ALTER TABLE livrables_partiels DROP FOREIGN KEY FK_AC3B3FEABDA08EC7');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462ED7DB67BE');
        $this->addSql('ALTER TABLE promo_brief DROP FOREIGN KEY FK_F6922C91D7DB67BE');
        $this->addSql('DROP TABLE brief');
        $this->addSql('DROP TABLE brief_livrables_attendus');
        $this->addSql('DROP TABLE brief_tag');
        $this->addSql('DROP TABLE brief_groupe_apprenant');
        $this->addSql('DROP TABLE commentaire_general');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE fil_de_discussion');
        $this->addSql('DROP TABLE livrable_rendu');
        $this->addSql('DROP TABLE livrables');
        $this->addSql('DROP TABLE livrables_attendus');
        $this->addSql('DROP TABLE livrables_partiels');
        $this->addSql('DROP TABLE niveau_livrables_partiels');
        $this->addSql('DROP TABLE promo_brief');
        $this->addSql('DROP TABLE promo_brief_apprenant');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE statistiques_competences');
        $this->addSql('DROP INDEX IDX_C4EB462ED7DB67BE ON apprenant');
        $this->addSql('ALTER TABLE apprenant DROP promo_brief_apprenant_id');
        $this->addSql('DROP INDEX IDX_4BDFF36B757FABFF ON niveau');
        $this->addSql('ALTER TABLE niveau DROP brief_id');
    }
}
