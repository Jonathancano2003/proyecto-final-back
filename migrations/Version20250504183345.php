<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250504183345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Añadir columna precio a la tabla coche';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE coche ADD precio DOUBLE PRECISION NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE coche DROP precio');
    }
}
