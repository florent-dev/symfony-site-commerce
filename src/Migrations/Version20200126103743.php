<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126103743 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DE10FEE63');
        $this->addSql('DROP INDEX IDX_6EEAA67DE10FEE63 ON commande');
        $this->addSql('ALTER TABLE commande DROP lignesss_commande_id, DROP ligne_commande_id');
        $this->addSql('ALTER TABLE ligne_commande DROP FOREIGN KEY FK_3170B74B9AF8E3A3');
        $this->addSql('DROP INDEX IDX_3170B74B9AF8E3A3 ON ligne_commande');
        $this->addSql('ALTER TABLE ligne_commande DROP id_commande_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commande ADD lignesss_commande_id INT NOT NULL, ADD ligne_commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DE10FEE63 FOREIGN KEY (lignesss_commande_id) REFERENCES ligne_commande (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67DE10FEE63 ON commande (lignesss_commande_id)');
        $this->addSql('ALTER TABLE ligne_commande ADD id_commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE ligne_commande ADD CONSTRAINT FK_3170B74B9AF8E3A3 FOREIGN KEY (id_commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_3170B74B9AF8E3A3 ON ligne_commande (id_commande_id)');
    }
}
