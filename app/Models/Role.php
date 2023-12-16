<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class Role extends Model
{
  protected $fillable = ['name', 'slug'];

  /**
   * The permissions that belong to the Role
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function permissions(): BelongsToMany
  {
      return $this->belongsToMany(Permission::class, 'roles_permissions');
  }
}