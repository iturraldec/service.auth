<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
  protected $fillable = ['name', 'slug'];

  /**
   * The roles that belong to the Permission
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function roles()
  {
    return $this->belongsToMany(Role::class, 'roles_permissions');
  }
}