<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224034039 extends AbstractMigration
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
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, id_post INT NOT NULL, contenu LONGTEXT NOT NULL, id_user INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, destination VARCHAR(255) NOT NULL, prix INT DEFAULT NULL, nbr_participants INT DEFAULT NULL, nbr_participants_max INT NOT NULL, etat INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, nbr_produit INT NOT NULL, total_produit INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, nbr_reaction INT DEFAULT NULL, nbr_commentaire INT DEFAULT NULL, etat INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, produit_id INT NOT NULL, panier_id INT NOT NULL, designation VARCHAR(255) NOT NULL, quantite INT DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, fournisseur_id INT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, nom_reg VARCHAR(255) DEFAULT NULL, localisation_reg VARCHAR(255) DEFAULT NULL, nbr_participants_reg INT DEFAULT NULL, nbr_event_reg INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, motpasse VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, photo_user VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE destination MODIFY id_dest INT NOT NULL');
        $this->addSql('ALTER TABLE destination DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE destination ADD localisation_dest VARCHAR(255) DEFAULT NULL, ADD event_dest VARCHAR(255) DEFAULT NULL, ADD image_dest VARCHAR(255) DEFAULT NULL, DROP geolocalisation_dest, DROP list_event_dest, CHANGE nom_dest nom_dest VARCHAR(255) DEFAULT NULL, CHANGE nbr_part_dest nbr_part_dest VARCHAR(255) DEFAULT NULL, CHANGE id_dest id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE destination ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE destination MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE destination DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE destination ADD geolocalisation_dest VARCHAR(256) NOT NULL, ADD list_event_dest VARCHAR(256) DEFAULT NULL, DROP localisation_dest, DROP event_dest, DROP image_dest, CHANGE nom_dest nom_dest VARCHAR(256) DEFAULT NULL, CHANGE nbr_part_dest nbr_part_dest INT DEFAULT NULL, CHANGE id id_dest INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE destination ADD PRIMARY KEY (id_dest)');
    }
}
