<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220310023407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, num_cmd INT NOT NULL, date_cmd DATE NOT NULL, total_cmd DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_produit (commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_DF1E9E8782EA2E54 (commande_id), INDEX IDX_DF1E9E87F347EFB (produit_id), PRIMARY KEY(commande_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, posts_id INT NOT NULL, id_post INT NOT NULL, contenu LONGTEXT NOT NULL, id_user INT NOT NULL, INDEX IDX_67F068BCD5E258C5 (posts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination (id INT AUTO_INCREMENT NOT NULL, nom_dest VARCHAR(255) DEFAULT NULL, localisation_dest VARCHAR(255) DEFAULT NULL, nbr_part_dest INT DEFAULT NULL, event_dest INT DEFAULT NULL, image_dest VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, destination VARCHAR(255) NOT NULL, prix INT DEFAULT NULL, nbr_participants INT DEFAULT NULL, nbr_participants_max INT NOT NULL, etat INT DEFAULT NULL, INDEX IDX_B26681E67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, num_fact INT NOT NULL, total_fact DOUBLE PRECISION NOT NULL, date_fact DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture_commande (facture_id INT NOT NULL, commande_id INT NOT NULL, INDEX IDX_7C15A88C7F2DEE08 (facture_id), INDEX IDX_7C15A88C82EA2E54 (commande_id), PRIMARY KEY(facture_id, commande_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, nbr_produit INT NOT NULL, total_produit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, evenements_id INT NOT NULL, users_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, INDEX IDX_D79F6B1163C02CD4 (evenements_id), INDEX IDX_D79F6B1167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, nbr_reaction INT DEFAULT NULL, nbr_commentaire INT DEFAULT NULL, etat INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, designation VARCHAR(255) NOT NULL, quantite INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_29A5EC27A21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit_panier (produit_id INT NOT NULL, panier_id INT NOT NULL, INDEX IDX_D39EC6C8F347EFB (produit_id), INDEX IDX_D39EC6C8F77D927C (panier_id), PRIMARY KEY(produit_id, panier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id_rec INT AUTO_INCREMENT NOT NULL, destination_id INT NOT NULL, type_rec VARCHAR(255) NOT NULL, description_rec VARCHAR(255) NOT NULL, etat_rec VARCHAR(255) NOT NULL, flag INT DEFAULT NULL, file VARCHAR(255) DEFAULT NULL, INDEX IDX_CE606404816C6140 (destination_id), PRIMARY KEY(id_rec)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom_reg VARCHAR(255) DEFAULT NULL, localisation_reg VARCHAR(255) DEFAULT NULL, nbr_participants_reg INT DEFAULT NULL, nbr_event_reg INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, numerotelephone VARCHAR(255) NOT NULL, photo_user VARCHAR(255) NOT NULL, nom_role VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCD5E258C5 FOREIGN KEY (posts_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE facture_commande ADD CONSTRAINT FK_7C15A88C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture_commande ADD CONSTRAINT FK_7C15A88C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1163C02CD4 FOREIGN KEY (evenements_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1167B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE produit_panier ADD CONSTRAINT FK_D39EC6C8F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_panier ADD CONSTRAINT FK_D39EC6C8F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404816C6140 FOREIGN KEY (destination_id) REFERENCES destination (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27A21214B7');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E8782EA2E54');
        $this->addSql('ALTER TABLE facture_commande DROP FOREIGN KEY FK_7C15A88C82EA2E54');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404816C6140');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1163C02CD4');
        $this->addSql('ALTER TABLE facture_commande DROP FOREIGN KEY FK_7C15A88C7F2DEE08');
        $this->addSql('ALTER TABLE produit_panier DROP FOREIGN KEY FK_D39EC6C8F77D927C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCD5E258C5');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E87F347EFB');
        $this->addSql('ALTER TABLE produit_panier DROP FOREIGN KEY FK_D39EC6C8F347EFB');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E67B3B43D');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1167B3B43D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_produit');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE destination');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE facture_commande');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_panier');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user');
    }
}
