<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MakeCrud extends BaseCommand
{
    protected $group       = 'Generators';
    protected $name        = 'make:crud';
    protected $description = 'Generate Migration, Model, and Controller for a given entity';

    protected $usage       = 'make:crud [EntityName]';
    protected $arguments   = [
        'EntityName' => 'The name of the entity (e.g., Type, Brand, Product)',
    ];

    public function run(array $params)
    {
        $entity = $params[0] ?? null;

        if (!$entity) {
            CLI::error('Please provide an entity name, e.g. php spark make:crud Type');
            return;
        }

        // Migration
        CLI::write('Creating Migration...', 'yellow');
        command('make:migration Create' . ucfirst($entity) . 's');

        // Model
        CLI::write('Creating Model...', 'yellow');
        command('make:model ' . ucfirst($entity) . 'Model');

        // Controller
        CLI::write('Creating Controller...', 'yellow');
        command('make:controller ' . ucfirst($entity) . 'Controller');

        CLI::write("CRUD scaffolding for {$entity} generated successfully ✅", 'green');
    }
}
