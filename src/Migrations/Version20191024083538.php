<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191024083538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_store ADD shippingMethod_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_store ADD CONSTRAINT FK_2984D5BA2956B00B FOREIGN KEY (shippingMethod_id) REFERENCES sylius_shipping_method (id)');
        $this->addSql('CREATE INDEX IDX_2984D5BA2956B00B ON app_store (shippingMethod_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_store DROP FOREIGN KEY FK_2984D5BA2956B00B');
        $this->addSql('DROP INDEX IDX_2984D5BA2956B00B ON app_store');
        $this->addSql('ALTER TABLE app_store DROP shippingMethod_id');
    }
}
