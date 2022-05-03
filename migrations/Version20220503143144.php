<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503143144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO `user` VALUES (13,\'user@gmail.com\',\'ROLE_USER\',\'$2y$13$NQYo9W2XYAR3KogdMQjLter4FXv8TeqcWibjqSxL7sTjup/zdPKEi\',1),(15,\'admin@gmail.com\',\'ROLE_ADMIN\',\'$2y$13$BfWoYQGqJp6uUZD0VknWLOrda.pkNE1BLAEd72QcVrPI8xDDt12uC\',1);');
    }


    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
