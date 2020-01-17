<?php

use Illuminate\Database\Seeder;

class AuthSeeder extends Seeder
{
    public const ROLES = [
        'public',
        'moderator',
        'admin',
        'super_admin'
    ];

    public const VERBS = [
        'view_any',
        'view',
        'create',
        'update',
        'delete',
        'restore',
        'force_delete',
    ];

    public const ENTITIES = [
        App\Models\Product::class => 'product',
        App\Models\Category::class => 'category',
    ];

    public const ACTIONS_DELIMITER = '-';

    public const ROLES_PERMISSIONS = [
        'public' => [
            'product' => [
                'view_any',
                'view',
            ],

            'category' => [
                'view_any',
                'view',
            ],
        ],

        'moderator' => [
            'product' => [
                '#except:force_delete',
            ],

            'category' => [
                'view_any',
                'view',                             
            ],
        ],

        'admin' => [
            'product' => [
                '*'
            ],

            'category' => [
                '#except:force_delete',
            ],
        ],

        'super_admin' => [
            'product' => [
                '*'
            ],

            'category' => [
                '*'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
       	$this->call(RolePermissionSeeder::class);
    }

    public static function makeAction(string $verb, string $entity)
    {
        return $verb . static::ACTIONS_DELIMITER . $entity;
    }
}
