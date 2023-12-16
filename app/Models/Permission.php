<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
  /**
   * The roles that belong to the Permission
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function roles(): BelongsToMany
  {
    return $this->belongsToMany(Role::class, 'roles_permissions');
  }
}