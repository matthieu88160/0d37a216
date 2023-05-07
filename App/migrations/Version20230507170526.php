<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507170526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO user(id, name, roles, password) VALUE (1, "test", \'["ROLE_ADMIN"]\', "$2y$13$xZaOoX7k/vR8.aXGQ4T63eCByvg/d0L3fZ/PC.Mr7KDc4x.BvZBk.")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM user WHERE id=1');
    }
}
