<?php
// app/Models/SaleStatus.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'creation_by', 'modified_by', 'is_deleted', 'deleted_by'];

    protected $dates = ['creation', 'modified'];

    public function creationBy()
    {
        return $this->belongsTo(User::class, 'creation_by');
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
