<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $role1 = Role::create(['name' => 'Admin']);
    $role2 = Role::create(['name' => 'Blogger']);

    Permission::create(['name' => 'dashboard', 'description' => 'Ver el dashboard'])->syncRoles([$role1, $role2]);

    Permission::create(['name' => 'users.index', 'description' => 'Ver el listado de usuarios'])->syncRoles([$role1]);
    Permission::create(['name' => 'users.edit', 'description' => 'Asignar un rol'])->syncRoles([$role1]);

    Permission::create(['name' => 'categories.index', 'description' => 'Ver listado de categorías'])->syncRoles([$role1]);
    Permission::create(['name' => 'categories.create', 'description' => 'Crear categorías'])->syncRoles([$role1]);
    Permission::create(['name' => 'categories.edit', 'description' => 'Editar categorías'])->syncRoles([$role1]);
    Permission::create(['name' => 'categories.destroy', 'description' => 'Eliminar categorías'])->syncRoles([$role1]);

    Permission::create(['name' => 'tags.index', 'description' => 'Ver listado de etiquetas'])->syncRoles([$role1]);
    Permission::create(['name' => 'tags.create', 'description' => 'Crear etiquetas'])->syncRoles([$role1]);
    Permission::create(['name' => 'tags.edit', 'description' => 'Editar etiquetas'])->syncRoles([$role1]);
    Permission::create(['name' => 'tags.destroy', 'description' => 'Eliminar etiquetas'])->syncRoles([$role1]);

    Permission::create(['name' => 'posts.index', 'description' => 'Ver listado de posts'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'posts.create', 'description' => 'Crear posts'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'posts.edit', 'description' => 'Editar posts'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'posts.destroy', 'description' => 'Eliminar posts'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'posts.share', 'description' => 'Compartir post en facebook'])->syncRoles([$role1, $role2]);

    Permission::create(['name' => 'comments.index', 'description' => 'Ver listado de comentarios'])->syncRoles([$role1, $role2]);
    Permission::create(['name' => 'comments.approve', 'description' => 'Aprobar comentarios'])->syncRoles([$role1]);
    Permission::create(['name' => 'comments.destroy', 'description' => 'Eliminar comentarios'])->syncRoles([$role1]);

    Permission::create(['name' => 'roles.index', 'description' => 'Ver listado de roles'])->syncRoles([$role1]);
    Permission::create(['name' => 'roles.create', 'description' => 'Crear roles'])->syncRoles([$role1]);
    Permission::create(['name' => 'roles.edit', 'description' => 'Editar roles y permisos'])->syncRoles([$role1]);
    Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar roles'])->syncRoles([$role1]);
  }
}
